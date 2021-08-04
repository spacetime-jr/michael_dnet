<?php
if (!isset($method)) {
    $method = 'post';
}
?>

{{ Form::open(array('action' => $action, 'method' => $method, 'class' => 'form-horizontal')) }}
<fieldset class="content-group">

    <div class="form-group">
        {{ Form::label('key', 'Key', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            <?php if(!isset($setting->key)) { ?>
                {{ Form::text('key', isset($setting->key) ? $setting->key : '', array('class' => 'form-control')) }}
            <?php } else { ?>
                {{ Form::text('key', isset($setting->key) ? $setting->key : '', array('class' => 'form-control', 'readonly')) }}
            <?php } ?>
            <span style="color:red;"> {{$errors->first('key')}} </span>
        </div>
    </div>


    <div class="form-group">
        {{ Form::label('value', 'Value', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('value', isset($setting->value) ? $setting->value : '', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('value')}} </span>
        </div>
    </div>


</fieldset>
<div class="text-right">
    <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
</div>
{{ Form::close() }}