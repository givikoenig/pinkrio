<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Corp\Http\Requests;

use Corp\Http\Requests\CategoryRequest;
use Corp\Http\Controllers\Controller;
use Corp\Repositories\CategoriesRepository;

use Corp\Category;
use Corp\Article;
use Gate;


class CategoriesController extends AdminController
{
    public function __construct(CategoriesRepository $cat_rep) {

        parent::__construct();

        if (Gate::denies('VIEW_ADMIN_CATEGORIES')) {
            abort(403);
        }
        $this->cat_rep = $cat_rep;

        $this->template = config('app.theme').'.admin.categories';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->title = 'Article Categories Manager';

        $categories = $this->getCategories();

        $this->content = view(config('app.theme').'.admin.categories_content')->with('categories',$categories)->render();

        return $this->renderOutput();
    }

    public function getCategories () {

        return $this->cat_rep->get();
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

        $this->title = "Add New Article Category";

        $categories = Category::select(['title','alias','parent_id','id'])->get();

        

        $this->content = view(config('app.theme').'.admin.categories_create_content')->with('categories',$categories)->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        
        //
        $result = $this->cat_rep->addCategory($request);
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
    public function edit(Category $category)
    {

        if (Gate::denies('edit', new Category)) {
            abort(403);
        }

        $this->title = 'Editing Category - '.$category->title;

        $this->content = view(config('app.theme').'.admin.categories_create_content')->with('category',$category)->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // categories - Category
        $result = $this->cat_rep->updateCategory($request, $category);

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
    public function destroy(Category $category)
    {
        //
        $result = $this->cat_rep->deleteCategory($category);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }
}
