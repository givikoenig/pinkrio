@if($portfolios)
<div id="content-page" class="content group">
	<div class="hentry group">
		<h2>Portfolios</h2>
		<div class="short-table white">
			<table style="width: 100%" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th class="align-left">ID</th>
						<th>Header</th>
						<th>Text</th>
						<th>Image</th>
						<th>Category</th>
						<th>Alias</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>

					@foreach($portfolios as $portfolio)
					<tr>
						<td class="align-left">{{$portfolio->id}}</td>
						<td class="align-left">{!! Html::link(route('admin.portfolios.edit',['portfolios'=>$portfolio->alias]),$portfolio->title) !!}</td>
						<td class="align-left">{{str_limit($portfolio->text,200)}}</td>
						<td>
							@if(isset($portfolio->img->mini))
							<a href="{{ route('admin.portfolios.edit',['portfolios'=>$portfolio->alias]) }}"> {!! Html::image(asset(config('app.theme')).'/images/projects/'.$portfolio->img->mini) !!} </a>
							@endif
						</td>
						<td>{{ $portfolio->filter->title }}</td>
						<td>{{ $portfolio->alias }}</td>
						<td>
							{!! Form::open(['url' => route('admin.portfolios.destroy',['portfolios'=>$portfolio->alias]),'class'=>'form-horizontal','method'=>'POST']) !!}
							{{ method_field('DELETE') }}
							{!! Form::button('Delete', ['class' => 'btn btn-french-5','type'=>'submit']) !!}
							{!! Form::close() !!}
						</td>
					</tr>	
					@endforeach	

				</tbody>
			</table>
		</div>

		{!! Html::link(route('admin.portfolios.create'),'Add portfolio',['class' => 'btn btn-the-salmon-dance-3']) !!}

		</div>
	<!-- START COMMENTS -->
	<div id="comments">
	</div>
	<!-- END COMMENTS -->
</div>
@endif