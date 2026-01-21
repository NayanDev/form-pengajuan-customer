<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Suhu</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Tahoma', Geneva, sans-serif;
            box-sizing: border-box;
        }
        .container {       
            margin: 0px auto;
            background-color: #fff;
            color: #000;
            text-align: center;
            /* border: 1px solid black; */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            /* border: 1px solid black; */
        }
        tr, td, th {
            padding: 8px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .border {
            border: 1px solid black;
        }
        .noborder {
            border: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <table>
            <tr class="border">
                <td colspan="2">
                    <img src="{{ asset('img/long-logo-spt.png') }}" alt="Logo SPT" width="150px">
                </td>
                <td colspan="3">
                    <h3 class="text-center">LABEL PEMANTAUAN KONDISI RUANGAN</h3>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <table class="noborder">
                        <tr>
                            <td width="15%">Lokasi</td>
                            <td width="3%">:</td>
                            <td>{{ $location->warehouse->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Bagian</td>
                            <td>:</td>
                            <td>{{ $location->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Bulan</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}</td>
                        </tr>
                        <tr>
                            <td>Parameter</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Suhu (T)</td>
                            <td>:</td>
                            <td> &lt; 30 °C</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="10%" rowspan="2" class="border text-center">Tgl</td>
                <td width="20%" class="border text-center">09.00</td>
                <td width="20%" class="border text-center">13.00</td>
                <td width="20%" class="border text-center">16.00</td>
                <td width="30%" rowspan="2" class="border text-center">User</td>
            </tr>
            <tr>
                <td class="border text-center">T (°C)</td>
                <td class="border text-center">T (°C)</td>
                <td class="border text-center">T (°C)</td>
            </tr>
            {{-- Full 1 month - Optimized Version --}}
            @php
                $now = \Carbon\Carbon::now();
                $daysInMonth = \Carbon\Carbon::create($year, $month)->daysInMonth;
                
                // Pre-process all data in a single pass for better performance
                $processedData = [];
                
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $currentDate = \Carbon\Carbon::create($year, $month, $day);
                    $isFuture = $currentDate->gt($now->copy()->endOfDay());
                    
                    $processedData[$day] = [
                        'temps' => [9 => null, 13 => null, 16 => null],
                        'users' => [],
                        'isFuture' => $isFuture
                    ];
                    
                    // Process each time slot
                    foreach ([9, 13, 16] as $hour) {
                        $dateKey = sprintf('%04d-%02d-%02d %02d:00:00', $year, $month, $day, $hour);
                        
                        if (isset($readings[$dateKey])) {
                            $reading = $readings[$dateKey]->first();
                            $processedData[$day]['temps'][$hour] = number_format($reading->value, 1);
                            
                            if ($reading->user && !in_array($reading->user->name, $processedData[$day]['users'])) {
                                $processedData[$day]['users'][] = $reading->user->name;
                            }
                        }
                    }
                    
                    // Set default values based on date status
                    $defaultValue = $isFuture ? ' ' : '-';
                    foreach ([9, 13, 16] as $hour) {
                        if ($processedData[$day]['temps'][$hour] === null) {
                            $processedData[$day]['temps'][$hour] = $defaultValue;
                        }
                    }
                    
                    // Format user names
                    $processedData[$day]['user'] = !empty($processedData[$day]['users']) 
                        ? implode(', ', $processedData[$day]['users']) 
                        : $defaultValue;
                }
            @endphp
            @foreach ($processedData as $day => $data)
            <tr>
                <td class="border text-center">{{ $day }}</td>
                <td class="border text-center">{{ $data['temps'][9] }}</td>
                <td class="border text-center">{{ $data['temps'][13] }}</td>
                <td class="border text-center">{{ $data['temps'][16] }}</td>
                <td class="border text-center">{{ $data['user'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>