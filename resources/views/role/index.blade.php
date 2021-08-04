<?php $page = "role"; ?>
@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">User</span> Roles</h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Roles</li>
		</ul>
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	<div class="panel panel-flat">
		<table class="table datatable-basic">
			<thead>
				<tr>
					<th>Name</th>
					<th>Slug</th>
					<th>Permission</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($roles as $role){ ?>
				<tr>
					<td><?php echo $role->name; ?></td>
					<td><?php echo $role->slug; ?></td>
					<td><?php echo json_encode($role->permissions); ?></td>
					<td class="text-center">
					-
						<!--
						<ul class="icons-list">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-menu9"></i>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#"><i class="icon-cog-5"></i> Update Permissions</a></li>
									<li><a href="#"><i class="icon-cog-5"></i> Remove</a></li>
								</ul>
							</li>
						</ul>
						-->
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<!-- /content area -->
@endsection
