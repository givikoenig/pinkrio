<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
	protected $fillable = ['title','text', 'customer', 'alias', 'text', 'img', 'filter_alias','keywords','meta_desc', 'filter_id','user_id'];
    //
    // public function filter() {
    // 	return $this->belongsTo('Corp\Filter','filter_alias','alias');
    // }
    
	public function user() {
    	return $this->belongsTo('Corp\User');
    }

    public function filter() {
    	return $this->belongsTo('Corp\Filter');
    }
}
