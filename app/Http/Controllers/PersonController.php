<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use App\Http\Requests\User\EditPersonRequest;

class PersonController extends Controller
{
    protected $userRepository;
    protected $userTransformer;

    public function __construct(
        UserRepository $userRepository,
        UserTransformer $userTransformer
    ) {
        $this->middleware(['auth','record.actionlog']);
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
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
}
