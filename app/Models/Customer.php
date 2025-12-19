<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = ["user_id", "tanggal_registrasi", "status_customer", "cabang_pengajuan", "tipe_customer", "nama_customer", "telepon", "alamat_email", "no_ktp", "alamat_outlet", "no_fax", "nama_pic", "jabatan", "alasan_perubahan", "izin_operasional", "masa_berlaku_izin_operasional", "sipa", "masa_berlaku_sipa", "cdob", "masa_berlaku_cdob", "no_npwp_outlet", "nama_npwp", "alamat_npwp", "id_sales", "gl_akun_piutang", "sumber_dana", "ttd_apj", "nama_terang", "dokumen_pendukung"];
    protected $appends = ['btn_multilink', 'btn_delete', 'btn_edit', 'btn_show'];


    public function getBtnMultilinkAttribute()
    {
        $arrLink = [
            ['label' => 'Cetak PDF', 'url' => url('cetak-pengajuan-data') . "?customer_id=" . $this->id, 'icon' => 'ti ti-file'],
        ];
        
        // Hanya tambahkan link dokumen jika ada file
        if (!empty($this->dokumen_pendukung)) {
            $arrLink[] = ['label' => 'Lihat Dokumen', 'url' => url('dokumen') . "/" . $this->dokumen_pendukung, 'icon' => 'ti ti-clipboard'];
        }
        
        $arrLink[] = ['label' => 'Form Transfer', 'url' => url('form-transfer') . "?customer_id=" . $this->id, 'icon' => 'ti ti-link'];
        
        $html = "<button type='button' data-links='" . json_encode($arrLink) . "' onclick='setMM(this)' title='Navigation' class='btn btn-outline-warning btn-sm radius-6' style='margin:1px;' data-bs-toggle='modal' data-bs-target='#modalMultiLink'>
                    <i class='ti ti-list'></i>
                </button>";

        return $html;
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
