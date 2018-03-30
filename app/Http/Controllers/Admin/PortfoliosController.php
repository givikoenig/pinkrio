<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Corp\Http\Requests;
use Corp\Http\Requests\PortfolioRequest;
use Corp\Http\Controllers\Controller;

use Corp\Repositories\PortfoliosRepository;

use Gate;
use Corp\Filter;
use Corp\Portfolio;

class PortfoliosController extends AdminController
{
    public function __construct(PortfoliosRepository $p_rep) {

        parent::__construct();

        if (Gate::denies('VIEW_ADMIN_PORTFOLIOS')) {
            abort(403);
        }
        $this->p_rep = $p_rep;

        $this->template = config('app.theme').'.admin.portfolios';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->title = 'Portfolios Manager';

        $portfolios = $this->getPortfolios();

        $this->content = view(config('app.theme').'.admin.portfolios_content')->with('portfolios', $portfolios)->render();

        return $this->renderOutput();
    }

    public function getPortfolios()
    {
        //
        return $this->p_rep->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Gate::denies('save', new \Corp\Portfolio)) {
            abort(403);
        }

        $this->title = "Add New Portfolio";

        $filters = Filter::select(['title','alias','parent_id','id'])->get();

        $flists = array();

        foreach ($filters as $filter) {
            if ($filter->parent_id == 0) {
                $flists[$filter->title] = array(); 
            } else {
                $flists[$filters->where('id',$filter->parent_id)->first()->title][$filter->id] = $filter->title;
            }
        }

        $this->content = view(config('app.theme').'.admin.portfolios_create_content')->with('filters',$flists)->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request)
    {
        //
        $result = $this->p_rep->addPortfolio($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        //
        if (Gate::denies('edit', new Portfolio)) {
            abort(403);
        }

        $portfolio->img = json_decode($portfolio->img);

        $filters = Filter::select(['title','alias','parent_id','id'])->get();

        $flists = array();

        foreach ($filters as $filter) {
            if ($filter->parent_id == 0) {
                $flists[$filter->title] = array(); 
            } else {
                $flists[$filters->where('id',$filter->parent_id)->first()->title][$filter->id] = $filter->title;
            }
        }

        $this->title = 'Editing project - '.$portfolio->title;

        $this->content = view(config('app.theme').'.admin.portfolios_create_content')->with(['filters'=>$flists, 'portfolio'=>$portfolio])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PortfolioRequest $request, Portfolio $portfolio)
    {
        //
        $result = $this->p_rep->updatePortfolio($request, $portfolio);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        //
        $result = $this->p_rep->deletePortfolio($portfolio);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
        
    }
}
