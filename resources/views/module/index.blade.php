@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Module</span> Manager</h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Module Manager</li>
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
					<th>Description</th>
					<th>Path</th>
					<th>Status</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($modules as $module){ ?>
				<tr>
					<td><?php echo $module->getStudlyName(); ?></td>
					<td>
					<?php 
						$file = file_get_contents($module->getPath().'/composer.json', true);
						echo(json_decode($file)->description);
					?>
					</td>
					<td><?php echo $module->getPath() ?></td>
					<td><?php echo $module->status; ?></td>
					<td class="text-center">
						<ul class="icons-list">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-menu9"></i>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="<?php echo route('module.changeStatus', [ 'name' => $module->getName(), 'status' => 'enable' ]) ?>"><i class="icon-cog-5"></i> Enable Module</a></li>
									<li><a href="<?php echo route('module.changeStatus', [ 'name' => $module->getName(), 'status' => 'disable' ]) ?>"><i class="icon-cog-5"></i> Disable Module</a></li>
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
