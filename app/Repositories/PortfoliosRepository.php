<?php
namespace Corp\Repositories;

use Corp\Portfolio;
use Gate;
use Image;
use Config;

class PortfoliosRepository extends Repository {

	public function __construct(Portfolio $portfolio) {
		$this->model = $portfolio;
	}

	public function one($alias,$attr = array())  {
		$portfolio = parent::one($alias,$attr);

		if ($portfolio && $portfolio->img) {
    		$portfolio->img = json_decode($portfolio->img);
    	}

    	return $portfolio;

	}

	public function addPortfolio($request) {

		if (Gate::denies('save', $this->model)) {
			abort(403);
		}

		$data = $request->except('_token','image');

		if (empty($data)) {
			return array('error' => 'No Data');
		}

		if (empty($data['alias'])) {
			// dd(preg_match('/[^\\p{Common}\\p{Latin}]/u', $data['title']));
			$data['alias'] = $this->transliterate($data['title']);
		} else {
			$data['alias'] = $this->transliterate($data['alias']);
		}

		if ($this->one($data['alias'], FALSE)) {
			$request->merge(array('alias' => $data['alias']));
			$request->flash();

			return ['error' => 'Alias used already'];
		}

		if (empty($data['filter_alias'])) {
			$data['filter_alias'] = \Corp\Filter::select(['alias'])->where('id',$data['filter_id'])->first()->alias;
			$request->merge(array('filter_alias' => $data['filter_alias']));
			$request->flash();
		}

		if ($request->hasFile('image')) {
			$image = $request->file('image');

			if ($image->isValid()) {
				
				$str = str_random(8);

				$obj = new \stdClass;

				$obj->mini = $str.'_mini.jpg';
				$obj->max = $str.'_max.jpg';
				$obj->path = $str.'.jpg';

				$img = Image::make($image);

				$img->fit(Config::get('settings.image')['width'],
						Config::get('settings.image')['height'])->save(public_path().'/'.config('app.theme').'/images/projects/'.$obj->path);
				$img->fit(Config::get('settings.portfolios_img')['max']['width'],
						Config::get('settings.portfolios_img')['max']['height'])->save(public_path().'/'.config('app.theme').'/images/projects/'.$obj->max);
				$img->fit(Config::get('settings.portfolios_img')['mini']['width'],
						Config::get('settings.portfolios_img')['mini']['height'])->save(public_path().'/'.config('app.theme').'/images/projects/'.$obj->mini);

				$data['img'] = json_encode($obj);
				// dd($data);

				if($this->model->fill($data)->save()) {
					return ['status' => 'Done with new portfolio!'];
				}
				
			}

		}

	}


	public function updatePortfolio($request, $portfolio) {

		if (Gate::denies('edit', $this->model)) {
			abort(403);
		}

		$data = $request->except('_token','image','_method');

		if (empty($data)) {
			return array('error' => 'No Data');
		}

		if (empty($data['alias'])) {
			// dd(preg_match('/[^\\p{Common}\\p{Latin}]/u', $data['title']));
			$data['alias'] = $this->transliterate($data['title']);
		} else {
			$data['alias'] = $this->transliterate($data['alias']);
		}

		$result = $this->one($data['alias'], FALSE);

		if (isset($result->id) && $result->id != $portfolio->id) {
			$request->merge(array('alias' => $data['alias']));
			$request->flash();

			return ['error' => 'Alias used already'];
		}

		if (empty($data['filter_alias'])) {
			$data['filter_alias'] = \Corp\Filter::select(['alias'])->where('id',$data['filter_id'])->first()->alias;
			$request->merge(array('filter_alias' => $data['filter_alias']));
			$request->flash();
		}

		if ($request->hasFile('image')) {
			$image = $request->file('image');

			if ($image->isValid()) {
				
				$str = str_random(8);

				$obj = new \stdClass;

				$obj->mini = $str.'_mini.jpg';
				$obj->max = $str.'_max.jpg';
				$obj->path = $str.'.jpg';

				$img = Image::make($image);

				$img->fit(Config::get('settings.image')['width'],
						Config::get('settings.image')['height'])->save(public_path().'/'.config('app.theme').'/images/projects/'.$obj->path);
				$img->fit(Config::get('settings.portfolios_img')['max']['width'],
						Config::get('settings.portfolios_img')['max']['height'])->save(public_path().'/'.config('app.theme').'/images/projects/'.$obj->max);
				$img->fit(Config::get('settings.portfolios_img')['mini']['width'],
						Config::get('settings.portfolios_img')['mini']['height'])->save(public_path().'/'.config('app.theme').'/images/projects/'.$obj->mini);

				$data['img'] = json_encode($obj);

			}

		}

		$portfolio->fill($data);

		if($portfolio->update()) {
			return ['status' => 'Done with editing portfolio!'];
		}
				

				// if ($request->user()->portfolios()->save($this->model)) {
				// 	return ['status' => 'Done with new portfolio!'];
				// }

	}

	public function deletePortfolio($portfolio) {

		if (Gate::denies('destroy',$portfolio)) {
			abort(403);
		}

		if ($portfolio->delete()) {
			return ['status' => 'Project deleted'];
		}

	}


}

?>