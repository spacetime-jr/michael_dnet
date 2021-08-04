<?php
	if(!isset($method)){
		$method = 'post';
	}
?>

{{ Form::open(array('action' => $action, 'method' => $method, 'class' => 'form-horizontal')) }}
	<fieldset class="content-group">
		<legend class="text-bold">General Info</legend>
		<div class="form-group">
			{{ Form::label('email', 'Email', array('class' => 'control-label col-lg-2')) }}
			<div class="col-lg-10">
				{{ Form::email('email', '', array('class' => 'form-control')) }}
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
					foreach($roles as $role){
						$arr['Status'][$role->slug] = $role->name;
					}
				?>
				{{ Form::select('role', $arr, '', array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('status', 'Status', array('class' => 'control-label col-lg-2')) }}
			<div class="col-lg-10">
				<?php
					$arr = array(
						'User' => array(
							\App\User::PENDING => \App\User::PENDING,
							\App\User::BANNED => \App\User::BANNED,
							\App\User::SUSPENDED => \App\User::SUSPENDED,
						)
					);
				?>
				{{ Form::select('status', $arr, '', array('class' => 'form-control')) }}
			</div>
		</div>
	</fieldset>

	<div class="text-right">
		<button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
	</div>
{{ Form::close() }}