<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Corp\Http\Requests;
use Corp\Http\Controllers\Controller;

use Auth;
use Menu;
use Gate;

class AdminController extends \Corp\Http\Controllers\Controller
{
    //

    protected $p_rep;
    
    protected $a_rep;
    
    // protected $p_rep;
    
    protected $user;
    
    protected $template;

    protected $content = FALSE;

    protected $title;

    protected $vars;

    public function __construct() {

    	$this->user = Auth::user();

    	if (!$this->user) {
    		abort(403);
    	}

    }

    public function renderOutput() {

    	$this->vars = array_add($this->vars, 'title', $this->title);
    	// собственно пункты меню
    	$menu = $this->getMenu();
        // dd($menu);
    	// код html главного меню админки
    	$navigation = view(config('app.theme').'.admin.navigation')->with('menu',$menu)->render();
    	$this->vars = array_add($this->vars, 'navigation',$navigation);

    	if ($this->content) {
    		$this->vars = array_add($this->vars, 'content', $this->content);
    	}

    	$footer = view(config('app.theme').'.admin.footer');
    	$this->vars = array_add($this->vars, 'footer', $footer);

    	return view($this->template)->with($this->vars);

    }

    public function getMenu() {

    	return Menu::make('adminMenu', function($menu) {

            if (Gate::allows('VIEW_ADMIN_ARTICLES')) {
                $menu->add('Articles', array('route' => 'admin.articles.index')); 
            }

            if (Gate::allows('VIEW_ADMIN_CATEGORIES')) {
                $menu->add('Article Categories', array('route' => 'admin.categories.index')); 
            }

    		if (Gate::allows('VIEW_ADMIN_PORTFOLIOS')) {
    		    $menu->add('Portfolio', array('route' => 'admin.portfolios.index'));
            }

            if (Gate::allows('VIEW_ADMIN_FILTERS')) {
                $menu->add('Portfolio Filters', array('route' => 'admin.filters.index'));
            }
            
            if (Gate::allows('VIEW_ADMIN_MENU')) {
    		  $menu->add('Menu', array('route' => 'admin.menus.index'));
            }
            if (Gate::allows('EDIT_USERS')) {
    		  $menu->add('Users', array('route' => 'admin.users.index'));
            }  
            
            if($this->user->roles->all()[0]['name'] == 'Admin') {
    		  $menu->add('Permissions', array('route' => 'admin.permissions.index'));
            }

            // dd($this->user->roles->all()[0]['name']);

    		return $menu;
    	});

    }


}
