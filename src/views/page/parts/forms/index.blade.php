<div class="form-group">
    <div class="box-header with-border">
		{!! Form::label('gallery', 'Slider'); !!}
        <span class="btn btn-file btn-primary btn-flat media-open multichoose pull-right" >
	        <span class="fileupload-new">Select Images</span>
	        {!! Form::hidden('gallery', null, ['id' => 'images']); !!}
	    </span>
    </div>
    <div>
        @if(isset($page->slider) && !empty($page->slider) && isJson($page->slider))
			@php
				$gallery = json_decode($page->slider);
			@endphp
		@endif
    	<div class="clearfix"></div>
    	   <div class="gallery-show-container col-md-3-gallery" id="sortable-grid">
	        <div class="empty-gallery" style="padding-top: 20px; color: #fff; text-transform: uppercase; font-size: 14px; text-align: center; min-height: 300px; background: linear-gradient(-140deg, #36fcef 0%, #1fc8db 51%, #2cb5e8 75%); {{isset($gallery) && !empty($gallery) ? 'display: none;' : null }}">
	         <i class="fa fa-arrow-up" style="font-size: 14px; margin-right: 10px; margin-left: 10px;"></i>
	         Select Images for fill the gallery.
	        </div>
			@if(!empty($gallery))
	            @foreach($gallery as $image)
	                <div class="media-item">
	                    <i class="fa fa-times-circle remove"></i>
	                    <i class="fa fa-arrows-alt gallery-image-sort"></i>
	                    @if(is_url($image->url))
	                    	<img src="{!! $image->url !!}" class="thumbnail">
	                    @else
	                    	<img src="{!! url('media/icon_size').'/'.$image->url !!}" class="thumbnail">
	                    @endif
	                    <input name="thumbnail-alt" class="form-control" value="{!! $image->alt !!}" placeholder="Alt Name">
	                </div>
	            @endforeach
            @endif

    	</div>

    	@if(isset($gallery) && !empty($gallery))
    	    <script type="text/javascript">
    	        var galleryImagesArr = [];
    	        @foreach($gallery as $image)
    	        	galleryImagesArr.push({'url': '{!! $image->url !!}', 'alt': '{!! $image->alt !!}' });
    	        @endforeach
    	        // console.log(JSON.stringify(galleryImagesArr));
    	    </script>
    	@endif
    </div>
</div>
<div class="form-group">
	{!! Form::label('meta[courses]', 'Courses'); !!}
	{!! Form::textarea('meta[courses]', null, ['class' => 'form-control', 'id'=>'courses']); !!}	
</div>
<div class="form-group">
	{!! Form::label('meta[content]', 'Content'); !!}
	{!! Form::textarea('meta[content]', null, ['class' => 'form-control', 'id'=>'content']); !!}	
</div>