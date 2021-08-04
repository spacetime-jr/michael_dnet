<?php


if (!isset($method)) {
    $method = 'post';
}
?>

<script>
    var today = moment().add(1, 'days').format('MM/DD/YYYY');
    $(document).ready(function () {
        var dateval = $("#datepicker").val();
        $("#datepicker").datepicker();
        $("#datepicker").datepicker("option", "dateFormat", "dd-mm-yy");
        if(dateval)
            $("#datepicker").datepicker("setDate", $.datepicker.parseDate("dd-mm-yy", dateval));

        $('.daterange-basic').daterangepicker({
            applyClass: 'bg-slate-600',
            minDate: today,
            cancelClass: 'btn-default'
        })
    });

    
</script>

{{ Form::open(array('action' => $action, 'method' => $method, 'class' => 'form-horizontal')) }}
<fieldset class="content-group">
    <div class="form-group">
        {{ Form::label('user', 'Cari Pegawai', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-10">
                    <input type="text" name="q" class="form-control" placeholder="Masukkan nama pegawai, username atau email">
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-block btn-success search-user">Cari <i class="icon-search4"></i></button>
                </div>
            </div>
            <span class="error-message-q" style="color: red; display: none;"> User/Pegawai tidak di temukan </span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('user_id', 'Nama Pegawai*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            <select class="select" name="user_id">
                <option disabled> Pilih Pegawai </option>
            </select>
            <span style="color:red;"> {{$errors->first('user_id')}} </span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('tanggal_cuti', 'Tanggal Ijin/Cuti', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            <div class="input-group">
                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                <input name="tanggal_cuti" type="text" class="form-control daterange-basic" value="{{$start_date}} - {{$end_date}}"> 
            </div>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('type', 'Tipe*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            <?php
            $arr = array(
                    'User' => array(
                            \Modules\Users\Entities\Ijin::CUTI => \Modules\Users\Entities\Ijin::CUTI,
                            \Modules\Users\Entities\Ijin::CUTIGAJI => \Modules\Users\Entities\Ijin::CUTIGAJI,
                            \Modules\Users\Entities\Ijin::SAKIT => \Modules\Users\Entities\Ijin::SAKIT,
                    )
            );
            ?>
            {{ Form::select('type', $arr,  isset($ijin->type)?$ijin->type:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('type')}} </span>
        </div>
    </div>
</fieldset>

<div class="text-right">
    <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
</div>
{{ Form::close() }}