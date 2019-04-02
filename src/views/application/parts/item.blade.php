<tr data-id="{{ $item->id }}">
	<td><input type="checkbox" name="checked" value="{{ $item->id }}"></td>
	<td>
		<a href="javascript:void(0)" class="featured-img-change media-open">
			<img src="{!! asset('application-files/'.$item['image']) !!}" class="thumbnail img-xs ">
			<i class="fa fa-camera"></i>
			<input name="thumbnail" type="hidden" value="">
		</a>

		{{ $item->name }}  {{ $item->surname }}</td>
	<td>{{ $item->email }}</td>
	<td>{{ $item->mobile }}</td>
	<td>{{ $item->course }}</td>
	<td>{{ $item->supplements }}</td>
	<td>{{ $item->suggestion }}</td>
	<td>
		@if($item->materials)
		@php
			$materials = json_decode($item->materials);
		@endphp 
		<ul>
			@foreach($materials as $material)
				<li>
					<a class="materials" href="{{ url('application-files/'.$material) }}" download>
					{{ substr($material, strrpos($material, '/') + 1) }}
					</a>
				</li>
			@endforeach
		</ul>
		@endif

	</td>
	<!-- <td>
			{!! $item->content !!}
	</td> -->
	<!-- <td class="text_capitalize">{{ $item->status }}</td> -->
	<!-- <td>{{ date('m/d/Y', strtotime($item->created_at)) }}</td> -->
	<!-- <td>{{ date('m/d/Y g:i A', strtotime($item->updated_at)) }}</td> -->

	<td class="action">
		<a href="{{ route('application-destroy', $item->id ) }}" title="Delete" class="btn btn-xs btn-danger confirm-del"><i class="fa fa-trash"></i></a>
	</td>
</tr>