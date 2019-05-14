@if(isset($page)  && !isset($parent_lang_id))
	{!! Form::model($page, ['route' => ['page-update', $page->id], 'method' => 'PUT', 'enctype' => "multipart/form-data"]) !!}
	{!! Form::hidden('id', $page->id) !!}
@elseif(isset($page) && isset($parent_lang_id) )
	{!! Form::model($page, ['route' => 'page-store', 'enctype' => "multipart/form-data", 'method' => 'POST', 'id' => 'page-store']) !!}
	{!! Form::hidden('parent_lang_id', $parent_lang_id) !!}
@else
	{!! Form::open(['route' => 'page-store', 'enctype' => "multipart/form-data", 'method' => 'POST']) !!}
@endif
<div class="col-md-9 border-right">
	<div class="form-group">
		{!! Form::label('title', 'Title'); !!}
		<div class='input-group'>
		    <span class="input-group-addon">
		        <span class="fa fa-font"></span>
		    </span>
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12 no-padding">
			{!! Form::label('slug', 'Slug(Permalink)'); !!}
			<div class='input-group'>
			    <span class="input-group-addon">
			    	@if(isset($page))
			    		<a href="{!! url(buildUrl($page, array())) !!}" target="_blank">
			    			<i class="fa fa-link"></i>
			    		</a>
			    	@else
			        	<span class="fa fa-link"></span>
			    	@endif
			    </span>
			     <span class="input-group-addon no-border-right">
			        <i>
			        	@if(isset($page))
			        		{{ URL::to('/'.buildUrl($page, array(), false)) }}
			        	@else
			        		{{ URL::to('/') }}
			        	@endif
			    	/</i>
			    </span>
			    @if(isset($slugEdit) && $slugEdit == false)
					{!! Form::text('slug', null, ['class' => 'form-control', 'readonly']) !!}
			    @else
					{!! Form::text('slug', null, ['class' => 'form-control']) !!}
			    @endif
			</div>
		</div>
	</div>
	
	<div class="clearfix"></div>
	<br>
	{{-- @include('admin-panel::layouts.content-builder.index') --}}


	@if(isset($template) && $template != 'course-page' && isset($template) && $template != 'contact-page' && $template != 'index')
	<div class="form-group">
		{!! Form::label('content', 'Content'); !!}
		{!! Form::textarea('content', null, ['class' => 'form-control', 'id' => 'content', 'name' =>  'content']); !!}
	</div>
	@endif
	
	<div class="clearfix"></div>
	@if(isset($template) && $template != '')
		<hr>
		<div id="extended_template">
			@isset($lecturers)
				@include('admin-panel::page.parts.forms.'.$template, ['lecturers' => $lecturers])
				@else
				
				@include('admin-panel::page.parts.forms.'.$template)
			@endisset
			<div class="clearfix"></div>
		</div>
	@endif

	<div class="box">
	    <div class="box-header with-border">
	        <h3 class="box-title">SEO Options</h3>
	    </div>
	    <div class="box-body">
	    	<div class="form-group">
	    		{!! Form::label('meta-title', 'Meta Title'); !!}
	    		{!! Form::text('meta-title', null, ['class' => 'form-control', 'placeholder' => '%title% | %sitename%']) !!}
	    	</div>
	    	<div class="form-group">
	    		{!! Form::label('meta-description', 'Meta Description'); !!}
	    		{!! Form::text('meta-description', null, ['class' => 'form-control']) !!}
	    	</div>
	    	<div class="form-group">
	    		{!! Form::label('meta-keywords', 'Meta Keywords'); !!}
	    		{!! Form::text('meta-keywords', null, ['class' => 'form-control', 'data-role' => "tagsinput" ]) !!}
	    	</div>
	    </div>
	</div>
</div>
<div class="col-md-3">
	<div class="form-group">
		{!! Form::label('status', 'Status'); !!}
		{!! Form::select('status', ['published' => 'Published', 'unpublished' => 'Unpublished', 'draft' => 'Draft'], null, ['class' => 'form-control select2']); !!}
	</div>
	<div class="form-group">
		{!! Form::label('lang', 'Language'); !!}
		@if(isset($parent_lang_id) || (isset($page) && $page->lang == 'arm'))
			{!! Form::select('lang', ['arm' => 'Հայերեն'], null, ['class' => 'form-control select2', 'readonly']); !!}
		@else
			{!! Form::select('lang', ['en' => 'English'], null, ['class' => 'form-control select2', 'readonly']); !!}
			
		@endif
	</div>
	<div class="form-group">
		{!! Form::label('template', 'Page Template'); !!}
		{!! Form::select('template', [
								'' => 'Default Template',
								'index' => 'Index Page',
{{--								'interior' => 'Interior Page',								--}}
								'course-page' => 'Course Page',
								'contact-page' => 'Contact Page',
								'about-us' => 'About Page',
								'services' => 'Services Page',
								'publications' => 'Publications Page',
								'useful-files' => 'Useful Files Page',
								'faq' => 'FAQ Page',
								{{-- 'about-history' => 'About History',
								'films' => 'Films',
								'master-classes' => 'Master Classes', --}}
								], request()->has('template') ? request()->template : null , ['class' => 'form-control select2']); !!}
	</div>
	@if(isset($parents) && !empty($parents))
		<div class="form-group">
			{!! Form::label('parent_id', 'Parent Page'); !!}
			{!! Form::select('parent_id', [null => 'Select Parent Page'] + $parents, null, ['class' => 'form-control select2']); !!}
		</div>
	@endif
	<div class="form-group">
		{!! Form::label('thumbnail', 'Featured Image'); !!}
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail" style="width: 100%;">
				@if(isset($page) && !empty($page->thumbnail))
		  			<img src="{{$page->thumbnail}}" class="img-responsive" alt="" onerror="imgError(this);" id="thumbnail-image">
				@else
		  			<img src="{{ asset('admin-panel/images/no-image.jpg')}}" class="img-responsive" alt="No Featured Image" onerror="imgError(this);" id="thumbnail-image">
				@endif
		  	</div>
		  	<div>
		    	<span class="btn btn-file btn-primary btn-flat col-md-6 media-open">
		    		<span class="fileupload-new">Select image</span>
					{{-- {!! Form::file('thumbnail', null, ['class' => 'form-control']); !!} --}}
					{!! Form::hidden('thumbnail', null, ['id' => 'thumbnail']); !!}
				</span>
		    	<a href="javascript:void(0)" class="btn fileupload-exists btn-danger btn-flat col-md-6" data-dismiss="fileupload" id="remove-thumbnail">Remove</a>
		  		<div class="clearfix"></div>
		  	</div>
		</div>
	</div>
	@if(isset($order) && !empty($order))
		<div class="form-group">
			{!! Form::label('order', 'Order'); !!}
			{!! Form::number('order', $order, ['class' => 'form-control']) !!}
		</div>
	@else
		<div class="form-group">
			{!! Form::label('order', 'Order'); !!}
			{!! Form::number('order', null, ['class' => 'form-control']) !!}
		</div>
	@endif
	<hr>
	<div class="form-group">
		@if(isset($page))
			{!! Form::submit('Update', ['class' => 'btn btn-success form-control btn-flat']); !!}
		@else
			{!! Form::submit('Publish', ['class' => 'btn btn-success form-control btn-flat']); !!}
		@endif
	</div>
</div>

		
{!! Form::close() !!}
