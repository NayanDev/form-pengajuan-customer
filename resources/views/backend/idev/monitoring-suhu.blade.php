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
            padding: 20px;
            margin: 0px auto;
            background-color: #fff;
            color: #000;
            text-align: center;
            border: 1px solid black;
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
                            <td>{{ '-' }}</td>
                        </tr>
                        <tr>
                            <td>Bagian</td>
                            <td>:</td>
                            <td>{{ '-'  }}</td>
                        </tr>
                        <tr>
                            <td>Bulan</td>
                            <td>:</td>
                            <td>{{ '-' }}</td>
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
            <tr>
                <td width="10%" rowspan="3" class="border text-center">Tgl</td>
                <td class="border text-center">
                    <strong>
                        <span>MIN</span> <br>
                        30 °C
                    </strong>
                </td>
                <td class="border text-center">
                    <strong>
                        <span>MAX</span> <br>
                        30 °C
                    </strong>
                </td>
                <td class="border text-center">
                    <strong>
                        <span>AVG</span> <br>
                        30 °C
                    </strong>
                </td>
            </tr>
            <tr>
                <td width="20%" class="border text-center">Checking Jam 09.00</td>
                <td width="20%" class="border text-center">Checking Jam 13.00</td>
                <td width="20%" class="border text-center">Checking Jam 16.00</td>
            </tr>
            <tr>
                <td class="border text-center">T (°C)</td>
                <td class="border text-center">T (°C)</td>
                <td class="border text-center">T (°C)</td>
            </tr>
            {{-- Full 1 month - Optimized Version --}}
            
            <tr>
                <td class="border text-center">1</td>
                <td class="border text-center">
                    23 <br>
                    <span>Nayantaka</span> <br>
                    <span>2026-01-19 15:58:00</span>

                </td>
                <td class="border text-center">23</td>
                <td class="border text-center">23</td>  
            </tr>
        </table>
    </div>
</body>
</html>