<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'criteria';
    protected $fillable = ['id', 'code', 'name', 'created_at', 'updated_at'];
}
