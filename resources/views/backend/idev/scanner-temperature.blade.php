@extends("easyadmin::backend.parent")
@section("content")
@push('mtitle')
{{$title}}
@endpush

<?php

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
                                        <!-- Left Column: QR Scanner -->
                                        <div class="col-lg-5">
                                            <div class="card p-4 mb-4">
                                                <h5 class="mb-3"><i class="ti ti-qrcode me-2"></i>Scan QR Code</h5>
                                                <div id="qr-reader" style="width: 100%; border-radius: 8px; overflow: hidden;"></div>
                                                <div class="mt-3">
                                                    <button id="startScan" class="btn btn-primary w-100" onclick="startScanner()">
                                                        <i class="ti ti-scan me-2"></i>Start Scanning
                                                    </button>
                                                    <button id="stopScan" class="btn btn-danger w-100 mt-2" style="display: none;" onclick="stopScanner()">
                                                        <i class="ti ti-x me-2"></i>Stop Scanning
                                                    </button>
                                                </div>
                                                <div class="mt-3">
                                                    <small class="text-muted">Scan QR code location untuk temperature monitoring</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-7">
                                            <div class="card" id="formCard" style="display: none;">
                                                <div class="card-body p-4">
                                                    <h5 class="mb-4"><i class="ti ti-temperature me-2"></i>Temperature Monitoring Form</h5>
                                                    
                                                    <!-- Today's Status Info -->
                                                    <div class="alert alert-info mb-3" id="todayStatusAlert" style="display: none;">
                                                        <strong><i class="ti ti-info-circle me-2"></i>Status Hari Ini:</strong>
                                                        <div id="todayStatusContent" class="mt-2"></div>
                                                    </div>
                                                    
                                                    <form id="temperatureForm" method="POST" action="{{ route('scanner-temperature.store') }}">
                                                        @csrf
                                                        <input type="hidden" name="point_type" id="pointType">
                                                        <input type="hidden" name="point_id" id="pointId">
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Type</label>
                                                                <input type="text" class="form-control" id="displayType" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Code</label>
                                                                <input type="text" class="form-control" id="displayCode" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Location</label>
                                                                <input type="text" class="form-control" id="displayLocation" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Description</label>
                                                                <input type="text" class="form-control" id="displayDescription" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Temperature Value <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="number" step="0.01" class="form-control" name="value" id="tempValue" placeholder="25.5" required>
                                                                    <span class="input-group-text">°C</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Recorded At <span class="text-danger">*</span></label>
                                                                <input type="datetime-local" class="form-control" name="recorded_at" id="recordedAt" readonly>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-primary w-100">
                                                                    <i class="ti ti-device-floppy me-2"></i>Submit Temperature Reading
                                                                </button>
                                                                <button type="button" class="btn btn-light w-100 mt-2" onclick="resetForm()">
                                                                    <i class="ti ti-refresh me-2"></i>Reset & Scan Again
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Recent Readings Table -->
                                            <div class="card mt-3" id="recentReadingsCard" style="display: none;">
                                                <div class="card-body p-4">
                                                    <h5 class="mb-3"><i class="ti ti-history me-2"></i>Recent Readings</h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date/Time</th>
                                                                    <th>Value</th>
                                                                    <th>User</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="recentReadingsBody">
                                                                <!-- Akan diisi via JavaScript -->
                                                            </tbody>
                                                        </table>
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

@push('styles')
<style>
    #qr-reader {
        border: 2px solid #e0e0e0;
    }
    #qr-reader video {
        border-radius: 8px;
    }
</style>
@if(isset($import_styles))
@foreach($import_styles as $ist)
<link rel="stylesheet" href="{{$ist['source']}}">
@endforeach
@endif
@endpush

