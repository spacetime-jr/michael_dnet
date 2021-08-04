<?php $page = "customer"; ?>
@extends('layouts.app')

@section('content')

<style>
     select[name="DataTables_Table_0_length"] {     margin-top: 8px;}
     .ui-datepicker-calendar {
    display: none;
    }
    th {
        background-color: #001f3f;
        color: #fff;
        padding: 0.5em 1em;
    }

    td {
        border-top: 1px solid #eee;
    }

    tr {
       
        padding: 1em 1em;
    }

    input {
        cursor: pointer;
    }

    /* Column types */
    th.missed-col {
        background-color: #f00;
    }
    th.attendance-date {
        background-color: #00bcd4;
        text-align:center;
    }
    td.missed-col {
        background-color: #ffecec;
        color: #f00;
        text-align: center;
    }

    .name-col {
        text-align: left;
        min-width:200px;
    }

    .attend-col {
        
        text-align:center;
    }


</style>
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                {{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">User</span></h4> --}}
                <h4><a href="{{ route('report.absensi') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Report Absensi</span></h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Report Absensi</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <script>
        $(document).ready(function () {
            $('.datatable-ajax').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('hr.listHr')}}",
                'columnDefs': [ {
                    'targets': [5], 
                    'orderable': false, 
                }],
                "columns": [
                    {"data": 'username'},
                    {"data": 'email'},
                    {"data": 'fullname'},
                    {"data": 'status'},
                    {"data": 'created_at'},
//                    {"data": 'updated_at'},
                    {"data": 'actions'},
                ]
            });

            $('.date-picker-monthyear').datepicker({
                dateFormat: "mm/yy",
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                onClose: function(dateText, inst) {


                    function isDonePressed(){
                        return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
                    }

                    if (isDonePressed()){
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');
                        
                            $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
                    }
                },
                beforeShow : function(input, inst) {

                    inst.dpDiv.addClass('month_year_datepicker')
                    console.log($(this).val());
                    if ((datestr = $(this).val()).length > 0) {
                        year = datestr.substring(datestr.length-4, datestr.length);
                        month = datestr.substring(0, 2);
                        $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                        $(this).datepicker('setDate', new Date(year, month-1, 1));
                        $(".ui-datepicker-calendar").hide();
                    }
                }
            });
        });
    </script>
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                {{ Form::open(array('method' => 'get', 'class' => 'form-horizontal')) }}
                <label for="monthYear">Bulan/Tahun :</label>
                <input name="monthYear" id="monthYear" class="date-picker-monthyear" value="{{!empty($monthYear)?$monthYear:''}}"/>
                <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
                {{ Form::close() }}
            </div>
        </div>

        <div class="panel panel-flat overflow-auto">
            @include('partials.notif')

            <table class="table table-bordered table-lg table-responsive">
                <thead>
                    <tr>
                    <th class="name-col">Nama</th>
                    @php
                        $date = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    @endphp
                    @for($i = 1 ; $i <= $date; $i++)
                    <th class='attendance-date'>{{$i}}</th>
                    @endfor
                    </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @foreach($data as $key => $val)
                        <tr class="student">
                        <td class="name-col">{{$key}}</td>
                        @php
                            $date = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            for($i = 1 ; $i <= $date; $i++){
                                $pad = str_pad($i, 2, '0', STR_PAD_LEFT); 
                                if(empty($val[$year.'-'.$month.'-'.$pad])){
                                    @endphp
                                    <td class="attend-col">
                <span class="badge badge-danger position-center">X</span></td>
                                    @php 
                                }else{
                                    switch($val[$year.'-'.$month.'-'.$pad]){
                                        case 'checkedout':
                                            @endphp
                                                <td class="attend-col">
                <span class="badge badge-success position-center">V</td>
                                            @php
                                            break;
                                        case 'checkedin':
                                            @endphp
                                                <td class="attend-col">
                <span class="badge badge-warning position-center">NC</span></td>
                                            @php
                                            break;
                                        case 'cuti':
                                            @endphp
                                                <td class="attend-col">
                <span class="badge badge-warning position-center">C</span></td>
                                            @php
                                            break;
                                        case 'cuti potong gaji':
                                            @endphp
                                                <td class="attend-col">
                <span class="badge badge-info position-center">CG</span></td>
                                            @php
                                            break;
                                        case 'sakit':
                                            @endphp
                                                <td class="attend-col">
                <span class="badge position-center">A</span></td>
                                            @php
                                            break;
                                            
                                        default:
                                            @endphp
                                            <td class="attend-col"><input type="checkbox"  disabled></td>
                                            @php
                                            break;
                                    }
                                }
                            }
                        @endphp
                        
                    @endforeach
                @endif
                    
                    
                    
                    </tr>
                </tbody>
                </table>
        </div>

        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Keterangan</h5>
                
            </div>
            <div class="panel-body">
            
                <p class="content-group">
                <span class="badge badge-success position-left">V</span>Hadir</p>
                <p class="content-group">
                <span class="badge badge-warning position-left">C</span>Cuti</p>
                <p class="content-group">
                <span class="badge badge-primary position-left">NC</span>Belum Checkout</p>
                <p class="content-group">
                <span class="badge badge-danger position-left">X</span>Kosong / Libur</p>
                <p class="content-group">
                <span class="badge badge-info position-left bg-danger-500">CG</span>Cuti / Ijin Potong Gaji</p>
                <p class="content-group">
                <span class="badge position-left">A</span>Sakit</p>

                
            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
