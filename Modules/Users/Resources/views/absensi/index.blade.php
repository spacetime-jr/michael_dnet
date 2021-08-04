<?php $page = "approval"; ?>
@extends('layouts.app')

@section('content')
    <!-- Page header -->
    
<style>
     select[name="DataTables_Table_0_length"] {     margin-top: 8px;}
</style>
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Absensi</span> </h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Absensi </li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

    <script language="javascript">
    
    var serverDate = new Date(Date.parse("{{$serverTime}}"))

    function display_servertime() {
        serverDate.setSeconds( serverDate.getSeconds() + 1 );
        var ampm = serverDate.getHours( ) >= 12 ? ' PM' : ' AM';
        hours = serverDate.getHours( ) % 12;
        hours = hours ? hours : 12;
        hours=hours.toString().length==1? 0+hours.toString() : hours;

        var minutes=serverDate.getMinutes().toString()
        minutes=minutes.length==1 ? 0+minutes : minutes;

        var seconds=serverDate.getSeconds().toString()
        seconds=seconds.length==1 ? 0+seconds : seconds;

        var month=(serverDate.getMonth() +1).toString();
        month=month.length==1 ? 0+month : month;

        var dt=serverDate.getDate().toString();
        dt=dt.length==1 ? 0+dt : dt;

        var x1=month + "/" + dt + "/" + serverDate.getFullYear(); 
        x2 =   hours + ":" +  minutes + ":" +  seconds + " " + ampm;
        document.getElementById('serverTime').innerHTML = x2;
        
        document.getElementById('serverDate').innerHTML = x1;
        updateTime();
        }
        function updateTime(){
        var refresh=1000; // Refresh rate in milli seconds
        mytime=setTimeout('display_servertime()',refresh)
        }
        updateTime()
    </script>
   
    <!-- Content area -->
    <div class="content">

            @include('partials.notif')

            <div class="panel panel-body text-center">
                <h3 id="serverDate" class="no-margin text-semibold"></h6>
                <h6 id="serverTime" class="no-margin text-semibold"></h6>
            </div>
            <div class="panel panel-body text-center">
            
                <h6  class="no-margin text-semibold">Check In / Check Out</h6>

                @if($canCheckin)
                    <a href="{{route('absensi.checkin')}}"><button type="button" class="btn btn-success btn-float" >Check In</button></a>
                @else
                    <button type="button" class="btn btn-success btn-float disabled" >
                    Check In
                    @if(!empty($absensi->checkin))
                    <br/>
                    Anda telah melakukan Check In pada
                    <br/>
                    {{$absensi->checkin}}
                    @endif
                    </button>
                @endif
                @if($canCheckout)
                    <a href="{{route('absensi.checkout')}}"><button type="button" class="btn btn-danger btn-float" >Check Out</button></a>
                @else
                    <button type="button" class="btn btn-danger btn-float disabled">
                    Check Out
                    @if(!empty($absensi->checkout))
                    <br/>
                    Anda telah melakukan Check Out pada
                    <br/>
                    {{$absensi->checkout}}
                    @endif
                    </button>
                @endif
            </div>
    </div>
    <!-- /content area -->
@endsection
