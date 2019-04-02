<tr data-id="{{ $category->id }}" data-order="{!! $category->order !!}" data-position="{!! $key !!}">
	<td><input type="checkbox" name="checked" value="{{ $category->id }}"></td>
	<td> {{ $category->title_en }} </td>
	<td> {{ $category->title_arm }} </td>
	<td> {{ $category->slug }} </td>
	{{-- <td> {{ $category->type }} </td> --}}
	<td>{{ date('m/d/Y g:i A', strtotime($category->created_at)) }}</td>
	<td>{{ date('m/d/Y g:i A', strtotime($category->updated_at)) }}</td>
	<td class="action">
		<a href="#" title="Edit" data-id="{{ $category->id }}" data-type="{{ $type }}" class="btn btn-xs btn-warning edit-category"><i class="fa fa-edit"></i></a>
		<a href="{{ route('category-destroy', $category->id ) }}" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
	</td>
</tr>