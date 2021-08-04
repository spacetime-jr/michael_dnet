<?php
if (!isset($method)) {
    $method = 'post';
}
?>

{{ Form::open(array('action' => $action, 'method' => $method, 'class' => 'form-horizontal')) }}
<fieldset class="content-group">
    <legend class="text-bold">General Info</legend>
    <div class="form-group">
        {{ Form::label('avatar', 'Avatar', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            @include('media._popup', ['target_id' => 'mypopup'])
            <a href="{{ route('media.list') }}" class="btn btn-default btn-sm" data-toggle="modal" data-type="medialib"
               data-field="avatarimg" data-target="#mypopup">Upload Avatar</a>
            {{ Form::hidden('avatar', '', array('id' => 'avatarimg')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('fullname', 'Full Name', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('fullname', isset($user->fullname)?$user->fullname:'', array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('phone_number', 'Nomor Telepon', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('phone_number', isset($user->phone_number)?$user->phone_number:'', array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('birthplace', 'Tempat Lahir', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('birthplace', isset($user->birthplace)?$user->birthplace:'', array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('birthday', 'Tanggal Lahir', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('birthday', isset($user->birthday)?$user->birthday:'', array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('email', 'Email', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::email('email', isset($user->email)?$user->email:'', array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('password', 'Password', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            {{ Form::text('password', '', array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('role', 'Role', array('class' => 'control-label col-lg-2')) }}
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
            {{ Form::select('role', $arr, isset($currentRole)?$currentRole:'', array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('status', 'Status', array('class' => 'control-label col-lg-2')) }}
        <div class="col-lg-10">
            <?php
            $arr = array(
                    'User' => array(
                            \App\User::ACTIVE => \App\User::ACTIVE,
                            \App\User::PENDING => \App\User::PENDING,
                            \App\User::BANNED => \App\User::BANNED,
                            \App\User::SUSPENDED => \App\User::SUSPENDED,
                    )
            );
            ?>
            {{ Form::select('status', $arr,  isset($user->status)?$user->status:'', array('class' => 'form-control')) }}
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