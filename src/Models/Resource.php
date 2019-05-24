<?php

namespace Codeman\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    //

    public function language()
    {
        return $this->belongsTo('Codeman\Admin\Models\Language');
    }
}
