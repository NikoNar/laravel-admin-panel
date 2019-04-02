<table id="sortable-table" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="3%" class="no-sort"><input type="checkbox" name="checked" onClick="checkAll(this)"></th>
					
			<th width="20%">Name</th>
			<th width="15%">Email</th>
			<!-- <th width="25%">About</th> -->
			{{-- <th width="15%">Language</th> --}}
			<th width="8%">Phone</th>
			<th width="8%">Course</th>
			<th width="25%">Comments</th>
			<th>Suggestion</th>
			<th>Materials</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@foreach($applications as $key => $item)
			@include('admin-panel::application.parts.item')
		@endforeach
	</tbody>
</table>
<div class="clearfix"></div>
<div class="col-md-6 pull-left"><div class="dataTables_info" id="data-table_info" role="status" aria-live="polite">Showing  to {!! $applications->perPage() * $applications->currentPage() !!} of {!! $applications->total() !!} entries</div></div>
<div class="pull-right ">{!! $applications->links() !!}</div>

{{-- {!! dd($application_list) !!} --}}
{{-- {!! dd($application_list->currentPage()) !!} --}}
{{-- {!! dd($application_list->perPage()) !!} --}}