<?php

namespace Corp\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use DB;
use Menu;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e) {
       
       if($this->isHttpException($e)) {
            $statusCode = $e->getStatusCode();
            
            switch($statusCode) {
                case '404' :
                $menu = $this->getMenu();
               
                $navigation = view(config('app.theme').'.navigation')->with('menu',$menu)->render();

                \Log::alert('Page not found - '. $request->url());
                
                return response()->view(config('app.theme').'.404',['bar' => 'no','title' =>'Page not found','navigation'=>$navigation]);
            }
       } 
       
       return parent::render($request, $e);

    } 

    protected function getMenu() {
        
        $menu = DB::table('menus')->orderBy('parent')->get();
        
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
        
        return $mBuilder;

    } 
}
