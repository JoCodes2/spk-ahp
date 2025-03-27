<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaValues extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'criteria_values';
    protected $fillable = ['id', 'criteria_id', 'weight', 'created_at', 'updated_at'];
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
