<div id="content-page" class="content group">
	<div class="hentry group">

		{!! Form::open(['url' => (isset($portfolio->id)) ? route('admin.portfolios.update',['portfolios'=>$portfolio->alias]) : route('admin.portfolios.store'),'class'=>'contact-form','method'=>'POST','enctype'=>'multipart/form-data']) !!}

		<ul>
			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Title:</span>
					<br />
					<span class="sublabel">Portfolio headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('title',isset($portfolio->title) ? $portfolio->title  : old('title'), ['placeholder'=>'Place portfolio title here']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">keywords:</span>
					<br />
					<span class="sublabel">Portfolio headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('keywords', isset($portfolio->keywords) ? $portfolio->keywords  : old('keywords'), ['placeholder'=>'CEO keywords']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Meta-description:</span>
					<br />
					<span class="sublabel">Portfolio headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('meta_desc', isset($portfolio->meta_desc) ? $portfolio->meta_desc  : old('meta_desc'), ['placeholder'=>'CEO description']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Alias:</span>
					<br />
					<span class="sublabel">Portfolio alias</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('alias', isset($portfolio->alias) ? $portfolio->alias  : old('alias'), ['placeholder'=>'Place portfolio alias here']) !!}
				</div>
			</li>

			

			<li class="textarea-field">
				<label for="message-contact-us">
					<span class="label">Content:</span>
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span>
					{!! Form::textarea('text', isset($portfolio->text) ? $portfolio->text  : old('text'), ['id'=>'editor2','class' => 'form-control','placeholder'=>'Full text here']) !!}
				</div>
				<div class="msg-error"></div>
			</li>

			@if(isset($portfolio->img->path))
			<li class="textarea-field">
				
				<label>
					<span class="label">Portfolio Image:</span>
				</label>
				
				{{ Html::image(asset(config('app.theme')).'/images/projects/'.$portfolio->img->path,'',['style'=>'width:400px']) }}
				{!! Form::hidden('old_image',$portfolio->img->path) !!}

			</li>
			@endif


			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Image:</span>
					<br />
					<span class="sublabel">Portfolio Image</span><br />
				</label>
				<div class="input-prepend">
					{!! Form::file('image', ['class' => 'filestyle','data-buttonText'=>'Pick Image','data-buttonName'=>"btn-primary",'data-placeholder'=>"No File"]) !!}
				</div>

			</li>


			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Filter:</span>
					<br />
					<span class="sublabel">Portfolio Filter</span><br />
				</label>

				<div class="input-prepend">
					{{  Form::select('filter_id', $filters,isset($portfolio->filter_id) ? $portfolio->filter_id  : '') }}
					{{--!! Form::select('filter_alias', $portfolios) !!--}}

				</div>

			</li>	 

			@if(isset($portfolio->id))
			<input type="hidden" name="_method" value="PUT">		

			@endif

			<li class="submit-button"> 
				{!! Form::button('Сохранить', ['class' => 'btn btn-the-salmon-dance-3','type'=>'submit']) !!}			
			</li>

		</ul>





		{!! Form::close() !!}

		<script>
			CKEDITOR.replace( 'editor2' );
		</script>
	</div>
</div>