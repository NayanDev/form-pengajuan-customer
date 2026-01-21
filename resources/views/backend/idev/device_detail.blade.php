@extends("easyadmin::backend.parent")
@section("content")
@push('mtitle')
{{$title}}
@endpush

<?php
    $specs = $detail_device->asset->specs
    ->pluck('spec_value', 'spec_key');

?>

<div class="pc-container" id="section-list-{{$uri_key}}">
    <div class="pc-content">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <div class="row">
            <div class="col-12">
                <div class= mb-4">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-12">
                                
                                
                                <main class="col-md-12 ms-sm-auto px-md-6 py-4">

                                    <div class="row g-4">
                                        <!-- Left Column: Basic Info & Specs -->
                                        <div class="col-lg-4">
                                            <div class="card p-4 mb-4">
                                                <div class="text-center mb-4">
                                                    <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                                        <i class="ti ti-device-laptop fs-1 text-primary"></i>
                                                    </div>
                                                    <h5 class="fw-bold mb-1">{{ $detail_device->asset->merk . '-' . $detail_device->asset->model }}</h5>
                                                    <span class="badge bg-light-success rounded-pill f-12">
                                                        <i class="ti ti-circle-check-filled fs-6"></i> {{ ucfirst($detail_device->asset->is_status) }} ({{ ucfirst(strtolower($detail_device->employee->nama)) }})
                                                    </span>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    <div class="spec-item">
                                                        <span class="text-muted"><i class="ti ti-barcode me-2"></i>Kode Asset</span>
                                                        <span class="fw-medium">{{ $detail_device->asset->code }}</span>
                                                    </div>
                                                    <div class="spec-item">
                                                        <span class="text-muted"><i class="ti ti-hash me-2"></i>Serial Number</span>
                                                        <span class="fw-medium">{{ $detail_device->asset->serial_number }}</span>
                                                    </div>
                                                    <div class="spec-item">
                                                        <span class="text-muted"><i class="ti ti-calendar me-2"></i>Tahun Beli</span>
                                                        <span class="fw-medium">{{ $detail_device->asset->year_buy }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Dynamic Specifications Section -->
                                            <div class="card p-4">
                                                <h6 class="fw-bold mb-3">Spesifikasi Detail</h6>
                                                <div class="spec-item">
                                                    <span class="text-muted">Processor (CPU)</span>
                                                    <span class="fw-medium text-end">{{ ($specs['cpu'] ?? '-') }}</span>
                                                </div>
                                                <div class="spec-item">
                                                    <span class="text-muted">Memory (RAM)</span>
                                                    <span class="fw-medium">{{ ($specs['ram'] . ' GB' ?? '-') }}</span>
                                                </div>
                                                <div class="spec-item">
                                                    <span class="text-muted">Penyimpanan</span>
                                                    <span class="fw-medium">{{ ($specs['storage'] . ' GB' ?? '-') }}</span>
                                                </div>
                                                <div class="spec-item">
                                                    <span class="text-muted">Sistem Operasi</span>
                                                    <span class="fw-medium">{{ ($specs['os'] ?? '-') }}</span>
                                                </div>
                                                <div class="spec-item">
                                                    <span class="text-muted">Graphic (GPU)</span>
                                                    <span class="fw-medium">{{ ($specs['gpu'] ?? '-') }}</span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <!-- Right Column: Tabs for Details -->
                                        <div class="col-lg-8">
                                            <div class="card">
                                                <div class="card-header bg-white pt-3">
                                                    <ul class="nav nav-tabs card-header-tabs" id="assetTab" role="tablist">
                                                        <li class="nav-item">
                                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#history">
                                                                <i class="ti ti-history me-1"></i> Riwayat Penggunaan
                                                            </button>
                                                        </li>
                                                        <li class="nav-item">
                                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#maintenance">
                                                                <i class="ti ti-settings-automation me-1"></i> Maintenance
                                                            </button>
                                                        </li>
                                                        {{-- <li class="nav-item">
                                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#health">
                                                                <i class="ti ti-devices me-1"></i> Kondisi
                                                            </button>
                                                        </li> --}}
                                                    </ul>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="tab-content">
                                                        <!-- Riwayat Penggunaan -->
                                                        <div class="tab-pane fade show active p-4" id="history">
                                                            <div class="table-responsive">
                                                                <table class="table align-middle">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-muted">Pengguna</th>
                                                                            <th class="text-muted">Keterangan</th>
                                                                            <th class="text-muted">Tanggal Handover</th>
                                                                            <th class="text-muted">Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($detail_device->asset->transactions as $transaction)
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <span class="fw-medium">{{ ucfirst(strtolower($transaction->employee->nama)) }}</span>
                                                                                    </div>
                                                                                </td>
                                                                                <td>{{ $transaction->notes }}</td>
                                                                                <td>{{ $transaction->assigned_date }}</td>
                                                                                <td><span class="{{ $transaction->is_active ? 'badge bg-primary' : 'badge bg-danger' }}">{{ $transaction->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <!-- Maintenance Tab -->
                                                        <div class="tab-pane fade p-4" id="maintenance">
                                                            <div class="d-flex justify-content-between mb-3">
                                                                <h6 class="fw-bold mb-0">Log Perbaikan & Update</h6>
                                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalTambahLog">
                                                                    <i class="ti ti-plus me-1"></i>Tambah Log
                                                                </button>
                                                            </div>
                                                            <div class="list-group list-group-flush">
                                                                @forelse ($detail_device->asset->maintenances as $maintenance)
                                                                    <div class="list-group-item px-0 py-3">
                                                                        <div class="d-flex justify-content-between">
                                                                            <h6 class="mb-1 fw-bold text-primary">{{ $maintenance->name }}</h6>
                                                                            <small class="text-muted">{{ date('d M Y', strtotime($maintenance->date)) }}</small>
                                                                        </div>
                                                                        <p class="mb-1 text-muted small">{{ $maintenance->notes }}</p>
                                                                        @if($maintenance->sparepart)
                                                                            <small class="text-info d-block mb-1"><i class="ti ti-tool me-1"></i>Sparepart: {{ $maintenance->sparepart }}</small>
                                                                        @endif
                                                                        <small class="text-dark">Oleh: <strong>{{ $maintenance->technicial }}</strong></small>
                                                                    </div>
                                                                @empty
                                                                    <div class="text-center py-4">
                                                                        <i class="ti ti-settings-automation fs-1 text-muted"></i>
                                                                        <p class="text-muted mt-2">Belum ada log maintenance</p>
                                                                    </div>
                                                                @endforelse
                                                            </div>
                                                        </div>

                                                        <!-- Health Tab -->
                                                        {{-- <div class="tab-pane fade p-4" id="health">
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <div class="p-3 border rounded">
                                                                        <small class="text-muted d-block mb-2">Kondisi Fisik</small>
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="ti ti-shield-check text-success fs-3 me-2"></i>
                                                                            <h6 class="mb-0 fw-bold">Sangat Baik (95%)</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="p-3 border rounded">
                                                                        <small class="text-muted d-block mb-2">Kondisi Software</small>
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="ti ti-apps text-primary fs-3 me-2"></i>
                                                                            <h6 class="mb-0 fw-bold">Normal / Stabil</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mt-3">
                                                                    <div class="bg-light p-3 rounded">
                                                                        <h6 class="small fw-bold mb-2">Catatan Kerusakan:</h6>
                                                                        <p class="small text-muted mb-0">Keyboard tombol 'D' sedikit keras, namun masih berfungsi normal. Layar bersih tanpa dead pixel.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Log Maintenance -->
<div class="modal fade" id="modalTambahLog" tabindex="-1" aria-labelledby="modalTambahLogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="modalTambahLogLabel">
                    <i class="ti ti-settings-automation me-2"></i>Tambah Log Maintenance
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahLog" action="{{ route('device-detail.maintenance-store') }}" method="POST">
                @csrf
                <input type="hidden" name="asset_id" value="{{ $detail_device->asset->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judulMaintenance" class="form-label fw-bold">
                            Judul Maintenance <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="judulMaintenance" name="name" placeholder="Contoh: Upgrade SSD, Maintenance Rutin" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggalMaintenance" class="form-label fw-bold">
                            Tanggal <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control" id="tanggalMaintenance" name="date" value="{{ date('Y-m-d\TH:i') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="keteranganMaintenance" class="form-label fw-bold">
                            Keterangan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="keteranganMaintenance" name="notes" rows="4" placeholder="Deskripsikan detail perbaikan atau update yang dilakukan..." required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="teknisiMaintenance" class="form-label fw-bold">
                            Teknisi/PIC <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" value="Nayantaka" id="teknisiMaintenance" name="technicial" placeholder="Nama teknisi yang menangani" required>
                    </div>

                    <div class="mb-3">
                        <label for="specificationSelect" class="form-label fw-bold">
                            Specification <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="specificationSelect" name="specification_id" required>
                            <option value="">-- Pilih Specification --</option>
                            <option value="NA">NA (Tidak Ada Sparepart)</option>
                            @foreach($detail_device->asset->specs as $spec)
                                <option value="{{ $spec->id }}" data-key="{{ $spec->spec_key }}" data-value="{{ $spec->spec_value }}">
                                    {{ strtoupper($spec->spec_key) }} - {{ $spec->spec_value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="sparepartInputWrapper" style="display: none;">
                        <label for="sparepartInput" class="form-label fw-bold">
                            Sparepart Baru <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="sparepartInput" name="sparepart_value" placeholder="Masukkan nilai sparepart baru (contoh: SSD 512GB)">
                        <small class="text-muted">Sparepart ini akan mengupdate specification yang dipilih</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i>Simpan Log
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
@if(isset($import_styles))
@foreach($import_styles as $ist)
<link rel="stylesheet" href="{{$ist['source']}}">
@endforeach
@endif
@endpush

@push('scripts')
@if (in_array('create', $permissions))
<div class="offcanvas offcanvas-end @if(isset($drawerExtraClass)) {{ $drawerExtraClass }} @endif" tabindex="-1" id="createForm-{{$uri_key}}" aria-labelledby="createForm-{{$uri_key}}">
    <div class="offcanvas-header border-bottom bg-secondary p-4">
        <h5 class="text-white m-0">Create New</h5>
        <button type="button" class="btn-close text-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="form-create-{{$uri_key}}" action="{{$url_store}}" method="post">
            @csrf
            <div class="row">
                @php $method = "create"; @endphp
                @foreach($fields as $key => $field)
                @if (View::exists('backend.idev.fields.'.$field['type']))
                    @include('backend.idev.fields.'.$field['type'])
                @else
                    @include('easyadmin::backend.idev.fields.'.$field['type'])
                @endif
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group my-2">
                        <button id="btn-for-form-create-{{$uri_key}}" type="button" class="btn btn-outline-secondary" onclick="softSubmit('form-create-{{$uri_key}}', 'list-{{$uri_key}}')">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@if(isset($import_scripts))
@foreach($import_scripts as $isc)
<script src="{{$isc['source']}}"></script>
@endforeach
@endif
<script>
    $(document).ready(function() {
        if ($(".idev-actionbutton").children().length == 0) {
            $("#dropdownMoreTopButton").remove()
            $(".idev-actionbutton").remove()
        }
        idevTable("list-{{$uri_key}}")
        $('form input').on('keypress', function(e) {
            return e.which !== 13;
        });
    })
    $(".search-list-{{$uri_key}}").keyup(delay(function(e) {
        var dInput = this.value;
        if (dInput.length > 3 || dInput.length == 0) {
            $(".current-paginate-{{$uri_key}}").val(1)
            $(".search-list-{{$uri_key}}").val(dInput)
            updateFilter()
        }
    }, 500))

    $("#manydatas-show-{{$uri_key}}").change(function(){
        $(".current-manydatas-{{$uri_key}}").val($(this).val())
        idevTable("list-{{$uri_key}}")
    });

    function updateFilter() {
        var queryParam = $("#form-filter-list-{{$uri_key}}").serialize();
        var currentHrefPdf = $("#export-pdf").attr('data-base-url')
        var currentHrefExcel = $("#export-excel").attr('data-base-url')

        $("#export-pdf").attr('href', currentHrefPdf + "?" + queryParam)
        $("#export-excel").attr('href', currentHrefExcel + "?" + queryParam)
        idevTable("list-{{$uri_key}}")
    }

    // Auto close modal and show success message
    @if(session('success'))
        var modalElement = document.getElementById('modalTambahLog');
        if (modalElement) {
            var modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
            // Reset form
            document.getElementById('formTambahLog').reset();
            // Reset visibility
            $('#sparepartInputWrapper').hide();
            $('#sparepartInput').removeAttr('required');
        }
    @endif

    // Toggle sparepart input based on specification selection
    $('#specificationSelect').on('change', function() {
        var selectedValue = $(this).val();
        var sparepartWrapper = $('#sparepartInputWrapper');
        var sparepartInput = $('#sparepartInput');
        
        if (selectedValue && selectedValue !== 'NA') {
            // Show sparepart input
            sparepartWrapper.show();
            sparepartInput.attr('required', 'required');
            
            // Set placeholder based on selected specification
            var selectedOption = $(this).find(':selected');
            var specKey = selectedOption.data('key');
            var specValue = selectedOption.data('value');
            
            if (specKey && specValue) {
                sparepartInput.attr('placeholder', 'Nilai saat ini: ' + specValue);
            }
        } else {
            // Hide sparepart input
            sparepartWrapper.hide();
            sparepartInput.removeAttr('required');
            sparepartInput.val('');
        }
    });

    // Reset form when modal is closed
    $('#modalTambahLog').on('hidden.bs.modal', function () {
        $('#formTambahLog')[0].reset();
        $('#sparepartInputWrapper').hide();
        $('#sparepartInput').removeAttr('required');
    });
</script>
@foreach($actionButtonViews as $key => $abv)
@include($abv)
@endforeach
@endpush
@endsection