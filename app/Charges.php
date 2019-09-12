<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
  protected $table = 'charges';

  protected $guarded = [];

  public $timestamps = false;
}
