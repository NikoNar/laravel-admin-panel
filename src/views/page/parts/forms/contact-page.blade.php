<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Contact Details</h3>
    </div>
    <div class="box-body">
	    <div class="col-md-4 no-padding">
	    	<div class="form-group">
	    		{!! Form::label('meta[contact_phone_number]', 'Telephone'); !!}
	    		<div class='input-group'>
	    		    <span class="input-group-addon">
	    		        <span class="fa fa-phone"></span>
	    		    </span>

	    			{!! Form::text('meta[contact_phone_number]', null, ['class' => 'form-control']) !!}
	    		</div>
	    	</div>
	    </div>
	    <div class="col-md-4 no-padding">
	    	<div class="form-group">
	    		{!! Form::label('meta[contact_phone_number_ceo]', 'Telephone CEO'); !!}
	    		<div class='input-group'>
	    		    <span class="input-group-addon">
	    		        <span class="fa fa-phone"></span>
	    		    </span>
	    			{!! Form::text('meta[contact_phone_number_ceo]', null, ['class' => 'form-control']) !!}
	    		</div>
	    	</div>
	    </div>
	    <div class="col-md-4 no-padding">
	    	<div class="form-group">
	    		{!! Form::label('meta[contact_email_address]', 'Email'); !!}
	    		<div class='input-group'>
	    		    <span class="input-group-addon">
	    		        <span class="fa fa-envelope"></span>
	    		    </span>
	    			{!! Form::text('meta[contact_email_address]', null, ['class' => 'form-control']) !!}
	    		</div>
	    	</div>
	    </div>
	</div>
</div>