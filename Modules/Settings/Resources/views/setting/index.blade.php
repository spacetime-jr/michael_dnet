@extends('layouts.app')

@section('content')
        <!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            {{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Settings</span></h4> --}}
            <h4><a href="{{ route('setting.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Settings</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Settings</li>
        </ul>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <div class="panel" style="background-color: transparent; border:0; box-shadow: none;">
    </div>
    <div class="panel panel-flat">
        @include('partials.notif')
        <table class="table datatable-ajax" id="container">
            <thead>
            <tr>
                <th>No.</th>
                <th>Key</th>
                <th>Value</th>
                <th>Last Updated</th>
                <th>Updated by</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $counter = 0; ?>
            <?php foreach($settings as $setting){ ?>
            <tr>
                <td><?php echo ++$counter; ?></td>
                <td><?php echo $setting->key; ?></td>
                <td><?php echo $setting->value; ?></td>
                <td><?php echo $setting->updated_at; ?></td>
                <td><?php echo isset($setting->updated_by)?$setting->updated_by:'-'; ?></td>
                <td class="text-center">
                    @if (\Sentinel::getUser()->hasAccess('setting.edit'))
                    &emsp;<a href='{{ route('setting.edit', $setting->id)}}' title='Edit'><span
                                class='icon-pencil'></span></a>
                    @endif
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /content area -->
@endsection
