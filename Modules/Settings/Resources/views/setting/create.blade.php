@extends('layouts.app')


@section('header')
<style>
    .selectStyle {
        margin-bottom: 10px;
        margin-left: 10px;
        width: 50%;
    }
    #base-attr {
        display: none;
    }
</style>
<script>
    var totalAttr = 1;
    jQuery(document).ready(function(){
        $('.select').select2();
        });
    function addAttribute(){
         $('.select').select2("destroy");
        var clone = $( "#base-attr" ).clone().attr('id',"attr-"+totalAttr).appendTo( ".attr-containter" );
        $(".select").select2();
        totalAttr++;
    }
    function deleteAttribute(me){
        me.parentNode.remove();
    }
</script>

@endsection
@section('content')
        <!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Setting Baru</span>
            </h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('setting.index')}}">Setting</a></li>
            <li class="active">Setting Baru</li>
        </ul>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <div class="panel panel-flat">
        @include('partials.notif')


        <div class="panel-body">
            <p class="content-group-lg"></p>

            @include('settings::setting._form', ['action' => '\Modules\Settings\Http\Controllers\SettingsController@store'])
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
