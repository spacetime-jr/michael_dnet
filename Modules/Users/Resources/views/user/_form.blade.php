<?php
if (!isset($method)) {
    $method = 'post';
}
?>

@php
    $date = null;
        if(!empty($user->birthday))
            $date = new \DateTime($user->birthday);
@endphp
<script>
    $(document).ready(function () {
        var dateval = $("#datepicker").val();
        $("#datepicker").datepicker();
        $("#datepicker").datepicker("option", "dateFormat", "dd-mm-yy");
        if(dateval)
            $("#datepicker").datepicker("setDate", $.datepicker.parseDate("dd-mm-yy", dateval));
    })
</script>

{{ Form::open(array('action' => $action, 'method' => $method, 'class' => 'form-horizontal')) }}
<fieldset class="content-group">
    <div class="form-group">
        {{ Form::label('email', 'Email*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::email('email', isset($user->email)?$user->email:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('email')}} </span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('fullname', 'Full Name*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('fullname', isset($user->fullname)?$user->fullname:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('fullname')}} </span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('username', 'Username*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('username', isset($user->username)?$user->username:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('username')}} </span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('gender', 'Jenis Kelamin*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            <?php
            $arr = array(
                    'Jenis Kelamin' => array(
                            'male' => 'PRIA',
                            'female' => 'WANITA',
                    )
            );
            ?>
            {{ Form::select('gender', $arr,  isset($user->gender)?$user->gender:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('gender')}} </span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('phone_number', 'Nomor Telepon*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('phone_number', isset($user->phone_number)?$user->phone_number:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('phone_number')}} </span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('address', 'Alamat*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('address', isset($user->address)?$user->address:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('address')}} </span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('birthday', 'Tanggal Lahir', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('birthday', isset($user->birthday)? $date->format('d-m-Y'):'', array('class' => 'form-control', 'id' => 'datepicker')) }}
            <span style="color:red;"> {{$errors->first('birthday')}} </span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('birthplace', 'Tempat Lahir*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('birthplace', isset($user->birthplace)?$user->birthplace:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('birthplace')}} </span>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('gaji', 'Gaji*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('gaji', isset($user->gaji)?$user->gaji:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('gaji')}} </span>
        </div>
    </div>


    <div class="form-group">
        {{ Form::label('password', 'Password', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::password('password', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('password')}} </span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('role', 'Role*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            <?php
            $arr = array(
                    'Status' => array()
            );
            foreach ($roles as $role) {
                $arr['Status'][$role->slug] = $role->name;
            }
            //dd($currentRole);
            ?>
            {{ Form::select('role', $arr, isset($currentRole)?$currentRole:'customer', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('role')}} </span>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status*', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            <?php
            $arr = array(
                    'User' => array(
                            \App\User::ACTIVE => \App\User::ACTIVE,
                            \App\User::INACTIVE => \App\User::INACTIVE,
                            \App\User::PENDING => \App\User::PENDING,
                            \App\User::BANNED => \App\User::BANNED,
                            \App\User::SUSPENDED => \App\User::SUSPENDED,
                    )
            );
            ?>
            {{ Form::select('status', $arr,  isset($user->status)?$user->status:'', array('class' => 'form-control')) }}
            <span style="color:red;"> {{$errors->first('status')}} </span>
        </div>
    </div>
</fieldset>
<?php if(isset($currentRole)){?>
<input type="hidden" name="old_role" value="<?php echo $currentRole?>">
<?php } ?>
<div class="text-right">
    <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
</div>
{{ Form::close() }}