<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Chandel extends Model
{
    protected $table    = 'channel';
    protected $primaryKey = 'c_id';
    public $timestamps = false;
    //protected $fillable = ['name'];//允许被批量赋值
    protected $guarded = [];//不允许被批量赋值
}
