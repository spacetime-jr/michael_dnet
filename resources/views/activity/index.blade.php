@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Activity</span> Log</h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Activity Log</li>
		</ul>
	</div>
</div>
<!-- /page header -->

<script>
    $(document).ready(function () {
        $('.datatable-ajax').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('activity.ajaxListActivity')}}",
            "columns": [
                {"data": 'log_name'},
                {"data": 'subject_type'},
                {"data": 'description'},
                {"data": 'username'},
                {"data": 'created_at'},
                {"data": 'updated_at'},
            ],
            "order": [[ 4, "desc" ]]
        });
    });
</script>

<!-- Content area -->
<div class="content">
	<div class="panel panel-flat">
		<table class="table datatable-ajax">
			<thead>
				<tr>
					<th>Type</th>
					<th>Subject</th>
					<th>Description</th>
					<th>Causer</th>
					<th>Created At</th>
					<th>Updated At</th>
				</tr>
			</thead>
			<tbody>
			@php
			/*
			<?php foreach($activities as $activity){ ?>
				<tr>
					<td><?php echo $activity->log_name; ?></td>
					<td><?php echo $activity->description; ?></td>
					<td>
						<?php
						if(!empty($activity->causer_type) && !empty($activity->causer_id)){
						    $tmp = '$type = '.$activity->causer_type.'::find('.$activity->causer_id.');';
							eval('$type = '.$activity->causer_type.'::find('.$activity->causer_id.');');
							$arr = $type->toArray();
							reset($arr);
							next($arr);
							$val = key($arr);
							eval('echo($type->'.$val.');');
						}
						?>
					</td>
					<td><?php echo $activity->created_at; ?></td>
					<td><?php echo $activity->updated_at; ?></td>
				</tr>
				<?php } ?>
			*/
			@endphp
			</tbody>
		</table>
	</div>
</div>
<!-- /content area -->
@endsection
