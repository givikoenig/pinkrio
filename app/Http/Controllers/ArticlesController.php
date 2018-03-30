<?php
namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Http\Requests;

use Corp\Repositories\PortfoliosRepository;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\CommentsRepository;

use Corp\Category;
use Corp\Comment;
use Corp\Portfolio;
use Corp\Article;
// use DB;

class ArticlesController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep,CommentsRepository $c_rep) {
        
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));
        
        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;
        
        $this->bar = 'right';

        $this->template = config('app.theme').'.articles';
        
    }

    public function index($cat_alias = FALSE)
    {
        if($this->title || $this->keywords || $this->meta_desc) {
        (!$cat_alias)  ? $this->title = 'Blog' : $this->title  = $this->getCategoryMeta($cat_alias)->title;
        (!$cat_alias)  ? $this->keywords = 'SomeKeyword' : $this->keywords  = $this->getCategoryMeta($cat_alias)->keywords;
        (!$cat_alias)  ? $this->meta_desc = 'SomeDescription' : $this->meta_desc  = $this->getCategoryMeta($cat_alias)->meta_desc;
        }

        $articles = $this->getArticles($cat_alias);

        $content = view(config('app.theme').'.articles_content')->with('articles',$articles)->render();
        $this->vars = array_add($this->vars,'content',$content);
        $comments = $this->getComments(config('settings.recent_comments'));

        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));

        $this->contentRightBar = view(config('app.theme').'.articlesBar')->with(['comments' => $comments,'portfolios' => $portfolios]);

        return $this->renderOutput();
    }

    public function getCategoryMeta($cat_alias) {

        $cat_meta = Category::select('title','keywords','meta_desc')->where('alias',$cat_alias)->first();
        
        return $cat_meta;   

    }
    
    public function getComments($take) {

    	// $comments = $this->c_rep->get(['text','name','email','site','article_id','user_id'],$take);
        $comments = Comment::select('text','name','email','site','article_id','user_id')->orderBy('created_at','desc')->take($take)->get();
    	
    	if ($comments) {
    		 $comments->load('article','user');
    	}
       
		return $comments;
	}
	
	public function show($alias = FALSE) {
		
		$article = $this->a_rep->one($alias,['comments' => TRUE]);

		if($article) {
			if($article->img) {
             $article->img = json_decode($article->img);
            } else {
                $article->img = "";
            }
		}

        if(isset($article->id)) {
        $this->title = $article->title;
        $this->keywords = $article->keywords;
        $this->meta_desc = $article->meta_desc;
        }

		$content = view(config('app.theme').'.article_content')->with('article',$article)->render();
		$this->vars = array_add($this->vars,'content',$content);
		
		$comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));

        $this->contentRightBar = view(config('app.theme').'.articlesBar')->with(['comments' => $comments,'portfolios' => $portfolios]);
		
		return $this->renderOutput();
	}
	
	public function getPortfolios($take) {

		// $portfolios = $this->p_rep->get(['title','text','alias','customer','img','filter_alias'],$take);
        $portfolios = Portfolio::select('title','text','alias','customer', 'img','filter_alias')->orderBy('created_at','desc')->take($take)->get();
        $portfolios = $this->p_rep->check($portfolios);
		
        return $portfolios;
	}

    public function getArticles($alias = FALSE) {
    	
    	$where = FALSE;
    	
    	if($alias) {
			if(!empty(Category::select('id')->where('alias',$alias)->first()->id)) {
                // WHERE `alias` = $alias
                $id = Category::select('id')->where('alias',$alias)->first()->id;
                // WHERE `category_id` = $id
                $where = ['category_id',$id];
            } else {
                $id = 1; //Category::select('id')->where('alias', 'computers')->first()->id;
                $where = ['category_id',1];
            }
        }    
			
    	// $articles = $this->a_rep->get(['id','title','alias','created_at','img','desc','user_id','category_id','keywords','meta_desc'],FALSE,TRUE,$where);

        if($alias) {
            $articles = Article::select('id','title','alias','created_at','img','desc','user_id','category_id','keywords','meta_desc')->where('category_id',$id)->orderBy('created_at','desc')->paginate(config('settings.paginate'));
        } else {
            $articles = Article::select('id','title','alias','created_at','img','desc','user_id','category_id','keywords','meta_desc')->orderBy('created_at','desc')->paginate(config('settings.paginate'));
        }

        $articles = $this->a_rep->check($articles);

    	if ($articles) {

    		 $articles->load('user','category','comments');
             
    	}

    	return $articles;

    }

}

?>