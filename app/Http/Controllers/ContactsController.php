<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Http\Requests;

use Mail;

class ContactsController extends SiteController
{
    //
    public function __construct() {
        
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));
        
        $this->bar = 'left';

        $this->template = config('app.theme').'.contacts';
        
    }

    public function index(Request $request) {

    	if ($request->isMethod('post')) {
		    
			$messages = [
			    'required' => 'Поле :attribute Обязательно к заполнению',
			    'email'    => 'Поле :attribute должно содержать правильный email адрес',
			];
			
			 $this->validate($request, [
		        'name' => 'required|max:255',
		        'email' => 'required|email',
				'text' => 'required'
		    ]/*,$messages*/);
			
			$data = $request->all();
			
			$result = Mail::send(config('app.theme').'.email', ['data' => $data], function ($m) use ($data) {
				$mail_admin = config('app.mail_admin');
				
	            $m->from($data['email'], $data['name']);

	            $m->to($mail_admin, 'Mr. Admin')->subject('Question');
	        });

			
			if($result) {
				return redirect()->route('contacts')->with('status', 'Email is sent');
			}
			
		}
    	
    	$this->title = 'Contacts';

    	$content = view(config('app.theme').'.contact_content')->render();
    	$this->vars = array_add($this->vars,'content',$content);

    	$this->contentLeftBar = view(config('app.theme').'.contact_bar')->render();
    	return $this->renderOutput();
    }
}
