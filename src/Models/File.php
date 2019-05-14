<?php

namespace Codeman\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'lang',
        'parent_lang_id',
        'title',
        'file',
        'year',
        'type',
        'order',
        'slug'
    ];

    public function categories()
    {
        return $this->morphToMany('Codeman\Admin\Models\Category', 'categorisable');
    }
}
