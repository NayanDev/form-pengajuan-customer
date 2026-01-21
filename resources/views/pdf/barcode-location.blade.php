<?php
    $code = request('code');
    
    // Cek apakah $locations ada dan tidak kosong
    if (empty($locations)) {
        $locationsArray = [];
    } else {
        // Pastikan $locations selalu array
        $locationsArray = is_array($locations) || $locations instanceof \Illuminate\Support\Collection 
            ? $locations 
            : [$locations];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barcode Location</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Tahoma', Geneva, sans-serif;
        }

        .container {       
            margin: 0 auto;
            background-color: #fff;
            color: #000;
            text-align: center;
        }

        /* Section barcode */
        .barcode-section {
            display: inline-block;
            border: 2px solid #000;
            padding: 10px;
            text-align: center;
            border-radius: 20px;
            margin: 10px auto;
        }

        .barcode-section h4,
        .barcode-section h5,
        .barcode-section h6 {
            margin: 0;
            padding: 0;
        }

        /* Garis potong */
        .border-cut {  
            display: inline-block;
            margin: 50px 5px 0px 5px;
            padding: 0px 20px;      
            border: 2px dashed #000;
            border-radius: 20px;
            page-break-inside: avoid;
            page-break-after: auto;
            vertical-align: top;
        }

        /* Pesan error */
        .error-message {
            margin: 100px auto;
            padding: 30px;
            text-align: center;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            max-width: 500px;
        }

        .error-message h3 {
            margin: 0 0 10px 0;
            font-size: 24px;
        }

        .error-message p {
            margin: 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        @if(empty($locationsArray))
            <div class="error-message">
                <h3>Data Tidak Ditemukan</h3>
                <p>Lokasi dengan kode <strong>{{ $code ?? '-' }}</strong> tidak ditemukan dalam sistem.</p>
            </div>
        @else
            @foreach($locationsArray as $location)
                <div class="border-cut">
                    <div class="barcode-section">
                        <h4>{{ $location->code }}</h4>
                        <br>
                        {!! DNS2D::getBarcodeHTML($location->code, 'QRCODE', 8, 8) !!} 
                        <br>
                        <h5>{{ $location->name }}</h5>
                        <h6>{{ $location->warehouse->name }}</h6>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>