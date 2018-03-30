<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Http\Requests;
use Corp\Repositories\MenusRepository;

use Menu;
use DB;

class SiteController extends Controller
{
    //
    protected $p_rep;   //portfolio_repos - логика для хранения портфолио
    protected $s_rep;   //slider_repos - логика по работе со слайдером
    protected $a_rep;   //articles_repos - логика по работе со статьями
    protected $m_rep;   //menus_repos - логика по работе с пунктами меню

    protected $keywords;
    protected $meta_desc;
    protected $title;

    protected $template;  //имя шаблона для отображения инф. на конкретной странице
    protected $vars = array();  		//массив передаваемых в шаблон переменных

    protected $contentRightBar = FALSE;
    protected $contentLeftBar = FALSE;
    protected $bar = 'no';		// св-во, показывающее, что есть какой-то сайдбар

    

    public function __construct(MenusRepository $m_rep) {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput() {
        
        
        $menu = $this->getMenu();
        
        $navigation = view(config('app.theme').'.navigation')->with('menu',$menu)->render();
        $this->vars = array_add($this->vars,'navigation',$navigation);

        if ($this->contentRightBar) {
            $rightBar = view(config('app.theme').'.rightBar')->with('content_rightBar',$this->contentRightBar)->render();
            $this->vars = array_add($this->vars,'rightBar',$rightBar);
        }

        if ($this->contentLeftBar) {
            $leftBar = view(config('app.theme').'.leftBar')->with('content_leftBar',$this->contentLeftBar)->render();
            $this->vars = array_add($this->vars,'leftBar',$leftBar);
        }

        $this->vars = array_add($this->vars,'bar',$this->bar);

        $footer = view(config('app.theme').'.footer')->render();
        $this->vars = array_add($this->vars,'footer', $footer);

        $this->vars = array_add($this->vars,'keywords', $this->keywords);
        $this->vars = array_add($this->vars,'meta_desc', $this->meta_desc);
        $this->vars = array_add($this->vars,'title', $this->title);

        return view($this->template)->with($this->vars);
    }
    
    protected function getMenu() {
        
        // $menu = $this->m_rep->get();

        $menu = DB::table('menus')->orderBy('parent')->get();
        
        // dd($menu);
        
        $mBuilder = Menu::make('MyNav', function($m) use ($menu) {
            
            foreach($menu as $item) {

                if($item->parent == 0) {
                    $m->add($item->title,$item->path)->id($item->id);
                }
                else {
                    if($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title,$item->path)->id($item->id);
                    }
                }
            }
            
        });
        
        // dd($mBuilder);
        
        return $mBuilder;

    }   


}
