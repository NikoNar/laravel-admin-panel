<?php

namespace Codeman\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
    	'lang', 
        'parent_lang_id',
        'title',
        'position',
        'thumbnail',
        'gallery',
        'order', 
        'slug'          
    ];

    public function categories()
    {
        return $this->morphToMany('Codeman\Admin\Models\Category', 'categorisable');
    }
}
