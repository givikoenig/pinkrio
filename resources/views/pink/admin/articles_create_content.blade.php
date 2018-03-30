<div id="content-page" class="content group">
	<div class="hentry group">

		{!! Form::open(['url' => (isset($article->id)) ? route('admin.articles.update',['articles'=>$article->alias]) : route('admin.articles.store'),'class'=>'contact-form','method'=>'POST','enctype'=>'multipart/form-data']) !!}

		<ul>
			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Title:</span>
					<br />
					<span class="sublabel">Article headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('title',isset($article->title) ? $article->title  : old('title'), ['placeholder'=>'Place article title here']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">keywords:</span>
					<br />
					<span class="sublabel">Article headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('keywords', isset($article->keywords) ? $article->keywords  : old('keywords'), ['placeholder'=>'SEO keywords']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Meta-description:</span>
					<br />
					<span class="sublabel">Article headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('meta_desc', isset($article->meta_desc) ? $article->meta_desc  : old('meta_desc'), ['placeholder'=>'SEO description']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Alias:</span>
					<br />
					<span class="sublabel">Article alias</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('alias', isset($article->alias) ? $article->alias  : old('alias'), ['placeholder'=>'Place article alias here']) !!}
				</div>
			</li>

			<li class="textarea-field">
				<label for="message-contact-us">
					<span class="label">Announcement:</span>
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span>
					{!! Form::textarea('desc', isset($article->desc) ? $article->desc  : old('desc'), ['id'=>'editor','class' => 'form-control','placeholder'=>'Brief text here']) !!}
				</div>
				<div class="msg-error"></div>
			</li>

			<li class="textarea-field">
				<label for="message-contact-us">
					<span class="label">Content:</span>
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span>
					{!! Form::textarea('text', isset($article->text) ? $article->text  : old('text'), ['id'=>'editor2','class' => 'form-control','placeholder'=>'Full text here']) !!}
				</div>
				<div class="msg-error"></div>
			</li>

			@if(isset($article->img->path))
			<li class="textarea-field">
				
				<label>
					<span class="label">Article Image:</span>
				</label>
				
				{{ Html::image(asset(config('app.theme')).'/images/articles/'.$article->img->path,'',['style'=>'width:400px']) }}
				{!! Form::hidden('old_image',$article->img->path) !!}

			</li>
			@endif


			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Image:</span>
					<br />
					<span class="sublabel">Article Image</span><br />
				</label>
				<div class="input-prepend">
					{!! Form::file('image', ['class' => 'filestyle','data-buttonText'=>'Pick Image','data-buttonName'=>"btn-primary",'data-placeholder'=>"No File"]) !!}
				</div>

			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Category:</span>
					<br />
					<span class="sublabel">Article Category</span><br />
				</label>
				<div class="input-prepend">
					{!! Form::select('category_id', $categories,isset($article->category_id) ? $article->category_id  : '') !!}
				</div>

			</li>	 

			@if(isset($article->id))
			<input type="hidden" name="_method" value="PUT">		

			@endif

			<li class="submit-button"> 
				{!! Form::button('Сохранить', ['class' => 'btn btn-the-salmon-dance-3','type'=>'submit']) !!}			
			</li>

		</ul>





		{!! Form::close() !!}

		<script>
			CKEDITOR.replace( 'editor' );
			CKEDITOR.replace( 'editor2' );
		</script>
	</div>
</div>