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
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    public function scores()
    {
        return $this->hasMany(ApplicantScores::class, 'applicant_id');
    }
}
