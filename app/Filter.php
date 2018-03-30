<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
	protected $fillable = ['title','parent_id','alias','keywords','meta_desc'];
    //
    public function portfolios() {
    	return $this->hasMany('Corp\Portfolio');
    }
}
