@if($categories)
<div id="content-page" class="content group">
	<div class="hentry group">
		<h2>Article Categories</h2>
		<div class="short-table white">
			<table style="width: 100%" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Alias</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($categories as $category)

					<tr>
						<td class="align-left">{{ $category->parent_id > 0 ? '&nbsp;&nbsp;&nbsp;-- ' : '' }}  {!! Html::link(route('admin.categories.edit',['categories'=>$category->alias]),$category->title) !!}</td>
						<td>{{ $category->alias }}</td>
						<td>
							{!! Form::open(['url' => route('admin.categories.destroy',['categories'=>$category->alias]),'class'=>'form-horizontal','method'=>'POST']) !!}
							{{ method_field('DELETE') }}
							{!! Form::button('Delete', ['class' => 'btn btn-french-5','type'=>'submit']) !!}
							{!! Form::close() !!}
						</td>
					</tr>

					@endforeach
				</tbody>
			</table>
		</div>
		{!! Html::link(route('admin.categories.create'),'Add Article Category',['class' => 'btn btn-the-salmon-dance-3']) !!}

	</div>
</div>
@else
<div><h3>No Categories here</h3></div>

@endif