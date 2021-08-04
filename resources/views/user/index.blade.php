<?php $page = "user"; ?>
@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">User</span></h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">User</li>
		</ul>
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	<div class="panel panel-flat">
		@include('partials.notif')
	
		<table class="table datatable-basic">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Status</th>
					<th>Last Login</th>
					<th>Created At</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($users as $user){ ?>
				<tr>
					<td><?php echo $user->fullname; ?></td>
					<td><?php echo $user->email; ?></td>
					<td><?php echo \Sentinel::findById($user->id)->roles[0]->name; ?></td>
					<td><?php echo $user->status; ?></td>
					<td><?php echo $user->last_login ?></td>
					<td><?php echo $user->created_at; ?></td>
					<td class="text-center">
						<ul class="icons-list">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-menu9"></i>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="{{route('user.edit',$user->id)}}"><i class="icon-cog5"></i>Edit User</a></li>
									@if($user->status != \App\User::BANNED)
									<li><a href="{{ route('user.changeStatus', ['id' => $user->id, 'status' => \App\User::BANNED]) }}"><i class="icon-cog5"></i> Ban User</a></li>
									@elseif($user->status == \App\User::BANNED)
									<li><a href="{{ route('user.changeStatus', ['id' => $user->id, 'status' => \App\User::ACTIVE]) }}"><i class="icon-cog5"></i> Release Ban</a></li>
									@endif
									
									@if($user->status != \App\User::SUSPENDED)
									<li><a href="{{ route('user.changeStatus', ['id' => $user->id, 'status' => \App\User::SUSPENDED]) }}"><i class="icon-cog5"></i> Suspend User</a></li>
									@elseif($user->status == \App\User::SUSPENDED)
									<li><a href="{{ route('user.changeStatus', ['id' => $user->id, 'status' => \App\User::ACTIVE]) }}"><i class="icon-cog5"></i> Unsuspend User</a></li>
									@endif
									
									<?php 
										$u = \Sentinel::findById($user->id);
										if(\Activation::completed($u) && $user->status != \App\User::PENDING){ 
									?>
									<li><a href="{{ route('user.changeStatus', ['id' => $user->id, 'status' => \App\User::INACTIVE]) }}"><i class="icon-cog5"></i> Deactivated User</a></li>
									<?php }else{ ?>
									<li><a href="{{ route('user.changeStatus', ['id' => $user->id, 'status' => \App\User::ACTIVE]) }}"><i class="icon-cog5"></i> Activated User</a></li>
									<?php } ?>
									<li><a href="{{ route('user.destroy', ['user' => $user]) }}" data-method="delete" data-token="{{ csrf_token() }}">Remove</a></li>
								</ul>
							</li>
						</ul>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<!-- /content area -->
@endsection
