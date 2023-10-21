<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class connect extends Model
{
    protected $table = "connect";
    protected $primaryKey = "conn_id";
    public $timestamps = false;
    use HasFactory;
}