@push('scripts')
<!-- QR Code Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let html5QrCode;
    let isScanning = false;

    function startScanner() {
        if (isScanning) return;
        
        html5QrCode = new Html5Qrcode("qr-reader");
        
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            onScanSuccess,
            onScanError
        ).then(() => {
            isScanning = true;
            document.getElementById('startScan').style.display = 'none';
            document.getElementById('stopScan').style.display = 'block';
        }).catch(err => {
            console.error("Error starting scanner:", err);
            alert("Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.");
        });
    }

    function stopScanner() {
        if (!isScanning || !html5QrCode) return;
        
        html5QrCode.stop().then(() => {
            isScanning = false;
            document.getElementById('startScan').style.display = 'block';
            document.getElementById('stopScan').style.display = 'none';
        }).catch(err => {
            console.error("Error stopping scanner:", err);
        });
    }

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Scan result: ${decodedText}`);
        stopScanner();
        
        // Parse QR code data
        // Expected format: just location code (e.g., "LOC-001")
        try {
            const code = decodedText.trim();
            
            if (!code) {
                throw new Error('QR code kosong');
            }
            
            // Fetch point details via AJAX
            fetchPointDetails(code);
            
        } catch (error) {
            alert('QR Code tidak valid! Scan ulang QR code dengan location code yang benar.');
            console.error(error);
        }
    }

    function onScanError(errorMessage) {
        // Ignore scan errors (happens when no QR code is detected)
    }

    function fetchPointDetails(code) {
        // Show loading
        $.ajax({
            url: '{{ route("scanner-temperature.get-point") }}',
            method: 'GET',
            data: {
                code: code
            },
            success: function(response) {
                if (response.success) {
                    // Populate form
                    document.getElementById('pointType').value = response.data.type;
                    document.getElementById('pointId').value = response.data.id;
                    document.getElementById('displayType').value = response.data.type === 'monitoring' ? 'Monitoring' : 'Mapping Study';
                    document.getElementById('displayCode').value = code;
                    document.getElementById('displayLocation').value = response.data.location || '-';
                    document.getElementById('displayDescription').value = response.data.description || '-';
                    
                    // Set current datetime
                    const now = new Date();
                    const datetime = now.getFullYear() + '-' + 
                                   String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                   String(now.getDate()).padStart(2, '0') + 'T' + 
                                   String(now.getHours()).padStart(2, '0') + ':' + 
                                   String(now.getMinutes()).padStart(2, '0');
                    document.getElementById('recordedAt').value = datetime;
                    
                    // Show form
                    document.getElementById('formCard').style.display = 'block';
                    
                    // Show today's status
                    // if (response.data.today_status) {
                    //     let statusHtml = '<div class="row">';
                    //     statusHtml += '<div class="col-4"><span class="badge text-dark ' + (response.data.today_status.pagi ? 'bg-success-subtle' : 'bg-light') + '">Pagi (00-12): ' + (response.data.today_status.pagi ? response.data.today_status.pagi : 'Belum') + '</span></div>';
                    //     statusHtml += '<div class="col-4"><span class="badge text-dark ' + (response.data.today_status.siang ? 'bg-success-subtle' : 'bg-light') + '">Siang (12-15): ' + (response.data.today_status.siang ? response.data.today_status.siang : 'Belum') + '</span></div>';
                    //     statusHtml += '<div class="col-4"><span class="badge text-dark ' + (response.data.today_status.sore ? 'bg-success-subtle' : 'bg-light') + '">Sore (15-24): ' + (response.data.today_status.sore ? response.data.today_status.sore : 'Belum') + '</span></div>';
                    //     statusHtml += '</div>';
                    //     document.getElementById('todayStatusContent').innerHTML = statusHtml;
                    //     document.getElementById('todayStatusAlert').style.display = 'block';
                    // }
                    
                    // Load recent readings
                    if (response.data.recent_readings && response.data.recent_readings.length > 0) {
                        let tableHtml = '';
                        response.data.recent_readings.forEach(reading => {
                            tableHtml += `
                                <tr>
                                    <td>${reading.recorded_at}</td>
                                    <td><strong>${reading.value}°C</strong></td>
                                    <td>${reading.user_name}</td>
                                </tr>
                            `;
                        });
                        document.getElementById('recentReadingsBody').innerHTML = tableHtml;
                        document.getElementById('recentReadingsCard').style.display = 'block';
                    }
                    
                    // Focus on temperature input
                    document.getElementById('tempValue').focus();
                } else {
                    alert('Data tidak ditemukan: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat mengambil data');
                console.error(xhr);
            }
        });
    }

    function resetForm() {
        document.getElementById('temperatureForm').reset();
        document.getElementById('formCard').style.display = 'none';
        document.getElementById('recentReadingsCard').style.display = 'none';
        document.getElementById('todayStatusAlert').style.display = 'none';
        document.getElementById('pointType').value = '';
        document.getElementById('pointId').value = '';
    }

    // Set datetime on page load
    $(document).ready(function() {
        const now = new Date();
        const datetime = now.getFullYear() + '-' + 
                       String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                       String(now.getDate()).padStart(2, '0') + 'T' + 
                       String(now.getHours()).padStart(2, '0') + ':' + 
                       String(now.getMinutes()).padStart(2, '0');
        document.getElementById('recordedAt').value = datetime;
    });
</script>

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