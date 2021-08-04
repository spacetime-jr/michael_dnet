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
    function addOldAttribute(value){
        console.log(value);

        $('.select').select2("destroy");

        var clone = $( "#base-attr" ).clone();
        clone.attr('id',"attr-"+totalAttr)
        clone.appendTo( ".attr-containter" );

        $(".select").select2();

        $("#attr-"+totalAttr+" #attribute_id").select2('val', value);

        totalAttr++;
    }

    window.onload = function(){
        $item_attr_count = 0;
        <?php if(isset($item_attributes[0]->attribute_id)) { ?> 
            $('#attribute_id-0').select2('val', "{{$item_attributes[0]->attribute_id}}");

            <?php for($i=1; $i<count($item_attributes);$i++) { ?>
                addOldAttribute("{{$item_attributes[$i]->attribute_id}}");
            <?php } ?>

        <?php } else { ?>

            $('#attribute_id-0').select2('val', 0);
        <?php } ?>
    }
</script>

@endsection
@section('content')
        <!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            {{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Ubah Setting</span></h4> --}}
            <h4><a href="{{ route('setting.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Ubah Setting</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i>Home</a></li>
            <li><a href="{{route('setting.index')}}">Setting</a></li>
            <li class="active">Ubah Setting</li>
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

            @include('settings::setting._form', ['action' => array('\Modules\Settings\Http\Controllers\SettingsController@update', $setting->id), 'method' => 'put'])
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
