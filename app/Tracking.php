<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
  protected $table = 'tracking';

  protected $guarded = [];

  public $timestamps = false;

  protected $dates = [
    'datetime',
  ];
}
