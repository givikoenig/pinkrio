<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Http\Requests;
use Corp\Repositories\PortfoliosRepository;

use Corp\Portfolio;
use Corp\Filter;

class PortfolioController extends SiteController
{
    //
    public function __construct(PortfoliosRepository $p_rep) {
        
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));
        
        $this->p_rep = $p_rep;
        
        $this->template = config('app.theme').'.portfolios';
        
    }

    public function index($filter_alias = FALSE)
    {
        if($this->title || $this->keywords || $this->meta_desc) {
        $this->title = 'Portfolio';
        $this->keywords = 'PortfolioKeyword';
        $this->meta_desc = 'PortfolioDescription';
    }

        $portfolios = $this->getPortfolios($filter_alias);

        $content = view(config('app.theme').'.portfolios_content')->with('portfolios',$portfolios)->render();
        $this->vars = array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    // public function getPortfolios($take = FALSE,$paginate = TRUE) {
    public function getPortfolios($alias = FALSE) {
//===
        $where = FALSE;
        
        if($alias) {
            if(!empty(Filter::select('id')->where('alias',$alias)->first()->id)) {
                // WHERE `alias` = $alias
                $id = Filter::select('id')->where('alias',$alias)->first()->id;
                // WHERE `filter_id` = $id
                $where = ['filter_id',$id];
            } else {
                $id = 1; //Filter::select('id')->where('alias', 'computers')->first()->id;
                $where = ['filter_id',1];
            }
        } 

        if($alias) {
            $portfolios = Portfolio::select('*')->where('filter_id',$id)->orderBy('created_at','desc')->paginate(config('settings.paginate'));
        } else {
            $portfolios = Portfolio::select('*')->orderBy('created_at','desc')->paginate(config('settings.paginate'));
        }

        $portfolios = $this->p_rep->check($portfolios);
    	// $portfolios = $this->p_rep->get('*',$take,$paginate);
    	if ($portfolios) {
    		$portfolios->load('filter');
    	}
    	return $portfolios;
    }

    public function show($alias) {
		

    	 if(!empty($this->p_rep->one($alias))) {
            $portfolio = $this->p_rep->one($alias);
         } else {
            $alias = Portfolio::select('alias')->first()->alias;
            $portfolio = $this->p_rep->one($alias);
         }
    	// $portfolios = $this->getPortfolios(config('settings.other_portfolios'), FALSE);
        $portfolios = Portfolio::select('*')->orderBy('created_at','desc')->take(config('settings.other_portfolios'))->get();
        $portfolios = $this->p_rep->check($portfolios);
        $portfolios = $portfolios->except($portfolio->id);

        if($this->title) $this->title = $portfolio->title;
        if($this->keywords) $this->keywords = $portfolio->keywords;
        if($this->meta_desc) $this->meta_desc = $portfolio->meta_desc;

		$content = view(config('app.theme').'.portfolio_content')->with(['portfolio' => $portfolio,'portfolios' => $portfolios])->render();
		$this->vars = array_add($this->vars,'content',$content);
		
        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), FALSE);


		return $this->renderOutput();
	}
	
}
