<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultAHP extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'ahp_result';
    protected $fillable = ['id', 'applicant_id', 'final_score', 'rank', 'created_at', 'updated_at'];
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
