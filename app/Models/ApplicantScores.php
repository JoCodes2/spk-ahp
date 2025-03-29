<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantScores extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'applicant_scores';
    protected $fillable = ['id', 'applicant_id', 'criteria_value_id', 'score', 'created_at', 'updated_at'];
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
    public function criteriaValue()
    {
        return $this->belongsTo(CriteriaValues::class);
    }
}
