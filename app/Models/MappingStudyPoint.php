<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingStudyPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'mapping_study_id',
        'location_id',
    ];

    public function mappingStudy()
    {
        return $this->belongsTo(Mapping::class, 'mapping_study_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function readings()
    {
        return $this->hasMany(MappingStudyReading::class);
    }
}
