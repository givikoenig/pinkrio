<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Corp\Http\Requests;
use Corp\Http\Requests\FilterRequest;
use Corp\Http\Controllers\Controller;
use Corp\Repositories\FiltersRepository;

use Corp\Filter;
use Corp\Portfolio;
use Gate;

class FiltersController extends AdminController
{
    public function __construct(FiltersRepository $f_rep) {

        parent::__construct();

        if (Gate::denies('VIEW_ADMIN_FILTERS')) {
            abort(403);
        }
        $this->f_rep = $f_rep;

        $this->template = config('app.theme').'.admin.filters';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->title = 'Portfolio Filters Manager';

        $filters = $this->getFilters();

        $this->content = view(config('app.theme').'.admin.filters_content')->with('filters',$filters)->render();

        return $this->renderOutput();

    }

    public function getFilters () {

        return $this->f_rep->get();
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Gate::denies('save', new \Corp\Category)) {
            abort(403);
        }

        $this->title = "Add New Portfolio Filter";

        $filters = Filter::select(['title','alias','parent_id','id'])->get();

        

        $this->content = view(config('app.theme').'.admin.filters_create_content')->with('filters',$filters)->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilterRequest $request)
    {
        // dd($request);
        $result = $this->f_rep->addFilter($request);
        if(is_array($result) && !empty($result['error'])) {
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
    public function edit(Filter $filter)
    {
        //
        if (Gate::denies('edit', new Filter)) {
            abort(403);
        }

        $this->title = 'Editing Filter - '.$filter->title;

        $this->content = view(config('app.theme').'.admin.filters_create_content')->with('filter',$filter)->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FilterRequest $request, Filter $filter)
    {
        //
        $result = $this->f_rep->updateFilter($request, $filter);

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
    public function destroy(Filter $filter)
    {
        //
        $result = $this->f_rep->deleteFilter($filter);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }
}
