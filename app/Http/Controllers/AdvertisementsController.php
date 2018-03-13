<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AdvertisementRepository;
use App\Transformers\AdvertisementTransformer;
use App\Http\Requests\Advertisement\CreateAdvertisementRequest;
use App\Http\Requests\Advertisement\EditAdvertisementRequest;
use App\Http\Requests\Advertisement\ChangeFileRequest;
use Illuminate\Support\Facades\Route;

class AdvertisementsController extends Controller
{

    protected $advertisementRepository;
    protected $advertisementTransformer;

    public function __construct(
        AdvertisementRepository $advertisementRepository,
        AdvertisementTransformer $advertisementTransformer
    ) {
        $this->middleware(['auth','record.actionlog']);
        $this->middleware('role.auth', ['except' => 'changeStatus']);
        $this->advertisementRepository = $advertisementRepository;
        $this->advertisementTransformer = $advertisementTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = $this->advertisementRepository->getAllWithPermission(config('website.perPage'));
        $advertisements = (count($advertisements) > 0)? $this->advertisementTransformer->transform($advertisements)->setPath("/".Route::current()->uri()) : [];
        return view('advertisements.index', [
            'advertisements'   => $advertisements,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('advertisements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdvertisementRequest $request)
    {
        $args = [
            'name'          => $request->name,
            'round_time'    => (int) $request->round_time,
            'weeks'         => $request->weeks,
            'broadcast_area'=> $request->broadcast_area,
            'broadcast_time'=> replaceTimeColon($request->broadcast_start_time).'~'.replaceTimeColon($request->broadcast_end_time),
            'publish_at'    => $request->publish_at,
            'status'        => $request->has('status')? (int) $request->status : 0,
        ];
        // 上傳圖片/影片
        if($request->hasFile('path')) {
            $file = $request->path;
            $file_name = time().uniqid().".".$file->getClientOriginalExtension();
            $file_path = public_path()."/uploads/advertisement/";
            $args['format'] = getFileInfo($file);
            $args['path'] = "/uploads/advertisement/{$file_name}";
            checkDirectoryExists($file_path);
            $file->move($file_path, $file_name);            
        }

        $advertisement = $this->advertisementRepository->create($args);
        if(is_null($advertisement)) {
            session()->flash('error', __('form.created_fail'));
            return redirect()->back();
        }
        
        session()->flash('success', __('form.created_success'));
        return redirect()->route('advertisements.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advertisement = $this->advertisementRepository->findOneById($id);
        if(is_null($advertisement)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }
        
        $advertisement = $this->advertisementTransformer->transform($advertisement);
        return view('advertisements.edit', [
            'advertisement' => $advertisement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditAdvertisementRequest $request, $id)
    {
        $advertisement = $this->advertisementRepository->findOneById($id);
        
        if(is_null($advertisement)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }
        // 啟用/禁用 是用checkbox有選擇才有回傳值，反之沒有
        $status = $request->has('status')? 1 : 0;
        $args = [
            'name'          => $request->name,
            'round_time'    => (int) $request->round_time,
            'weeks'         => $request->weeks,
            'broadcast_area'=> $request->broadcast_area,
            'broadcast_time'=> replaceTimeColon($request->broadcast_start_time).'~'.replaceTimeColon($request->broadcast_end_time),
            'publish_at'    => new \MongoDB\BSON\UTCDateTime(strtotime("{$request->publish_at} 00:00:00") * 1000),
            'status'        => ($advertisement->status != $status)? $status : $advertisement->status,
        ];

        if($this->advertisementRepository->update($id, $args)) {
            session()->flash('success', __('form.updated_success'));
            return redirect()->route('advertisements.index');
        }

        session()->flash('error', __('form.updated_fail'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $advertisement = $this->advertisementRepository->findOneById($id);
            if(is_null($advertisement)) {
                throw new \Exception(__('message.no_data'));
            }
            if(! $this->advertisementRepository->delete($id)) {
                throw new \Exception(__('message.delete_fail'));
            }
            if(file_exists(public_path($advertisement['path']))) {
                unlink(public_path($advertisement['path']));
            }
            return response()->json(successOutput($advertisement), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }

    public function search(Request $request)
    {
        $advertisements = $this->advertisementRepository->getByArgs($request->getQueryString(),$request->all(),config('website.perPage'));
        $advertisements = (count($advertisements) > 0)? $this->advertisementTransformer->transform($advertisements)->appends($request->all())->setPath("/{$request->path()}") : [];
        $request->flash();
        return view('advertisements.index', [
            'advertisements'    => $advertisements,
        ]);
    }

    public function changeFile(ChangeFileRequest $request, $id)
    {
        try {
            $advertisement = $this->advertisementRepository->findOneById($id);
            if(is_null($advertisement)) {
                throw new \Exception(__('message.no_data'));
            }
            // 上傳圖片
            $args = [];
            if($request->hasFile('path')) {
                $file = $request->path;
                $file_name = time().uniqid().".".$file->getClientOriginalExtension();
                $file_path = public_path()."/uploads/advertisement/";
                $args['format'] = getFileInfo($file);
                $args['path'] = "/uploads/advertisement/{$file_name}";
                checkDirectoryExists($file_path);
                $file->move($file_path, $file_name);            
                // 刪除先前的圖片/影片
                unlink(public_path($advertisement->path));
            }
            if(! $this->advertisementRepository->update($id, $args)) {
                throw new \Exception(__('message.change_image_or_video_fail'));
            } 
            return response()->json(successOutput($advertisement), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $advertisement = $this->advertisementRepository->findOneById($id);
            if(is_null($advertisement)) {
                throw new \Exception(__('message.no_data'));
            }
            $args = [
                'status' => (int) $request->status,
            ];
            if(! $this->advertisementRepository->update($id, $args)) {
                throw new \Exception(__('message.change_status_fail'));
            } 
            return response()->json(successOutput($advertisement), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }
}
