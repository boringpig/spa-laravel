@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-home home-icon"></i>
    <a href="{{ route('home') }}">@lang('pageTitle.dashboard')</a>
</li>
@endsection

@section('content')
    <div class="page-header">
        <h1>
            @lang('pageTitle.notification_center')
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <div id="user-profile-2" class="user-profile">
                <div class="tabbable">
                    <ul class="nav nav-tabs padding-18">
                        <li class="active">
                            <a data-toggle="tab" href="#user">
                                <i class="blue ace-icon fa fa-user bigger-120"></i>
                                修改使用者資料 
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content no-border padding-24">
                        <div id="user" class="tab-pane in active">
                            <div class="profile-feed row">
                                @forelse($notifications->chunk(2) as $notificationChunk)
                                    <div class="row">
                                    @foreach($notificationChunk as $notification)
                                        <div class="col-sm-6">
                                            <div class="profile-activity clearfix">
                                                <div>
                                                    帳號：
                                                    <a href="{{ route('users.edit', ['id' => $notification['data']['_id']]) }}"> {{ $notification['data']['name'] }} </a>，更改個人資料
                                                </div>

                                                <div class="tools action-buttons">
                                                    @if(is_null($notification['read_at']))
                                                        <a href="/notification/{{ $notification['id'] }}/read" class="green">
                                                            <i class="ace-icon fa fa-eye bigger-125"></i>
                                                        </a>
                                                    @endif
                                                    <a href="/notification/{{ $notification['id'] }}/delete" class="red">
                                                        <i class="ace-icon fa fa-trash bigger-125"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>  
                                    @endforeach  
                                    </div>
                                @empty
                                @endforelse
                            </div><!-- /.row -->

                            <div class="space-12"></div>

                            <div class="center">
                                <a type="button" href="/notification/readAll" class="btn btn-sm btn-success btn-white btn-round">
                                    <i class="ace-icon fa fa-eye bigger-150 middle green"></i>
                                    <span class="bigger-110">全部已讀 ({{ $unReadedNotificationCount }})</span>
                                </a>
                                <a type="button" href="/notification/deleteAll" class="btn btn-sm btn-danger btn-white btn-round">
                                    <i class="ace-icon fa fa-trash bigger-150 middle red"></i>
                                    <span class="bigger-110">刪除已讀 ({{ $readedNotificationCount }})</span>
                                </a>
                            </div>
                        </div><!-- /#feed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection