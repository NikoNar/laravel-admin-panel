<?php

namespace Codeman\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = [
    	'name',
        'code',
        'flag'
    ];

    public function pages()
    {
        return $this->hasMany('Codeman\Admin\Models\Page');
    }
}
