<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Customer</title>
    <!-- Memuat Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Memuat Tabler Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 1rem;
        }
        .required-label::after {
            content: '*';
            color: #dc3545;
            margin-left: 0.25rem;
        }
        /* Auto uppercase untuk input text dan textarea */
        .text-uppercase-input {
            text-transform: uppercase;
        }
        canvas {
            border: 1px solid #ccc;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <div class="card p-4 p-md-5 form-card mx-auto" style="max-width: 900px;">

            <h1 class="text-center mb-4 text-primary fw-bold">Form Pengajuan Customer</h1>

            <!-- Menambahkan 'needs-validation' untuk Bootstrap Validation -->
            <form id="customerForm" class="needs-validation" onsubmit="handleSubmit(event)" novalidate>
                
                <!-- Bagian 1: Data Registrasi & Status -->
                <h5 class="mb-3 text-secondary border-bottom pb-2">Data Registrasi & Identitas</h5>
                <div class="row g-3 mb-4">

                    <!-- Tanggal Registrasi -->
                    <div class="col-md-6">
                        <label for="tanggal_registrasi" class="form-label required-label">Tanggal Registrasi</label>
                        <input type="date" class="form-control" id="tanggal_registrasi" name="tanggal_registrasi" required>
                        <div class="invalid-feedback">
                            Tanggal registrasi wajib diisi.
                        </div>
                    </div>

                    <!-- Status Customer -->
                    <div class="col-md-6">
                        <label class="form-label required-label">Status Customer</label>
                        <div class="d-flex mt-2">
                            <div class="form-check me-4">
                                <input class="form-check-input" type="radio" name="status_customer" id="status_baru" value="baru" checked required>
                                <label class="form-check-label" for="status_baru">
                                    Baru
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_customer" id="status_perubahan" value="perubahan" required>
                                <label class="form-check-label" for="status_perubahan">
                                    Perubahan
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Cabang Pengajuan -->
                    <div class="col-md-6">
                        <label for="cabang_pengajuan" class="form-label required-label">Cabang Pengajuan</label>
                        <select class="form-select" id="cabang_pengajuan" name="cabang_pengajuan" required>
                            <option value="" disabled>Pilih Cabang...</option>
                            <option value="Pusat" selected>Pusat</option>
                            <option value="Cabang Semarang">Cabang Semarang</option>
                            <option value="Cabang Makassar">Cabang Makassar</option>
                            <option value="Cabang Manado">Cabang Manado</option>
                            <option value="MBI">MBI</option>
                        </select>
                        <div class="invalid-feedback">
                            Cabang pengajuan wajib dipilih.
                        </div>
                    </div>

                    <!-- Tipe Customer -->
                    <div class="col-md-6">
                        <label for="tipe_customer" class="form-label required-label">Tipe Customer</label>
                        <select class="form-select" id="tipe_customer" name="tipe_customer" required>
                            <option value="" disabled selected>Pilih Tipe...</option>
                            <option value="H1">H1</option>
                            <option value="H2">H2</option>
                            <option value="H3">H3</option>
                            <option value="H4">H4</option>
                            <option value="H5">H5</option>
                            <option value="H6">H6</option>
                            <option value="H7">H7</option>
                            <option value="H8">H8</option>
                            <option value="H9">H9</option>
                        </select>
                        <div class="invalid-feedback">
                            Tipe customer wajib dipilih.
                        </div>
                    </div>

                    <!-- Nama Customer -->
                    <div class="col-12">
                        <label for="nama_customer" class="form-label required-label">Nama Customer</label>
                        <input type="text" class="form-control text-uppercase-input" id="nama_customer" name="nama_customer" placeholder="Masukkan nama customer" required>
                        <div class="invalid-feedback">
                            Nama customer wajib diisi.
                        </div>
                    </div>

                    <!-- Telepon & Email -->
                    <div class="col-md-6">
                        <label for="telepon" class="form-label required-label">Telepon</label>
                        <input type="tel" class="form-control" id="telepon" name="telepon" placeholder="Contoh: 081234567890" required>
                        <div class="invalid-feedback">
                            Nomor telepon wajib diisi.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: nama@domain.com">
                    </div>
                    
                    <!-- No. KTP -->
                    <div class="col-md-6">
                        <label for="no_ktp" class="form-label">No. KTP</label>
                        <input type="text" class="form-control text-uppercase-input" id="no_ktp" name="no_ktp" placeholder="Masukkan Nomor KTP">
                    </div>

                    <!-- No. Fax -->
                    <div class="col-md-6">
                        <label for="no_fax" class="form-label">No. Fax</label>
                        <input type="text" class="form-control text-uppercase-input" id="no_fax" name="no_fax" placeholder="Masukkan nomor fax">
                    </div>

                    <!-- Alamat Outlet -->
                    <div class="col-12">
                        <label for="alamat_outlet" class="form-label">Alamat Outlet</label>
                        <textarea class="form-control text-uppercase-input" id="alamat_outlet" name="alamat_outlet" rows="3" placeholder="Masukkan alamat lengkap outlet"></textarea>
                    </div>
                </div>

                <!-- Bagian 2: Data PIC & Perubahan -->
                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Data Penanggung Jawab (PIC)</h5>
                <div class="row g-3 mb-4">
                    
                    <div class="col-md-6">
                        <label for="nama_pic" class="form-label">Nama PIC</label>
                        <input type="text" class="form-control text-uppercase-input" id="nama_pic" name="nama_pic" placeholder="Nama Penanggung Jawab">
                    </div>
                    <div class="col-md-6">
                        <label for="jabatan_pic" class="form-label">Jabatan</label>
                        <input type="text" class="form-control text-uppercase-input" id="jabatan_pic" name="jabatan_pic" placeholder="Jabatan PIC">
                    </div>

                    <!-- Alasan Perubahan -->
                    <div class="col-12">
                        <label for="alasan_perubahan" class="form-label">Alasan Perubahan (jika Status Customer: Perubahan)</label>
                        <textarea class="form-control text-uppercase-input" id="alasan_perubahan" name="alasan_perubahan" rows="3" placeholder="Jelaskan alasan pengajuan perubahan"></textarea>
                    </div>
                </div>

                <!-- Bagian 3: Izin & Legalitas -->
                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Izin & Legalitas</h5>
                <div class="row g-3 mb-4">

                    <!-- Izin Operasional -->
                    <div class="col-md-6">
                        <label for="izin_operasional" class="form-label required-label">Izin Operasional</label>
                        <input type="text" class="form-control text-uppercase-input" id="izin_operasional" name="izin_operasional" placeholder="Nomor Izin Operasional" required>
                        <div class="invalid-feedback">
                            Izin operasional wajib diisi.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="masa_berlaku_izin" class="form-label required-label">Masa Berlaku Izin Operasional</label>
                        <input type="date" class="form-control" id="masa_berlaku_izin" name="masa_berlaku_izin" required>
                        <div class="invalid-feedback">
                            Masa berlaku izin operasional wajib diisi.
                        </div>
                    </div>

                    <!-- SIPA -->
                    <div class="col-md-6">
                        <label for="sipa" class="form-label required-label">SIPA</label>
                        <input type="text" class="form-control text-uppercase-input" id="sipa" name="sipa" placeholder="Nomor SIPA" required>
                        <div class="invalid-feedback">
                            SIPA wajib diisi.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="masa_berlaku_sipa" class="form-label required-label">Masa Berlaku SIPA</label>
                        <input type="date" class="form-control" id="masa_berlaku_sipa" name="masa_berlaku_sipa" required>
                        <div class="invalid-feedback">
                            Masa berlaku SIPA wajib diisi.
                        </div>
                    </div>

                    <!-- CDOB -->
                    <div class="col-md-6">
                        <label for="cdob" class="form-label">CDOB</label>
                        <input type="text" class="form-control text-uppercase-input" id="cdob" name="cdob" placeholder="Nomor CDOB">
                    </div>
                    <div class="col-md-6">
                        <label for="masa_berlaku_cdob" class="form-label">Masa Berlaku CDOB</label>
                        <input type="date" class="form-control" id="masa_berlaku_cdob" name="masa_berlaku_cdob">
                    </div>

                </div>

                <!-- Bagian 4: Data NPWP -->
                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Data NPWP</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="no_npwp_outlet" class="form-label required-label">No NPWP Outlet</label>
                        <input type="text" class="form-control text-uppercase-input" id="no_npwp_outlet" name="no_npwp_outlet" placeholder="Nomor NPWP Outlet" required>
                        <div class="invalid-feedback">
                            No NPWP Outlet wajib diisi.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="nama_npwp" class="form-label required-label">Nama NPWP</label>
                        <input type="text" class="form-control text-uppercase-input" id="nama_npwp" name="nama_npwp" placeholder="Nama sesuai NPWP" required>
                        <div class="invalid-feedback">
                            Nama NPWP wajib diisi.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="alamat_npwp" class="form-label required-label">Alamat NPWP</label>
                        <textarea class="form-control text-uppercase-input" id="alamat_npwp" name="alamat_npwp" rows="3" placeholder="Alamat sesuai NPWP" required></textarea>
                        <div class="invalid-feedback">
                            Alamat NPWP wajib diisi.
                        </div>
                    </div>
                </div>

                <!-- Bagian 5: Data Sales & Keuangan -->
                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Data Sales & Keuangan</h5>
                <div class="row g-3 mb-4">

                    <!-- ID Sales -->
                    <div class="col-md-6">
                        <label for="id_sales" class="form-label required-label">ID Sales</label>
                        <select class="form-select" id="id_sales" name="id_sales" required>
                            <option value="" selected>Pilih ID Sales...</option>
                        </select>
                        <div class="invalid-feedback">
                            ID Sales wajib dipilih.
                        </div>
                    </div>

                    <!-- GL Akun Piutang -->
                    <div class="col-md-6">
                        <label for="gl_akun_piutang" class="form-label">GL Akun Piutang</label>
                        <select class="form-select" id="gl_akun_piutang" name="gl_akun_piutang">
                            <option value="" selected>Pilih Akun Piutang...</option>
                            <option value="1130001 PIUTANG REGULER">1130001 PIUTANG REGULER</option>
                            <option value="1130002 PIUTANG CABANG SEMARANG">1130002 PIUTANG CABANG SEMARANG</option>
                            <option value="1130003 PIUTANG CABANG MAKASSAR">1130003 PIUTANG CABANG MAKASSAR</option>
                            <option value="1130004 PIUTANG CABANG MANADO">1130004 PIUTANG CABANG MANADO</option>
                        </select>
                    </div>

                    <!-- Grup / Sumber Dana -->
                    {{-- <div class="col-md-6">
                        <label for="grup" class="form-label">Grup / Sumber Dana</label>
                        <select class="form-select" id="grup" name="grup">
                            <option value="" selected>Pilih Grup...</option>
                            <option value="Dana Sendiri">Dana Sendiri</option>
                            <option value="Dana Pinjaman">Dana Pinjaman</option>
                        </select>
                    </div> --}}
                </div>

                <!-- Bagian 6: Tanda Tangan & Upload -->
                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Konfirmasi & Dokumen</h5>
                <div class="row g-3 mb-4">
                    
                    <!-- Nama Terang -->
                    <div class="col-md-12">
                        <label for="nama_terang" class="form-label required-label">Nama Terang</label>
                        <input type="text" class="form-control text-uppercase-input" id="nama_terang" name="nama_terang" placeholder="Nama lengkap penanggung jawab" required>
                        <div class="invalid-feedback">
                            Nama terang wajib diisi.
                        </div>
                    </div>

                    <!-- TTD APJ (Simulasi Tanda Tangan) -->
                    <div class="col-md-12">
                        <label for="ttd_apj" class="form-label required-label">TTD APJ (Simulasi Tanda Tangan)</label><br>
                        <canvas id="signature-pad" width="400" height="150"></canvas><br>
                        <button class="btn btn-danger" type="button" onclick="clearPad()">Bersihkan</button>
                        <input type="hidden" name="ttd_apj" id="ttd_apj">
                        <div id="signature-error" class="text-danger mt-2" style="display: none;">
                            Tanda tangan wajib diisi.
                        </div>
                    </div>
                    
                    <!-- Upload Dokumen -->
                    <div class="col-12">
                        <label for="dokumen_pendukung" class="form-label required-label">Upload Dokumen Pendukung</label>
                        <input class="form-control" type="file" id="dokumen_pendukung" name="dokumen_pendukung" accept=".pdf" required>
                        <div class="form-text">Hanya file PDF dengan ukuran maksimum 3MB.</div>
                        <div id="file-error" class="text-danger mt-2" style="display: none;">
                            Ukuran file maksimum adalah 3MB.
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="col-12 pt-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="ti ti-upload me-2"></i> Simpan Pengajuan
                        </button>
                    </div>

                    <div class="col-12 pt-">
                        <a href="/" class="btn btn-secondary btn-lg w-100">
                            <i class="ti ti-home me-2"></i> Back to Home
                        </a>
                    </div>

                    <!-- Pesan Konfirmasi (Akan diisi oleh JS) -->
                    <div id="confirmation-message" class="col-12 mt-4 alert d-none" role="alert">
                        <!-- Pesan akan muncul di sini -->
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Memuat Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.6/dist/signature_pad.umd.min.js"></script>
    <script>
        const salesOptions = {
            'Pusat': [
                "PST REGULER",
                "PST-02 INSTITUSI"
            ],
            'Cabang Semarang': [
                "SMG-01 ANDY PRASETYO",
                "SMG-02 ANWAR JOKO",
                "SMG-03 ASHAR BAKHTIAR",
                "SMG-04 HERI SOEDJIJANTO",
                "SMG-05 KRISNA WAHYU",
                "SMG-06 M. SLAMET RAHARJO",
                "SMG-07 MEGA FERDYANTO",
                "SMG-08 MOHAMMAD AFIF",
                "SMG-09 MUHTAR MARDLATILLAH",
                "SMG-10 NUR MUHAMMAD",
                "SMG-11 SUYUDI",
                "SMG-12 YANUARIS DWI P",
                "SMG-13 YUDI SANTOSO",
                "SMG-14 MARISA PRAMUDIAN",
                "SMG-15 M. YANOOR IQBAL",
                "SMG-16 OFFICE SEMARANG",
                "SMG-17 WACHYU",
                "SMG-18 M. NAUFAL BADRI",
                "SMG-19 YOEDI HADI TRIANTO",
                "SMG-20 SAHID WIDODO",
                "SMG-21 AAN ARIF"
            ],
            'Cabang Makassar': [
                "MKS-01 FEBBY",
                "MKS-02 RAHMAT",
                "MKS-03 SUPRIADI",
                "MKS-04 OFFICE MAKASSAR",
                "MKS-05 WARDIMAN",
                "MKS-06 HERIANTO",
                "MKS-07 KAHARUDDIN",
                "MKS-08 ARSANDI",
                "MKS-09 IVAN"
            ],
            'Cabang Manado': [
                "MDO-01 CLAUDIO STEFANUS",
                "MDO-02 IMANUEL PEFRIANDY",
                "MDO-03 JODY CHRISTIAN",
                "MDO-04 NELVI WAHYUNINGSIH",
                "MDO-05 JIMMY YUSTINUS TANTANG",
                "MDO-06 HENDRY ROYKE SENGKEY",
                "MDO-07 FEBRIANTO PS",
                "MDO-08 BRIAN GOLAH PATRIKS LONGKUTOY",
                "MDO-09 OFFICE MANADO"
            ],
            'MBI': [
                "MDO-01 CLAUDIO STEFANUS",
                "MDO-02 IMANUEL PEFRIANDY",
                "MDO-03 JODY CHRISTIAN",
                "MDO-04 NELVI WAHYUNINGSIH",
                "MDO-05 JIMMY YUSTINUS TANTANG",
                "MDO-06 HENDRY ROYKE SENGKEY",
                "MDO-07 FEBRIANTO PS",
                "MDO-08 BRIAN GOLAH PATRIKS LONGKUTOY",
                "MDO-09 OFFICE MANADO",
                "MKS-01 FEBBY",
                "MKS-02 RAHMAT",
                "MKS-03 SUPRIADI",
                "MKS-04 OFFICE MAKASSAR",
                "MKS-05 WARDIMAN",
                "MKS-06 HERIANTO",
                "MKS-07 KAHARUDDIN",
                "MKS-08 ARSANDI",
                "MKS-09 IVAN",
                "PST REGULER",
                "PST-02 INSTITUSI",
                "SMG-01 ANDY PRASETYO",
                "SMG-02 ANWAR JOKO",
                "SMG-03 ASHAR BAKHTIAR",
                "SMG-04 HERI SOEDJIJANTO",
                "SMG-05 KRISNA WAHYU",
                "SMG-06 M. SLAMET RAHARJO",
                "SMG-07 MEGA FERDYANTO",
                "SMG-08 MOHAMMAD AFIF",
                "SMG-09 MUHTAR MARDLATILLAH",
                "SMG-10 NUR MUHAMMAD",
                "SMG-11 SUYUDI",
                "SMG-12 YANUARIS DWI P",
                "SMG-13 YUDI SANTOSO",
                "SMG-14 MARISA PRAMUDIAN",
                "SMG-15 M. YANOOR IQBAL",
                "SMG-16 OFFICE SEMARANG",
                "SMG-17 WACHYU",
                "SMG-18 M. NAUFAL BADRI",
                "SMG-19 YOEDI HADI TRIANTO",
                "SMG-20 SAHID WIDODO",
                "SMG-21 AAN ARIF"
            ]
        };

        // Fungsi untuk update ID Sales berdasarkan Cabang
        function updateSalesOptions() {
            const cabang = document.getElementById('cabang_pengajuan').value;
            const salesSelect = document.getElementById('id_sales');
            
            // Kosongkan option yang ada
            salesSelect.innerHTML = '<option value="" selected>Pilih ID Sales...</option>';
            
            // Tambahkan option baru sesuai cabang
            if (salesOptions[cabang]) {
                salesOptions[cabang].forEach(function(sales) {
                    const option = document.createElement('option');
                    option.value = sales;
                    option.textContent = sales;
                    salesSelect.appendChild(option);
                });
            }
        }

        // Auto uppercase untuk semua input text dan textarea dengan class text-uppercase-input
        document.addEventListener('DOMContentLoaded', function() {
            // Set tanggal hari ini
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const todayString = `${year}-${month}-${day}`;
            
            document.getElementById('tanggal_registrasi').value = todayString;

            // Initialize ID Sales untuk cabang default (Pusat)
            updateSalesOptions();
            
            // Event listener untuk perubahan cabang
            document.getElementById('cabang_pengajuan').addEventListener('change', updateSalesOptions);
            
            const uppercaseInputs = document.querySelectorAll('.text-uppercase-input');
            
            uppercaseInputs.forEach(function(input) {
                input.addEventListener('input', function(e) {
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    this.value = this.value.toUpperCase();
                    this.setSelectionRange(start, end);
                });
            });
        });

        document.getElementById('dokumen_pendukung').addEventListener('change', function(e) {
            const fileError = document.getElementById('file-error');
            const file = e.target.files[0];
            
            if (file) {
                const maxSize = 3 * 1024 * 1024; // 3MB dalam bytes
                
                if (file.size > maxSize) {
                    fileError.style.display = 'block';
                    this.value = ''; // Reset input file
                } else {
                    fileError.style.display = 'none';
                }
            }
        });

        window.handleSubmit = function(event) {
            const form = document.getElementById('customerForm');
            const messageDiv = document.getElementById('confirmation-message');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            event.preventDefault();
            event.stopPropagation();

            messageDiv.classList.add('d-none');
            messageDiv.classList.remove('alert-success', 'alert-danger');

            // Validasi tanda tangan
            const signatureError = document.getElementById('signature-error');
            if (signaturePad.isEmpty()) {
                signatureError.style.display = 'block';
                messageDiv.textContent = 'Mohon lengkapi semua bidang wajib yang ditandai dengan bintang (*), termasuk tanda tangan.';
                messageDiv.classList.add('alert-danger');
                messageDiv.classList.remove('d-none');
                return;
            } else {
                signatureError.style.display = 'none';
                document.getElementById('ttd_apj').value = signaturePad.toDataURL();
            }

            // 1. Validasi Formulir
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                messageDiv.textContent = 'Mohon lengkapi semua bidang wajib yang ditandai dengan bintang (*).';
                messageDiv.classList.add('alert-danger');
                messageDiv.classList.remove('d-none');
                return;
            }

            // 2. Jika valid, kirim data via AJAX
            form.classList.remove('was-validated');
            const formData = new FormData(form);

            // Disable button dan tampilkan loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';

            // Kirim data ke server
            fetch('{{ route("form-pengajuan-submit") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan pesan sukses
                    messageDiv.textContent = data.message || 'Pengajuan Anda telah berhasil disimpan!';
                    messageDiv.classList.add('alert-success');
                    messageDiv.classList.remove('d-none');

                    // Reset form setelah 3 detik
                    setTimeout(() => {
                        form.reset();
                        messageDiv.classList.add('d-none');
                    }, 3000);
                } else {
                    // Tampilkan pesan error
                    let errorMsg = data.message || 'Terjadi kesalahan saat menyimpan data.';
                    
                    // Tampilkan error validasi jika ada
                    if (data.errors) {
                        errorMsg += '\n\nDetail Error:\n';
                        Object.keys(data.errors).forEach(key => {
                            errorMsg += '- ' + data.errors[key].join(', ') + '\n';
                        });
                    }
                    
                    messageDiv.textContent = errorMsg;
                    messageDiv.classList.add('alert-danger');
                    messageDiv.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                messageDiv.classList.add('alert-danger');
                messageDiv.classList.remove('d-none');
            })
            .finally(() => {
                // Enable button kembali
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ti ti-upload me-2"></i> Simpan Pengajuan';
            });
        };


        function saveSignature() {
            const canvas = document.getElementById("signature-pad");
            const ttdInput = document.getElementById("ttd_apj");

            if (canvas && ttdInput) {
                const dataURL = canvas.toDataURL("image/png"); // Hasil base64
                ttdInput.value = dataURL;
            }

            return true; // Penting agar form tetap dikirim setelah fungsi dijalankan
        }

        function clearPad() {
            const canvas = document.getElementById("signature-pad");
            const ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas);

        function saveSignature() {
            if (!signaturePad.isEmpty()) {
                document.getElementById('ttd_apj').value = signaturePad.toDataURL();
            }
        }

        function clearPad() {
            signaturePad.clear();
        }
    </script>
</body>
</html>