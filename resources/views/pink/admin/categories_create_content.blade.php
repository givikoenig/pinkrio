<div id="content-page" class="content group">
				            <div class="hentry group">

{!! Form::open(['url' => (isset($category->alias)) ? route('admin.categories.update',['categories'=>$category->alias]) : route('admin.categories.store'),'class'=>'contact-form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
    
	<ul>

		<!-- <ul> -->
		
			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Title:</span>
					<br />
					<span class="sublabel">Item Title</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
				{!! Form::text('title',isset($category->title) ? $category->title  : old('title'), ['placeholder'=>'Put Category Name here']) !!}
				 </div>
			 </li>
			

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Alias:</span>
					<br />
					<span class="sublabel">Article Category alias</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('alias', isset($category->alias) ? $category->alias  : old('alias'), ['placeholder'=>'Place category alias here']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">keywords:</span>
					<br />
					<span class="sublabel">Category headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('keywords', isset($category->keywords) ? $category->keywords  : old('keywords'), ['placeholder'=>'CEO keywords']) !!}
				</div>
			</li>

			<li class="text-field">
				<label for="name-contact-us">
					<span class="label">Meta-description:</span>
					<br />
					<span class="sublabel">Category headers</span><br />
				</label>
				<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
					{!! Form::text('meta_desc', isset($category->meta_desc) ? $category->meta_desc  : old('meta_desc'), ['placeholder'=>'CEO description']) !!}
				</div>
			</li>

		<!-- </ul>	 -->

		@if(isset($category->id))
			<input type="hidden" name="_method" value="PUT">		

			@endif
			
			{{ csrf_field() }}

			<li class="submit-button"> 
				{!! Form::button('Сохранить', ['class' => 'btn btn-the-salmon-dance-3','type'=>'submit']) !!}			
			</li>

	</ul>

{!! Form::close() !!}

