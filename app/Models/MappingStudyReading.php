<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingStudyReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'mapping_study_point_id',
        'value',
        'recorded_at',
        'user_id',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'value' => 'float',
    ];

    public function mappingStudyPoint()
    {
        return $this->belongsTo(MappingStudyPoint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
