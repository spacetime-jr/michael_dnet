<script type="text/javascript" src="<?php echo asset('assets/js/pages/gallery_library.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/plugins/uploaders/plupload/plupload.full.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('assets/js/plugins/uploaders/plupload/plupload.queue.min.js') ?>"></script>
<script>
	function uploader(){
		$(".file-uploader").pluploadQueue({
			runtimes: 'html5, html4, Flash, Silverlight',
			url: '{{ route("media.store") }}',
			chunk_size: '1Mb',
			unique_names: true,
			filters: {
				max_file_size: '3Mb',
				mime_types: [{
					title: "Image files",
					extensions: "jpg,gif,png,jpeg"
				}]
			},
			init:{
				FileUploaded: function(up, file, info) {
	                // Called when file has finished uploading
	                $('.select-image .row').empty();
	                $.get('{{route("media.listImage")}}',function(data){
	                	data.forEach(function(item,index){
	                		var html = '<div class="col-lg-3 col-sm-6">'+
								'<div class="thumbnail">'+
								'<div class="thumb" style="background: url({{url("/")}}/'+item.guid+') no-repeat;background-size:cover;height: 300px;">'+
								'<img data-id="{{url("/")}}/'+item.guid+'" src="{{url("/")}}/'+item.guid+'" alt="" style="display: none;">'+
								'<div class="caption-overflow">'+
									'<span>'+
										'<a href="#" title="Add Image" class="btn border-white text-white btn-flat btn-icon btn-rounded selectimg"><i class="icon-plus3"></i></a>'+
									'</span>'+
								'</div>'+
								'</div>'+
								'<div class="caption">'+
									'<h6 class="no-margin">'+
										'<a href="#" class="text-default">'+item.name+'</a>'+ 
									'</h6>'+
								'</div>'+
							'</div>'+
						'</div>';
						$('.select-image .row').append(html);
	                	});
	                });
	                var fileUploader = $('.upload-image').html();
	                $('.upload-image').empty().html(fileUploader);
	                uploader();
	                //$('a#uploadButton').trigger('click');
	            },
  
			}
		});
	}

		$('body').on('click', '.selectimg', function(e){
			e.preventDefault();
			$(this).parents('.thumb').toggleClass('active');
		});

		$('body').on('click', '#useimg', function(e){
			e.preventDefault();
			$('#'+media_field).val(null);
			var valueExist = false;
			$('.thumb.active').each(function(){
				var id = $(this).find('img').attr('data-id');
				if($('#'+media_field).val()){
					$('#'+media_field).val(id+','+$('#'+media_field).val());
				}else{
					$('#'+media_field).val(id);
				}
				valueExist = true;
				//console.log(id);

				currentUploadButton.parents('.form-group').find('#feat_image_display img').attr('src',id);
				//$('#feat_image_display img').attr('src',id);
			});
			if(!valueExist){
				$('#'+media_field).val(null);
			}

			$('#'+media_field).trigger('change');

		});

		uploader();		




</script>

<div class="modal-header bg-primary">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h5 class="modal-title">Media Library</h5>
</div>

<section class="upload-image">
	<div class="file-uploader"><p>Your browser doesn't have Flash installed.</p></div>
</section>

<section class="select-image">
	<div class="modal-body" style="background: #f5f5f5;">
		<div class="row">
			<?php
				foreach($medias as $media){
			?>
			<div class="col-lg-3 col-sm-6">
				<div class="thumbnail">
					<div class="thumb" style="background: url(<?php echo url($media->guid) ?>) no-repeat;background-size:cover;height: 300px;">
						<img data-id="{{url($media->guid)}}" src="<?php echo url($media->guid) ?>" alt="" style="display: none;">
						<div class="caption-overflow">
							<span>
								<a href="#" title="Add Image" /*data-popup="lightbox"*/ class="btn border-white text-white btn-flat btn-icon btn-rounded selectimg"><i class="icon-plus3"></i></a>
							</span>
						</div>
					</div>

					<div class="caption">
						<h6 class="no-margin">
							<a href="#" class="text-default"><?php echo $media->name ?></a> 
							<!-- <a href="#" class="text-muted"><i class="icon-three-bars pull-right"></i></a> -->
						</h6>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
		<button type="button" id="useimg" data-dismiss="modal" class="btn btn-primary">Use Image(s)</button>
	</div>
</section>
