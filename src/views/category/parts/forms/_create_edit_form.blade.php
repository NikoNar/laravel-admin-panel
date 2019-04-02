@if(isset($category))
	{!! Form::model($category, ['route' => ['category-update', $category->id], 'method' => 'PUT', 'enctype' => "multipart/form-data"]) !!}
	{!! Form::hidden('id', $category->id) !!}
@else
	{!! Form::open(['route' => 'category-store', 'enctype' => "multipart/form-data"]) !!}
@endif
@if(isset($type))
	{!! Form::hidden('type', $type) !!}
@endif
<div class="col-md-12 no-padding">
	
	<div class="form-group col-md-6">
		{!! Form::label('title_en', 'Category Name Eng'); !!}
		<div class='input-group'>
		    <span class="input-group-addon">
		        <span class="fa fa-font"></span>
		    </span>
			{!! Form::text('title_en', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="form-group col-md-6">
		{!! Form::label('title_arm', 'Category Name Arm'); !!}
		<div class='input-group'>
		    <span class="input-group-addon">
		        <span class="fa fa-font"></span>
		    </span>
			{!! Form::text('title_arm', null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="clearfix"></div>
		<div class="col-md-6">
			{!! Form::label('parent_id', 'Parent Category'); !!}
			<div class="form-group">
				{{-- {!! Form::select('parent_id', ['' => 'Please Select'] + $categories ,  null, ['class' => 'form-control select2']) !!} --}}
				<select name="parent_id" id="parent_id" class="form-control select2">
					<option value="0">Choose Category</option>
					@if(isset($categories) && !empty($categories))
					    @foreach($categories as $cat)
					        <option value="{{ $cat->id }}" @if(isset($category) && $cat->id == $category->parent_id ) {!! 'selected' !!} @endif>
					            {{ $cat->title }}
					            @if(count($cat->catChilds))
					            	@if(isset($category))
						                @include('admin-panel::layouts.parts._category_child',
						                ['childs' => $cat->catChilds, 'level' => 1, 'category_id' => $category->parent_id ])
					            	@else
					            		@include('admin-panel::layouts.parts._category_child',
						                ['childs' => $cat->catChilds, 'level' => 1 ])
					            	@endif
					            @endif
					        </option>
					    @endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="col-md-6">
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
		</div>
	<div class="clearfix"></div>
	
	<hr>
	<div class="form-group">
		@if(isset($page))
			{!! Form::submit('Update', ['class' => 'btn btn-success form-control btn-flat']); !!}
		@else
			{!! Form::submit('Publish', ['class' => 'btn btn-success form-control btn-flat']); !!}
		@endif
	</div>
</div>
<div class="clearfix"></div>
		
{!! Form::close() !!}
