<tr data-id="{{ $item->id }}">
	<td><input type="checkbox" name="checked" value="{{ $item->id }}"></td>
	<td>
{{--		<a href="javascript:void(0)" class="featured-img-change media-open">--}}
{{--			<img src="{!! $item->thumbnail !!}" class="thumbnail img-xs ">--}}
{{--			<i class="fa fa-camera"></i>--}}
{{--			<input name="thumbnail" type="hidden" value="">--}}
{{--		</a>--}}
		{{ $item->title }}</td>
	<td>
		{{ $item->year }}
	</td>
	<td>{{ $item->file }}</td>
	<td>{{ date('m/d/Y', strtotime($item->created_at)) }}</td>
	<td>{{ date('m/d/Y g:i A', strtotime($item->updated_at)) }}</td>

	<td class="action">
		<a href="{{ route('file-edit', $item->id ) }}" title="Edit" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
		<a href="{{ route('file-translate', $item->id ) }}" title="Translate To Armenian" class="btn btn-xs btn-primary"><i class="fa fa-language"></i></a>
		<a href="{{ route('file-destroy', $item->id ) }}" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
	</td>
</tr>