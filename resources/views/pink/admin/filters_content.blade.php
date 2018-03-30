@if($filters)
<div id="content-page" class="content group">
	<div class="hentry group">
		<h2>Portfolio Filters</h2>
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
					@foreach($filters as $filter)

					<tr>
						<td class="align-left">{{ $filter->parent_id > 0 ? '&nbsp;&nbsp;&nbsp;-- ' : '' }}  {!! Html::link(route('admin.filters.edit',['filters'=>$filter->alias]),$filter->title) !!}</td>
						<td>{{ $filter->alias }}</td>
						<td>
							{!! Form::open(['url' => route('admin.filters.destroy',['filters'=>$filter->alias]),'class'=>'form-horizontal','method'=>'POST']) !!}
							{{ method_field('DELETE') }}
							{!! Form::button('Delete', ['class' => 'btn btn-french-5','type'=>'submit']) !!}
							{!! Form::close() !!}
						</td>
					</tr>

					@endforeach
				</tbody>
			</table>
		</div>
		{!! Html::link(route('admin.filters.create'),'Add Portfolio Filter',['class' => 'btn btn-the-salmon-dance-3']) !!}

	</div>
</div>
@else
<div><h3>No Filters here</h3></div>

@endif