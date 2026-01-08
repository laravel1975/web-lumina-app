<?php

// app/Models/Attribute.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'slug', 'unit'];
}
