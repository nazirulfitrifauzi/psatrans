<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    protected $table = 'company';

    protected $guarded = [];

    public $timestamps = false;
}
