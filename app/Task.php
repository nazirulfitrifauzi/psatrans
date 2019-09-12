<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $table = 'task_list';

  protected $guarded = [];

  public $timestamps = false;

  protected $dates = [
    'deadline',
  ];
}
