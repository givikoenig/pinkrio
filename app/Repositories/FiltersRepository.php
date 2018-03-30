<?php
namespace Corp\Repositories;

use Corp\Filter;
use Gate;

class FiltersRepository extends Repository {

	public function  __construct(Filter $filter) {
		$this->model = $filter;
	}

	public function one($alias,$attr = array())  {
		$filter = parent::one($alias,$attr);

		
    	return $filter;

	}

	public function addFilter($request) {

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
			$data['parent_id'] =  Filter::select('id')->where('parent_id', 0)->first()->id;
		}

		if ($this->one($data['alias'], FALSE)) {
			$request->merge(array('alias' => $data['alias']));
			$request->flash();

			return ['error' => 'Alias used already'];
		}
			
		if($this->model->fill($data)->save()) {
			return ['status' => 'Done with new filter!'];
		}


	}

	public function updateFilter($request, $filter) {

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


		if (isset($result->id) && $result->id != $filter->id) {
			$request->merge(array('alias' => $data['alias']));
			$request->flash();

			return ['error' => 'Alias used already'];
		}

		$filter->fill($data);

		// dd($filter);

		if($filter->update()) {
			return ['status' => 'Done with editing filter!'];
		}


	}

	public function deleteFilter($filter) {


		if (Gate::denies('destroy',$filter)) {
			abort(403);
		}

		$filter->portfolios()->delete();

		if ($filter->delete()) {
			return ['status' => 'Filter deleted'];
		}

	}

}

?>