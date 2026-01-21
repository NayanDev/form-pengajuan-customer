<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitoring_point_id',
        'value',
        'recorded_at',
        'user_id',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'value' => 'float',
    ];

    public function monitoringPoint()
    {
        return $this->belongsTo(MonitoringPoint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
