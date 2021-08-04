@extends('layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Barang</span> Detail
                </h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li><a href="{{route('item.index')}}">Barang</a></li>
                <li class="active">Barang Detail</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <div class="panel" style="background-color: transparent; border:0; box-shadow: none;">
            @if(\Sentinel::getUser()->hasAccess('item.create'))
                <a href="{{route('item.create')}}">
                    <button type="button" class="btn btn-success btn-labeled btn-lg"><b><i class="icon-plus3"></i></b>
                        Create
                    </button>
                </a>
            @endif

            @if(\Sentinel::getUser()->hasAccess('item.edit'))
                <a href="{{route('item.edit', $item->id)}}">
                    <button type="button" class="btn btn-primary btn-labeled btn-lg"><b><i class="icon-pencil"></i></b>
                        Edit
                    </button>
                </a>
            @endif

            @if(\Sentinel::getUser()->hasAccess('item.delete'))
                <a href="{{route('item.delete', $item->id)}}" class="confirmAction">
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
                                {{$item->id}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">product_id</label>
                            <div class="control-label col-lg-10">
                                {{$item->product_id}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">attribute_ids</label>
                            <div class="control-label col-lg-10">
                                <?php foreach ($item_attributes as $item_attribute) { ?> 
                                    {{$item_attribute->attribute_id}} <br>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">display_name</label>
                            <div class="control-label col-lg-10">
                                {{$item->display_name}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">price</label>
                            <div class="control-label col-lg-10">
                                {{number_format($item->price)}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">item_code</label>
                            <div class="control-label col-lg-10">
                                {{$item->item_code}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Status</label>
                            <div class="control-label col-lg-10">
                                {{$item->status}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Created by</label>
                            <div class="control-label col-lg-10">
                                {{$item->created_by}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Updated by</label>
                            <div class="control-label col-lg-10">
                                {{$item->updated_by}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Created at</label>
                            <div class="control-label col-lg-10">
                                {{date('j M Y h:i a',strtotime($item->created_at))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Updated at</label>
                            <div class="control-label col-lg-10">
                                {{date('j M Y h:i a',strtotime($item->updated_at))}}
                            </div>
                        </div>
                        
                    </fieldset>
                </div>

            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
