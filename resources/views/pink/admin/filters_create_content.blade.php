<div id="content-page" class="content group">
				            <div class="hentry group">

{!! Form::open(['url' => (isset($filter->alias)) ? route('admin.filters.update',['filters'=>$filter->alias]) : route('admin.filters.store'),'class'=>'contact-form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
    
	<ul>

		<!-- <ul> -->
		
			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Title:</span>
					<br />
					<span class="sublabel">Item Title</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
				{!! Form::text('title',isset($filter->title) ? $filter->title  : old('title'), ['placeholder'=>'Put Filter Name here']) !!}
				 </div>
			 </li>
			

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Alias:</span>
					<br />
					<span class="sublabel">Portfolio Filter alias</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('alias', isset($filter->alias) ? $filter->alias  : old('alias'), ['placeholder'=>'Place filter alias here']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">keywords:</span>
					<br />
					<span class="sublabel">Filter headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('keywords', isset($filter->keywords) ? $filter->keywords  : old('keywords'), ['placeholder'=>'CEO keywords']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Meta-description:</span>
					<br />
					<span class="sublabel">Filter headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('meta_desc', isset($filter->meta_desc) ? $filter->meta_desc  : old('meta_desc'), ['placeholder'=>'CEO description']) !!}
				</div>
			</li>

		<!-- </ul>	 -->

		@if(isset($filter->id))
			<input type="hidden" name="_method" value="PUT">		

			@endif
			
			{{ csrf_field() }}

			<li class="submit-button"> 
				{!! Form::button('Сохранить', ['class' => 'btn btn-the-salmon-dance-3','type'=>'submit']) !!}			
			</li>

	</ul>

{!! Form::close() !!}

