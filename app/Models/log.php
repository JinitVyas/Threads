<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    protected $table = "log";
    protected $primaryKey = "lid";
    public $timestamps = false;
    use HasFactory;
}
