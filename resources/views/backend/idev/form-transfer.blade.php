<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pengajuan Data Customer</title>
    
    <!-- Memuat Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        /* CSS Kustom untuk Notifikasi dan Font */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .fixed-top-right {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            max-width: 300px;
            z-index: 1050;
        }
        /* Menyesuaikan input field agar rounded di kedua sisi karena menggunakan input-group */
        .input-group .form-control {
            border-radius: 0.375rem !important; /* bs-rounded */
        }
        .input-group .btn {
            border-radius: 0.375rem !important; /* bs-rounded */
        }
        .form-group-title {
            color: #4338CA; /* indigo-700 */
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                <h1 class="card-title text-center mb-1 fw-bold form-group-title">Formulir Pengajuan Data Customer Baru</h1>
                <p class="text-muted text-center mb-4">Isi semua data yang diperlukan. Gunakan tombol 'Salin' di setiap bidang untuk memindahkan data ke sistem lain.</p>

                <!-- Notifikasi Salin/Error (Menggunakan struktur Alert Bootstrap) -->
                <div id="notification" class="alert alert-success fixed-top-right d-none opacity-0 shadow-lg" role="alert" style="transition: opacity 0.3s ease-in-out;">
                    Berhasil disalin!
                </div>

                <form id="customer-form" class="row g-4">

                    <!-- SECTION 1: INFORMASI CUSTOMER / OUTLET -->
                    <div class="col-12">
                        <div class="p-4 rounded-3 border bg-light shadow-sm">
                            <h2 class="fs-5 fw-bold form-group-title border-bottom pb-2 mb-4">1. Informasi Customer / Outlet</h2>
                            
                            <!-- Tanggal Registrasi -->
                            <div class="row mb-3 align-items-center">
                                <label for="tanggal_registrasi" class="col-md-4 col-form-label fw-semibold">Tgl. Registrasi</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="tanggal_registrasi" value="{{ $customer->tanggal_registrasi ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('tanggal_registrasi')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Customer -->
                            <div class="row mb-3 align-items-center">
                                <label for="status_customer" class="col-md-4 col-form-label fw-semibold">Status Customer</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="status_customer" value="{{ $customer->status_customer ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('status_customer')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Cabang Pengajuan -->
                            <div class="row mb-3 align-items-center">
                                <label for="cabang_pengajuan" class="col-md-4 col-form-label fw-semibold">Cabang Pengajuan</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="cabang_pengajuan" value="{{ $customer->cabang_pengajuan ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('cabang_pengajuan')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipe Customer -->
                            <div class="row mb-3 align-items-center">
                                <label for="tipe_customer" class="col-md-4 col-form-label fw-semibold">Tipe Customer</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="tipe_customer" value="{{ $customer->tipe_customer ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('tipe_customer')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Nama Customer -->
                            <div class="row mb-3 align-items-center">
                                <label for="nama_customer" class="col-md-4 col-form-label fw-semibold">Nama Customer</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="nama_customer" value="{{ $customer->nama_customer ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('nama_customer')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Telepon -->
                            <div class="row mb-3 align-items-center">
                                <label for="telepon" class="col-md-4 col-form-label fw-semibold">Telepon</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="telepon" value="{{ $customer->telepon ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('telepon')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="row mb-3 align-items-center">
                                <label for="alamat_email" class="col-md-4 col-form-label fw-semibold">Email</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="alamat_email" value="{{ $customer->alamat_email ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('alamat_email')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- No KTP -->
                            <div class="row mb-3 align-items-center">
                                <label for="no_ktp" class="col-md-4 col-form-label fw-semibold">No KTP</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="no_ktp" value="{{ $customer->no_ktp ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('no_ktp')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat Outlet -->
                            <div class="row mb-3">
                                <label for="alamat_outlet" class="col-md-4 col-form-label fw-semibold">Alamat Outlet</label>
                                <div class="col-md-8">
                                    <div class="input-group align-items-start">
                                        <textarea id="alamat_outlet" rows="2" class="form-control" readonly>{{ $customer->alamat_outlet ?? '' }}</textarea>
                                        <button type="button" onclick="copyField('alamat_outlet')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- No Fax -->
                            <div class="row mb-3 align-items-center">
                                <label for="no_fax" class="col-md-4 col-form-label fw-semibold">No Fax</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="no_fax" value="{{ $customer->no_fax ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('no_fax')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- ID Sales -->
                            <div class="row mb-3 align-items-center">
                                <label for="id_sales" class="col-md-4 col-form-label fw-semibold">ID Sales</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="id_sales" value="{{ $customer->id_sales ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('id_sales')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- GL Akun Piutang -->
                            <div class="row mb-0 align-items-center">
                                <label for="gl_akun_piutang" class="col-md-4 col-form-label fw-semibold">GL Akun Piutang</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="gl_akun_piutang" value="{{ $customer->gl_akun_piutang ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('gl_akun_piutang')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: INFORMASI PIC & IZIN -->
                    <div class="col-12">
                        <div class="p-4 rounded-3 border bg-light shadow-sm">
                            <h2 class="fs-5 fw-bold form-group-title border-bottom pb-2 mb-4">2. Informasi PIC & Izin</h2>

                            <!-- Nama PIC -->
                            <div class="row mb-3 align-items-center">
                                <label for="nama_pic" class="col-md-4 col-form-label fw-semibold">Nama PIC</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="nama_pic" value="{{ $customer->nama_pic ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('nama_pic')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Jabatan PIC -->
                            <div class="row mb-3 align-items-center">
                                <label for="jabatan" class="col-md-4 col-form-label fw-semibold">Jabatan PIC</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="jabatan" value="{{ $customer->jabatan ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('jabatan')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Alasan Perubahan -->
                            <div class="row mb-3">
                                <label for="alasan_perubahan" class="col-md-4 col-form-label fw-semibold">Alasan Perubahan</label>
                                <div class="col-md-8">
                                    <div class="input-group align-items-start">
                                        <textarea id="alasan_perubahan" rows="2" class="form-control" readonly>{{ $customer->alasan_perubahan ?? '' }}</textarea>
                                        <button type="button" onclick="copyField('alasan_perubahan')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Izin Operasional -->
                            <div class="row mb-3 align-items-center">
                                <label for="izin_operasional" class="col-md-4 col-form-label fw-semibold">Izin Operasional</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="izin_operasional" value="{{ $customer->izin_operasional ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('izin_operasional')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Masa Berlaku Izin Operasional -->
                            <div class="row mb-3 align-items-center">
                                <label for="masa_berlaku_izin_operasional" class="col-md-4 col-form-label fw-semibold">Masa Berlaku Izin</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="masa_berlaku_izin_operasional" value="{{ $customer->masa_berlaku_izin_operasional ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('masa_berlaku_izin_operasional')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- SIPA -->
                            <div class="row mb-3 align-items-center">
                                <label for="sipa" class="col-md-4 col-form-label fw-semibold">SIPA</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="sipa" value="{{ $customer->sipa ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('sipa')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Masa Berlaku SIPA -->
                            <div class="row mb-3 align-items-center">
                                <label for="masa_berlaku_sipa" class="col-md-4 col-form-label fw-semibold">Masa Berlaku SIPA</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="masa_berlaku_sipa" value="{{ $customer->masa_berlaku_sipa ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('masa_berlaku_sipa')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- CDOB -->
                            <div class="row mb-3 align-items-center">
                                <label for="cdob" class="col-md-4 col-form-label fw-semibold">CDOB</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="cdob" value="{{ $customer->cdob ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('cdob')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Masa Berlaku CDOB -->
                            <div class="row mb-3 align-items-center">
                                <label for="masa_berlaku_cdob" class="col-md-4 col-form-label fw-semibold">Masa Berlaku CDOB</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="masa_berlaku_cdob" value="{{ $customer->masa_berlaku_cdob ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('masa_berlaku_cdob')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Nama Terang -->
                            <div class="row mb-0 align-items-center">
                                <label for="nama_terang" class="col-md-4 col-form-label fw-semibold">Nama Terang</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="nama_terang" value="{{ $customer->nama_terang ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('nama_terang')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: INFORMASI NPWP -->
                    <div class="col-12">
                        <div class="p-4 rounded-3 border bg-light shadow-sm">
                            <h2 class="fs-5 fw-bold form-group-title border-bottom pb-2 mb-4">3. Informasi NPWP</h2>
                            
                            <!-- NPWP Outlet -->
                            <div class="row mb-3 align-items-center">
                                <label for="no_npwp_outlet" class="col-md-4 col-form-label fw-semibold">NPWP Outlet</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="no_npwp_outlet" value="{{ $customer->no_npwp_outlet ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('no_npwp_outlet')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Nama NPWP -->
                            <div class="row mb-3 align-items-center">
                                <label for="nama_npwp" class="col-md-4 col-form-label fw-semibold">Nama NPWP</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="nama_npwp" value="{{ $customer->nama_npwp ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('nama_npwp')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat NPWP -->
                            <div class="row mb-0">
                                <label for="alamat_npwp" class="col-md-4 col-form-label fw-semibold">Alamat NPWP</label>
                                <div class="col-md-8">
                                    <div class="input-group align-items-start">
                                        <textarea id="alamat_npwp" rows="2" class="form-control" readonly>{{ $customer->alamat_npwp ?? '' }}</textarea>
                                        <button type="button" onclick="copyField('alamat_npwp')" class="btn btn-primary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: DOKUMEN & INFO TAMBAHAN -->
                    <div class="col-12">
                        <div class="p-4 rounded-3 border bg-light-subtle shadow-sm">
                            <h2 class="fs-5 fw-bold text-secondary border-bottom pb-2 mb-4">4. Dokumen & Info Tambahan</h2>

                            <!-- Sumber Dana -->
                            <div class="row mb-3 align-items-center">
                                <label for="sumber_dana" class="col-md-4 col-form-label fw-semibold">Sumber Dana / Grup</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="sumber_dana" value="{{ $customer->sumber_dana ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('sumber_dana')" class="btn btn-secondary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>

                            <!-- TTD APJ -->
                            <div class="row mb-3 align-items-center">
                                <label for="ttd_apj" class="col-md-4 col-form-label fw-semibold">TTD APJ</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        @if($customer->ttd_apj)
                                            <input type="text" id="ttd_apj" value="{{ url('ttd/' . $customer->ttd_apj) }}" class="form-control" readonly>
                                            <a href="{{ url('ttd/' . $customer->ttd_apj) }}" target="_blank" class="btn btn-info copy-btn">Lihat</a>
                                        @else
                                            <input type="text" id="ttd_apj" value="Tidak ada file" class="form-control" readonly>
                                            <button type="button" class="btn btn-secondary copy-btn" disabled>N/A</button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Dokumen Pendukung -->
                            <div class="row mb-3 align-items-center">
                                <label for="dokumen_pendukung" class="col-md-4 col-form-label fw-semibold">Dokumen Pendukung</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        @if($customer->dokumen_pendukung)
                                            <input type="text" id="dokumen_pendukung" value="{{ url('dokumen/' . $customer->dokumen_pendukung) }}" class="form-control" readonly>
                                            <a href="{{ url('dokumen/' . $customer->dokumen_pendukung) }}" target="_blank" class="btn btn-info copy-btn">Lihat</a>
                                        @else
                                            <input type="text" id="dokumen_pendukung" value="Tidak ada file" class="form-control" readonly>
                                            <button type="button" class="btn btn-secondary copy-btn" disabled>N/A</button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Created At -->
                            <div class="row mb-0 align-items-center">
                                <label for="created_at" class="col-md-4 col-form-label fw-semibold">Tanggal Dibuat</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="created_at" value="{{ $customer->created_at ?? '' }}" class="form-control" readonly>
                                        <button type="button" onclick="copyField('created_at')" class="btn btn-secondary copy-btn">Salin</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Area Copy All (Hidden) -->
                    <textarea id="copyAllTextArea" style="position: absolute; left: -9999px;"></textarea>

                </form>

                <!-- Tombol Aksi -->
                <div class="mt-5 pt-4 border-top d-flex justify-content-between justify-content-md-end space-x-2">
                    
                    {{-- <!-- Tombol Reset -->
                    <button type="button" onclick="resetForm()" class="btn btn-outline-danger d-flex align-items-center me-3 rounded-3 shadow-sm">
                        <svg class="me-2" style="width: 1.25rem; height: 1.25rem;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Reset Formulir
                    </button>

                    <!-- Tombol Submit (Placeholder) -->
                    <button type="button" onclick="handleSubmit()" class="btn btn-success d-flex align-items-center rounded-3 shadow-lg">
                        <svg class="me-2" style="width: 1.25rem; height: 1.25rem;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Submit Data Pengajuan
                    </button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Memuat Bootstrap JS (Optional, but good practice) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
        // Fungsi untuk menampilkan notifikasi
        function showNotification(message, isSuccess = true) {
            const notification = document.getElementById('notification');
            
            notification.classList.remove('alert-success', 'alert-danger', 'd-none');
            notification.classList.add(isSuccess ? 'alert-success' : 'alert-danger');
            
            notification.textContent = message;
            notification.classList.remove('opacity-0');
            notification.classList.add('opacity-100');

            setTimeout(() => {
                notification.classList.remove('opacity-100');
                notification.classList.add('opacity-0');
                setTimeout(() => notification.classList.add('d-none'), 300);
            }, 3000);
        }

        // Fungsi untuk copy single field
        function copyField(fieldId) {
            const field = document.getElementById(fieldId);
            if (!field) return;

            const value = field.value.trim();
            
            if (!value) {
                showNotification('Field kosong, tidak ada yang disalin', false);
                return;
            }

            // Select dan copy
            field.select();
            field.setSelectionRange(0, 99999);

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    const label = field.previousElementSibling?.textContent || fieldId;
                    showNotification(`✓ ${label} berhasil disalin!`, true);
                } else {
                    // Fallback modern clipboard API
                    navigator.clipboard.writeText(value).then(() => {
                        showNotification(`✓ Data berhasil disalin!`, true);
                    }).catch(() => {
                        showNotification('Gagal menyalin data', false);
                    });
                }
            } catch (err) {
                console.error('Error:', err);
                showNotification('Gagal menyalin data', false);
            }
        }

        // Fungsi untuk copy all data dalam format yang mudah di-paste
        function copyAllData() {
            const fields = [
                { id: 'tanggal_registrasi', label: 'Tanggal Registrasi' },
                { id: 'status_customer', label: 'Status Customer' },
                { id: 'cabang_pengajuan', label: 'Cabang Pengajuan' },
                { id: 'tipe_customer', label: 'Tipe Customer' },
                { id: 'nama_customer', label: 'Nama Customer' },
                { id: 'telepon', label: 'Telepon' },
                { id: 'alamat_email', label: 'Email' },
                { id: 'no_ktp', label: 'No KTP' },
                { id: 'alamat_outlet', label: 'Alamat Outlet' },
                { id: 'no_fax', label: 'No Fax' },
                { id: 'id_sales', label: 'ID Sales' },
                { id: 'gl_akun_piutang', label: 'GL Akun Piutang' },
                { id: 'nama_pic', label: 'Nama PIC' },
                { id: 'jabatan', label: 'Jabatan' },
                { id: 'alasan_perubahan', label: 'Alasan Perubahan' },
                { id: 'izin_operasional', label: 'Izin Operasional' },
                { id: 'masa_berlaku_izin_operasional', label: 'Masa Berlaku Izin' },
                { id: 'sipa', label: 'SIPA' },
                { id: 'masa_berlaku_sipa', label: 'Masa Berlaku SIPA' },
                { id: 'cdob', label: 'CDOB' },
                { id: 'masa_berlaku_cdob', label: 'Masa Berlaku CDOB' },
                { id: 'nama_terang', label: 'Nama Terang' },
                { id: 'no_npwp_outlet', label: 'NPWP Outlet' },
                { id: 'nama_npwp', label: 'Nama NPWP' },
                { id: 'alamat_npwp', label: 'Alamat NPWP' },
                { id: 'sumber_dana', label: 'Sumber Dana' },
            ];

            let allData = '=== DATA CUSTOMER ===\n\n';
            
            fields.forEach(field => {
                const element = document.getElementById(field.id);
                if (element) {
                    const value = element.value.trim();
                    if (value) {
                        allData += `${field.label}: ${value}\n`;
                    }
                }
            });

            allData += '\n=== END DATA ===';

            // Copy menggunakan textarea hidden
            const textarea = document.getElementById('copyAllTextArea');
            textarea.value = allData;
            textarea.style.position = 'fixed';
            textarea.style.left = '0';
            textarea.style.top = '0';
            textarea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showNotification('✓ Semua data berhasil disalin! Paste di aplikasi tujuan.', true);
                } else {
                    navigator.clipboard.writeText(allData).then(() => {
                        showNotification('✓ Semua data berhasil disalin!', true);
                    }).catch(() => {
                        showNotification('Gagal menyalin semua data', false);
                    });
                }
            } catch (err) {
                console.error('Error:', err);
                showNotification('Gagal menyalin semua data', false);
            }

            textarea.style.position = 'absolute';
            textarea.style.left = '-9999px';
        }
    </script>
</body>
</html>