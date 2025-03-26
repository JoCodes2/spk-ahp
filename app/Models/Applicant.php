<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicant extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'applicants';
    protected $fillable = ['id', 'position_id', 'name', 'code', 'created_at', 'updated_at'];
    public function criteria()
    {
        return $this->belongsTo(Position::class);
    }
}
