<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  protected $table = 'log';

  protected $guarded = [];

  public $timestamps = false;

  protected $dates = [
    'datetime',
  ];
}
