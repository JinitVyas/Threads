<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vote extends Model
{
    protected $table = "vote";
    protected $primaryKey = "vid";
    public $timestamps = false;
    use HasFactory;
}
