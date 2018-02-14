<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use App\Transformers\NotificationTransformer;
use App\Http\Requests\User\EditPersonRequest;
use Auth;

class PersonController extends Controller
{
    protected $userRepository;
    protected $userTransformer;
    protected $notificationTransformer;

    public function __construct(
        UserRepository $userRepository,
        UserTransformer $userTransformer,
        NotificationTransformer $notificationTransformer
    ) {
        $this->middleware(['auth','record.actionlog']);
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
        $this->notificationTransformer = $notificationTransformer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person = $this->userRepository->findOneById($id);

        if(is_null($person)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }
        $person = $this->userTransformer->transform($person);
        return view('person.edit', [
            'person' => $person,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPersonRequest $request, $id)
    {
        $person = $this->userRepository->findOneById($id);

        if(is_null($person)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }
        $args = [
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
        ];
        if($this->userRepository->update($id, $args)) {
            session()->flash('success', __('form.updated_success'));
            return redirect()->back();
        }

        session()->flash('error', __('form.updated_fail'));
        return redirect()->back();
    }

    public function notifications()
    {
        return view('person.notification', [
            'notifications'             => $this->notificationTransformer->transform(Auth::user()->notifications),
            'readedNotificationCount'   => Auth::user()->readNotifications->count(),
            'unReadedNotificationCount' => Auth::user()->unReadNotifications->count(),
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->unReadNotifications()->find($id);
        if(!is_null($notification)) {
            $notification->markAsRead();
            session()->flash('success', '標記已讀成功');
            return redirect()->back();
        }

        session()->flash('error', '標記已讀失敗');
        return redirect()->back();
    }

    public function delete($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if(!is_null($notification) && $notification->delete()) {
            session()->flash('success', '刪除通知成功');
            return redirect()->back();
        }

        session()->flash('error', '刪除通知失敗');
        return redirect()->back();
    }

    public function markAsReadAll()
    {
        $notifications = Auth::user()->unReadNotifications()->get();

        if($notifications->count()) {
            $notifications->markAsRead();
            session()->flash('success', '標記已讀成功');
            return redirect()->back();
        } else {
            session()->flash('error', '無任何未讀的通知');
            return redirect()->back();
        }

        session()->flash('error', '標記已讀失敗');
        return redirect()->back();
    }

    public function deleteAll()
    {
        if(Auth::user()->readNotifications->count() == 0) {
            session()->flash('error', '無任何已讀的通知');
            return redirect()->back();
        }

        if(Auth::user()->readNotifications()->delete()) {
            session()->flash('success', '刪除通知成功');
            return redirect()->back();
        }

        session()->flash('error', '刪除通知失敗');
        return redirect()->back();
    }
}
