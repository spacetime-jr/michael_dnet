<?php $page = "customer"; ?>
@extends('layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			{{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">User</span> </h4> --}}
			<h4><a href="{{ route('hr.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Human Resources</span> </h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
			<li><a href="{{route('hr.index')}}"> Human Resources </a></li>
			<li class="active">Show</li>
		</ul>
	</div>
</div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <div class="panel" style="background-color: transparent; border:0; box-shadow: none;">
            @if(\Sentinel::getUser()->hasAccess('user.create'))
                <a href="{{route('users.create')}}">
                    <button type="button" class="btn btn-success btn-labeled btn-lg"><b><i class="icon-plus3"></i></b>
                        Create
                    </button>
                </a>
            @endif

            @if(\Sentinel::getUser()->hasAccess('user.edit'))
                <a href="{{route('users.edit', $user->id)}}">
                    <button type="button" class="btn btn-primary btn-labeled btn-lg"><b><i class="icon-pencil"></i></b>
                        Edit
                    </button>
                </a>
            @endif

            @if(\Sentinel::getUser()->hasAccess('user.delete'))
                <a href="{{route('users.deleteUser', $user->id)}}" class="confirmAction">
                    <button type="button" class="btn btn-danger btn-labeled btn-lg"><b><i class="icon-trash"></i></b>
                        Delete
                    </button>
                </a>
            @endif
        </div>

        <div class="panel panel-flat">
            @include('partials.notif')
            <div class="panel-body">
                <div class="form-horizontal">
                    <fieldset class="content-group">
                        <legend class="text-bold">General Info</legend>
                        <div class="form-group">
                            <label class="control-label col-lg-2">ID</label>
                            <div class="control-label col-lg-10">
                                {{$user->id}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Email</label>
                            <div class="control-label col-lg-10">
                                {{$user->email}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Aktivitas Terakhir</label>
                            <div class="control-label col-lg-10">
                                {{date('j M Y h:i a',strtotime($user->last_activity))}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Nama</label>
                            <div class="control-label col-lg-10">
                                {{$user->fullname}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Username</label>
                            <div class="control-label col-lg-10">
                                {{$user->username}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Telepon</label>
                            <div class="control-label col-lg-10">
                                {{$user->phone_number}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Tempat Lahir</label>
                            <div class="control-label col-lg-10">
                                {{!empty($user->birthplace)?$user->birthplace:'-'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Tanggal Lahir</label>
                            <div class="control-label col-lg-10">
                                {{(!empty($user->birthday)?date('j M Y',strtotime($user->birthday)):'-')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Poin</label>
                            <div class="control-label col-lg-10">
                                {{number_format($user->points)}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Saldo</label>
                            <div class="control-label col-lg-10">
                                {{number_format($user->balance)}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Gender</label>
                            <div class="control-label col-lg-10">
                                {{(!empty($user->gender)?$user->gender:'-')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Alamat</label>
                            <div class="control-label col-lg-10">
                                {{$user->address}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Status</label>
                            <div class="control-label col-lg-10">
                                {{$user->status}}
                            </div>
                        </div>
                    </fieldset>
                </div>

            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
