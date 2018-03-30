<?php
namespace Corp\Repositories;

use Corp\Category;
use Gate;
use Image;
use Config;

class CategoriesRepository extends Repository {

	public function  __construct(Category $category) {
		$this->model = $category;
	}

	public function one($alias,$attr = array())  {
		$category = parent::one($alias,$attr);

		
    	return $category;

	}
	
	public function addCategory($request) {

		if (Gate::denies('save', $this->model)) {
			abort(403);
		}
		
		$data = $request->except('_token');
		
		if (empty($data)) {
			return array('error' => 'No Data');
		}

		if (empty($data['alias'])) {
			$data['alias'] = $this->transliterate($data['title']);
		} else {
			$data['alias'] = $this->transliterate($data['alias']);
		}

		if (empty($data['parent_id'])) {
			$data['parent_id'] = Category::select('id')->where('parent_id', 0)->first()->id;
		}

		if ($this->one($data['alias'], FALSE)) {
			$request->merge(array('alias' => $data['alias']));
			$request->flash();

			return ['error' => 'Alias used already'];
		}
			
		if($this->model->fill($data)->save()) {
			return ['status' => 'Done with new category!'];
		}
		
	}

	public function updateCategory($request, $category) {

		if (Gate::denies('edit', $this->model)) {
			abort(403);
		}

		$data = $request->except('_token','_method');
		

		if (empty($data)) {
			return array('error' => 'No Data');
		}

		if (empty($data['alias'])) {
			$data['alias'] = $this->transliterate($data['title']);
		} else {
			$data['alias'] = $this->transliterate($data['alias']);
		}

		$result = $this->one($data['alias'], FALSE);

		if (isset($result->id) && $result->id != $category->id) {
			$request->merge(array('alias' => $data['alias']));
			$request->flash();

			return ['error' => 'Alias used already'];
		}

		$category->fill($data);

		if($category->update()) {
			return ['status' => 'Done with editing category!'];
		}
				

	}

	public function deleteCategory($category) {

		if (Gate::denies('destroy',$category)) {
			abort(403);
		}

		// $category->articles()->comments()->delete();
		$category->articles()->delete();

		if ($category->delete()) {
			return ['status' => 'Category deleted'];
		}

	}


}

?>