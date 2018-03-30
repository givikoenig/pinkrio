<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['title','parent_id','alias','keywords','meta_desc'];
    //
    public function articles() {
    	return $this->hasMany('Corp\Article');
    }
}
