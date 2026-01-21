<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $fillable = ["code","category","merk","model","serial_number","year_buy","is_status"];
    protected $appends = ['btn_detail', 'btn_delete', 'btn_edit', 'btn_show'];


    public function specs()
    {
        return $this->hasMany(Specification::class, 'asset_id', 'id');
    }

    public function getBtnDetailAttribute()
    {
        $html = "<a href='" . url('device-detail/' . $this->asset_id) . "' class='btn btn-outline-success btn-sm radius-6' style='margin:1px;' target='_blank'>
                <i class='ti ti-eye'></i>
                </a>";

        return $html;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'asset_id', 'id');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class, 'asset_id', 'id');
    }

    public function getBtnDeleteAttribute()
    {
        $html = "<button type='button' class='btn btn-outline-danger btn-sm radius-6' style='margin:1px;' data-bs-toggle='modal' data-bs-target='#modalDelete' onclick='setDelete(" . json_encode($this->id) . ")'>
                    <i class='ti ti-trash'></i>
                </button>";

        return $html;
    }
    

    public function getBtnEditAttribute()
    {
        $html = "<button type='button' class='btn btn-outline-secondary btn-sm radius-6' style='margin:1px;' data-bs-toggle='offcanvas'  data-bs-target='#drawerEdit' onclick='setEdit(" . json_encode($this->id) . ")'>
                    <i class='ti ti-pencil'></i>
                </button>";

        return $html;
    }


    public function getBtnShowAttribute()
    {
        $html = "<button type='button' class='btn btn-outline-secondary btn-sm radius-6' style='margin:1px;' onclick='setShowPreview(" . json_encode($this->id) . ")'>
                <i class='ti ti-eye'></i>
                </button>";
        return $html;
    }
    

    public function getUpdatedAtAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", strtotime($value)) : "-";
    }


    public function getCreatedAtAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", strtotime($value)) : "-";
    }
}
