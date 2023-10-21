<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thread extends Model
{
    protected $table = "thread";
    protected $primaryKey = "tid";
    public $timestamps = false;
    use HasFactory;
}
