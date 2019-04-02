<div class="form-group">
	{!! Form::label('meta[date]', 'Start Date'); !!}
	{!! Form::text('meta[date]', null, ['class' => 'form-control']); !!}	
</div>
<div class="form-group">
	{!! Form::label('meta[image]', 'Image and below'); !!}
	{!! Form::textarea('meta[image]', null, ['class' => 'form-control', 'id'=>'image']); !!}	
</div>