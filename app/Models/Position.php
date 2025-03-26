<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'positions';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
}
