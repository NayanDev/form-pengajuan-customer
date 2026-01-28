@extends("easyadmin::backend.parent")
@section("content")
@push('mtitle')
{{$title}}
@endpush
<div class="pc-container" id="section-list-{{$uri_key}}">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <h3 class="text-center">LABEL PEMANTAUAN KONDISI RUANGAN</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-12">
                                <table>
                                    <tr class="border">
                                        <td colspan="2">
                                            <img src="{{ asset('img/long-logo-spt.png') }}" alt="Logo SPT" height="70px">
                                        </td>
                                        <td colspan="3">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <table class="noborder">
                                                <tr>
                                                    <td width="15%">Lokasi</td>
                                                    <td width="3%">:</td>
                                                    <td>{{ $mapping_study->location->warehouse->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bagian</td>
                                                    <td>:</td>
                                                    <td>{{ $mapping_study->location->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bulan</td>
                                                    <td>:</td>
                                                    <td>{{ \Carbon\Carbon::create(now()->year, now()->month)->translatedFormat('F Y') ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Parameter</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Suhu (T)</td>
                                                    <td>:</td>
                                                    <td> &lt; 30 °C</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td width="10%" rowspan="3" class="border text-center">Tgl</td>
                                        <td class="border text-center">
                                            <strong>
                                                <span>MIN</span> <br>
                                                {{ isset($min_value) ? number_format($min_value, 1) . ' °C' : '-' }}
                                            </strong>
                                        </td>
                                        <td class="border text-center">
                                            <strong>
                                                <span>MAX</span> <br>
                                                {{ isset($max_value) ? number_format($max_value, 1) . ' °C' : '-' }}
                                            </strong>
                                        </td>
                                        <td class="border text-center">
                                            <strong>
                                                <span>AVG</span> <br>
                                                {{ isset($avg_value) ? number_format($avg_value, 1) . ' °C' : '-' }}
                                            </strong>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td width="10%" rowspan="2" class="border text-center">Tgl</td>
                                        <td width="20%" class="border text-center">09.00</td>
                                        <td width="20%" class="border text-center">13.00</td>
                                        <td width="20%" class="border text-center">16.00</td>
                                    </tr>
                                    <tr>
                                        <td class="border text-center">T (°C)</td>
                                        <td class="border text-center">T (°C)</td>
                                        <td class="border text-center">T (°C)</td>
                                    </tr>
                                    {{-- Full 1 month - Optimized Version --}}
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $year = request('year', now()->year);
                                        $month = request('month', now()->month);
                                        $daysInMonth = \Carbon\Carbon::create($year, $month)->daysInMonth;
                                        $category = request('category');
                                        
                                        // Group readings by date and hour
                                        $groupedReadings = [];
                                        
                                        if($category === 'monitoring') {
                                            // Untuk kategori monitoring, gunakan readings dari MonitoringPoint
                                            foreach($mapping_study->readings as $reading) {
                                                $date = \Carbon\Carbon::parse($reading->recorded_at);
                                                $day = $date->day;
                                                $hour = (int) $date->format('H');
                                                
                                                if (!isset($groupedReadings[$day])) {
                                                    $groupedReadings[$day] = [
                                                        9 => null,
                                                        13 => null,
                                                        16 => null
                                                    ];
                                                }
                                                
                                                // Map to closest time slot
                                                if ($hour >= 0 && $hour < 12) {
                                                    $groupedReadings[$day][9] = $reading;
                                                } elseif ($hour >= 12 && $hour < 15) {
                                                    $groupedReadings[$day][13] = $reading;
                                                } else {
                                                    $groupedReadings[$day][16] = $reading;
                                                }
                                            }
                                        } else {
                                            // Untuk kategori mapping, gunakan mappings seperti biasa
                                            foreach($mapping_study->mappings as $mapping) {
                                                $date = \Carbon\Carbon::parse($mapping->recorded_at);
                                                $day = $date->day;
                                                $hour = (int) $date->format('H');
                                                
                                                if (!isset($groupedReadings[$day])) {
                                                    $groupedReadings[$day] = [
                                                        9 => null,
                                                        13 => null,
                                                        16 => null
                                                    ];
                                                }
                                                
                                                // Map to closest time slot
                                                if ($hour >= 0 && $hour < 12) {
                                                    $groupedReadings[$day][9] = $mapping;
                                                } elseif ($hour >= 12 && $hour < 15) {
                                                    $groupedReadings[$day][13] = $mapping;
                                                } else {
                                                    $groupedReadings[$day][16] = $mapping;
                                                }
                                            }
                                        }
                                    @endphp
                                    
                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $currentDate = \Carbon\Carbon::create($year, $month, $day);
                                        $isFuture = $currentDate->gt($now->copy()->endOfDay());
                                    @endphp
                                    <tr>
                                        <td class="border text-center">{{ $day }}</td>
                                        
                                        {{-- Jam 09.00 --}}
                                        <td class="border text-center">
                                            @if(isset($groupedReadings[$day][9]) && $groupedReadings[$day][9])
                                                {{ number_format($groupedReadings[$day][9]->value, 1) }}°C <br>
                                                <small>{{ $groupedReadings[$day][9]->user->name ?? 'N/A' }}</small> <br>
                                                <small>{{ \Carbon\Carbon::parse($groupedReadings[$day][9]->recorded_at)->format('H:i') }}</small>
                                            @else
                                                {{ $isFuture ? '' : '-' }}
                                            @endif
                                        </td>
                                        
                                        {{-- Jam 13.00 --}}
                                        <td class="border text-center">
                                            @if(isset($groupedReadings[$day][13]) && $groupedReadings[$day][13])
                                                {{ number_format($groupedReadings[$day][13]->value, 1) }}°C <br>
                                                <small>{{ $groupedReadings[$day][13]->user->name ?? 'N/A' }}</small> <br>
                                                <small>{{ \Carbon\Carbon::parse($groupedReadings[$day][13]->recorded_at)->format('H:i') }}</small>
                                            @else
                                                {{ $isFuture ? '' : '-' }}
                                            @endif
                                        </td>
                                        
                                        {{-- Jam 16.00 --}}
                                        <td class="border text-center">
                                            @if(isset($groupedReadings[$day][16]) && $groupedReadings[$day][16])
                                                {{ number_format($groupedReadings[$day][16]->value, 1) }}°C <br>
                                                <small>{{ $groupedReadings[$day][16]->user->name ?? 'N/A' }}</small> <br>
                                                <small>{{ \Carbon\Carbon::parse($groupedReadings[$day][16]->recorded_at)->format('H:i') }}</small>
                                            @else
                                                {{ $isFuture ? '' : '-' }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
</script>
@foreach($actionButtonViews as $key => $abv)
@include($abv)
@endforeach
@endpush
@endsection