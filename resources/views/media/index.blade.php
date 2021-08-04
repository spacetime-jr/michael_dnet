<?php $page='media'; ?>
@extends('layouts.app')

@section('header')
@parent
<script type="text/javascript" src="<?php echo asset('assets/js/pages/gallery_library.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/plugins/uploaders/plupload/plupload.full.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/plugins/uploaders/plupload/plupload.queue.min.js') ?>"></script>

<script>
	$(document).ready(function(){
		$(".file-uploader").pluploadQueue({
			runtimes: 'html5, html4, Flash, Silverlight',
			url: '{{ route("media.store") }}',
			unique_names: true,
			filters: {
				max_file_size: '3Mb',
				mime_types: [{
					title: "Image files",
					extensions: "jpg,gif,png,jpeg"
				}]
			},
			//resize: {
				//width: 320,
				//height: 240,
				//quality: 90
			//}
		});
	});
</script>

@endsection

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Media</span> Library</h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Media Library</li>
		</ul>
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	<div class="panel panel-flat">
		<div class="panel-body">
		@include('partials.notif')
		
		<p class="text-semibold">Upload Images</p>
		<div class="file-uploader"><p>Your browser doesn't have Flash installed.</p></div>
	
		<table class="table table-striped media-library table-lg">
			<thead>
				<tr>
					<th><input type="checkbox" class="styled"></th>
					<th>Preview</th>
					<th>Name</th>
					<th>Status</th>
					<th>Date</th>
					<th>File info</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($medias as $media){
				?>
				<tr>
					<td><input type="checkbox" class="styled"></td>
					<td>
						<a href="<?php echo url($media->guid) ?>" data-popup="lightbox">
							<img src="<?php echo url($media->guid) ?>" alt="" class="img-rounded img-preview">
						</a>
					</td>
					<td><a href="#"><?php echo $media->name ?></a></td>
					<td><?php echo $media->status ?></td>
					<td><?php echo $media->created_at ?></td>
					<td>
						<ul class="list-condensed list-unstyled no-margin">					                        		
							<li><span class="text-semibold">Size:</span> <?php echo $media->size ?> byte</li>
							<li><span class="text-semibold">Format:</span> .<?php echo $media->format ?></li>
						</ul>
					</td>
					<td class="text-center">
						<ul class="icons-list">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-menu9"></i>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a data-method="delete" data-token="{{ csrf_token() }}" href="{{ route('media.destroy', array('media' => $media)) }}"><i class="icon-bin"></i> Remove</a></li>
								</ul>
							</li>
						</ul>
					</td>
				</tr>
				<?php } ?>
			<tbody>
		</table>
		
		</div>
	</div>
</div>
<!-- /content area -->
@endsection
