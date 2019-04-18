<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  protected $fillable = [
    'id', 'name', 'filter',
  ];
}
