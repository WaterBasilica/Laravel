<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
  use SoftDeletes;
  protected $date = ['deleted_at'];
  // protected $fillable = ['title', 'body'];

  // public function comments() {
  //   return $this->hasMany('App\Comment');
  // }
}
