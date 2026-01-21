# Temperature Scanner - QR Code Format

## Format QR Code

QR Code hanya berisi **location code** (tanpa prefix):
- Contoh: `LOC-001`, `LOC-WH-A1`, `ZONE-COLD-01`

System akan otomatis mencari monitoring point atau mapping study point berdasarkan location code yang aktif.

## Contoh QR Code

### Location Code "LOC-001"
```
LOC-001
```

### Location Code "ZONE-COLD-01"
```
ZONE-COLD-01
```

## Cara Kerja

1. Scan QR code yang berisi location code
2. System akan mencari location berdasarkan code (hanya location dengan status **active**)
3. System akan mencari monitoring_point atau mapping_study_point yang terhubung dengan location tersebut
4. Form akan otomatis terisi dengan data point yang ditemukan
5. Input temperature dan submit

## Cara Membuat QR Code

Anda dapat membuat QR code menggunakan generator online seperti:
- https://www.qr-code-generator.com/
- https://www.the-qrcode-generator.com/

Atau menggunakan library PHP seperti:
- SimpleSoftwareIO/simple-qrcode
- endroid/qr-code

## Contoh Generate QR Code (Laravel)

Install package:
```bash
composer require simplesoftwareio/simple-qrcode
```

Generate QR Code:
```php
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// Location Code "LOC-001"
QrCode::format('png')->size(300)->generate('LOC-001', public_path('qrcodes/LOC-001.png'));

// Location Code "ZONE-COLD-01"
QrCode::format('png')->size(300)->generate('ZONE-COLD-01', public_path('qrcodes/ZONE-COLD-01.png'));
```

## Fitur Scanner

1. **Scan QR Code**: Klik tombol "Start Scanning" untuk memulai scanner
2. **Auto-Detection**: System otomatis mendeteksi apakah location tersebut untuk monitoring atau mapping
3. **Auto-Fill Form**: Form akan otomatis terisi dengan data point berdasarkan location code
4. **Input Temperature**: Masukkan nilai suhu dan waktu pencatatan
5. **Submit**: Klik "Submit Temperature Reading" untuk menyimpan data
6. **Recent Readings**: Lihat 5 pembacaan terakhir untuk point tersebut

## Catatan Penting

- QR Code hanya berisi **location code** saja (tanpa prefix "monitoring:" atau "mapping:")
- System akan mencari location dengan status **active**
- System akan otomatis mendeteksi tipe point (monitoring atau mapping) berdasarkan data yang tersedia
- Pastikan location sudah memiliki monitoring_point atau mapping_study_point sebelum scan
- Jika location tidak memiliki point, system akan menampilkan error
