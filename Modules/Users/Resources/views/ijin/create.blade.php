@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			{{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">User</span> </h4> --}}
			<h4><a href="{{ route('ijin.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Pengajuan Ijin</span> </h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
			<li><a href="{{route('ijin.index')}}"> Pengajuan Ijin </a></li>
			<li class="active">Create</li>
		</ul>
	</div>
</div>
<!-- /page header -->
<script>

	console.log($(document).find('.search-user'));
	$(document).on('click', '.search-user', function(e){
		e.preventDefault();
		var el 		= $(this);
		var oldHtml = el.html();
		var data 	= {
			q : $('input[name=q]').val()
		};
		jQuery.ajax({
            url     : "{{route('users.ajaxListAutocomplete')}}",
            type    : 'GET',
            data    : data,
            dataType: 'JSON',
            beforeSend: function()
            {
				el.html('Proses .....');
				$('.error-message-q').hide();
				$('.select').select2('destroy');
            	$('.select').html('');
            },
            success: function(result)
            {
            	if(result.code == 200)
            	{	
            		jQuery.each(result.data, function(key, val){
            			var option = '<option value="'+val['id']+'">'+val['fullname']+'('+val['username']+')</option>';
            			$('.select').append(option);
            		});
				}
				else
				{
					$('.error-message-q').show();
				}
            	$('.select').select2();
            	el.html(oldHtml);

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log('error in server');
                console.log(errorThrown);
                console.log(textStatus);
                console.log(jqXHR);
            }         
        });
	});
</script>
<!-- Content area -->
<div class="content">
	<div class="panel panel-flat">
		@include('partials.notif')
	

		<div class="panel-body">

			@include('users::ijin._form', ['action' => '\Modules\Users\Http\Controllers\IjinController@store'])
		</div>
	</div>
</div>
<!-- /content area -->
@endsection
