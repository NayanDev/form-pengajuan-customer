<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengajuan Data Customer</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-size: 12px;
            margin: 0;
            padding: 0;
            font-family: 'Tahoma', Geneva, sans-serif;
        }
        
        .header {
            text-align: center;
        }

        .container {
            /* border: 1px solid black; */
        }

        .text-start {
            text-align: left;
        }

        .letterhead {
            position: relative;
            margin-bottom: 10px;
            overflow: visible;
            padding-bottom: 10px;
            /* border: 1px solid black; */
        }

        .letterhead img {
            position: absolute;
            width: 40px;
            padding-top: 13px;
            padding-left: 10px;
            /* border: 1px solid green; */
        }

        .letterhead h3 {
            /* margin-top: 20px; */
            margin-bottom: 0;
            text-align: right;
            /* padding: 10px; */
            /* border: 1px solid red; */
            padding: 0px;
        }

        .letterhead p {
            text-align: right;
            margin-top: 0;
            margin-bottom: 20px;
            padding: 0px;
            /* border:1px solid blue; */
        }

        .info-section {
            margin-bottom: 15px;
            font-size: 14px;
            /* border: 1px solid salmon; */
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            border: none;
            /* text-align: center; */
        }

        .no-border {
            border: none !important;
        }

        .th {
            border: 1px solid black;
            font-size: 7px;
            margin: 0;
            padding: 0;
            text-align: center;
            vertical-align: middle;
            height: 80px;
            width: 25px;
            position: relative;
            /* Tambahkan ini */
        }

        .rotate-text {
            position: absolute;
            /* Posisi absolute agar bisa full */
            top: 50%;
            /* Posisi vertical center */
            left: 50%;
            /* Posisi horizontal center */
            transform: translate(-50%, -50%) rotate(-90deg);
            /* Gabung translate dan rotate */
            width: 80px;
            /* Sesuaikan dengan height th */
            display: flex;
            /* Gunakan flex untuk centering content */
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .highlight {
            background-color: gray;
            /* Warna kuning */
        }

        .penilaian {
            margin:0;
            padding:0;
            text-align:center;
            border:none;
        }

        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PENGAJUAN DATA CUSTOMER</h2>
        <p>Kode Customer : ................................... <br> (diisi oleh HO)</p>
    </div>

    <br><br>

    <table>
        <tr>
            <td width="2%">1.</td>
            <td width="25%">Tanggal Registrasi</td>
            <td width="2%">:</td>
            <td>{{ $customer->tanggal_registrasi }}</td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Status Customer</td>
            <td>:</td>
            <td>{{ $customer->status_customer }}</td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Cabang Pengajuan</td>
            <td>:</td>
            <td>{{ $customer->cabang_pengajuan }}</td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Nama Customer</td>
            <td>:</td>
            <td>{{ $customer->nama_customer }}</td>
        </tr>
        <tr>
            <td>5.</td>
            <td>Telepon</td>
            <td>:</td>
            <td>{{ $customer->telepon }}</td>
        </tr>
        <tr>
            <td>6.</td>
            <td>Email</td>
            <td>:</td>
            <td>{{ $customer->alamat_email }}</td>
        </tr>
        <tr>
            <td>7.</td>
            <td>No KTP</td>
            <td>:</td>
            <td>{{ $customer->no_ktp }}</td>
        </tr>
        <tr>
            <td>8.</td>
            <td>Alamat Outlet</td>
            <td>:</td>
            <td>{{ $customer->alamat_outlet }}</td>
        </tr>
        <tr>
            <td>9.</td>
            <td>Tipe Customer</td>
            <td>:</td>
            <td>{{ $customer->tipe_customer }}</td>
        </tr>
        <tr>
            <td>10.</td>
            <td>No Fax</td>
            <td>:</td>
            <td>{{ $customer->no_fax }}</td>
        </tr>
        <tr>
            <td>11.</td>
            <td>Nama PIC</td>
            <td>:</td>
            <td>{{ $customer->nama_pic }}</td>
        </tr>
        <tr>
            <td>12.</td>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $customer->jabatan }}</td>
        </tr>
        <tr>
            <td>13.</td>
            <td>Alasan Perubahan</td>
            <td>:</td>
            <td>{{ $customer->alasan_perubahan }}</td>
        </tr>
        <tr>
            <td>14.</td>
            <td>Izin Operasional</td>
            <td>:</td>
            <td>{{ $customer->izin_operasional }}</td>
        </tr>
        <tr>
            <td>15.</td>
            <td>Masa Berlaku Izin Operasional</td>
            <td>:</td>
            <td>{{ $customer->masa_berlaku_izin_operasional }}</td>
        </tr>
        <tr>
            <td>16.</td>
            <td>SIPA</td>
            <td>:</td>
            <td>{{ $customer->sipa }}</td>
        </tr>
        <tr>
            <td>17.</td>
            <td>Masa Berlaku SIPA</td>
            <td>:</td>
            <td>{{ $customer->masa_berlaku_sipa }}</td>
        </tr>
        <tr>
            <td>18.</td>
            <td>CDOB</td>
            <td>:</td>
            <td>{{ $customer->cdob }}</td>
        </tr>
        <tr>
            <td>19.</td>
            <td>Masa Berlaku CDOB</td>
            <td>:</td>
            <td>{{ $customer->masa_berlaku_cdob }}</td>
        </tr>
        <tr>
            <td>20.</td>
            <td>No NPWP Outlet</td>
            <td>:</td>
            <td>{{ $customer->no_npwp_outlet }}</td>
        </tr>
        <tr>
            <td>21.</td>
            <td>Nama NPWP</td>
            <td>:</td>
            <td>{{ $customer->nama_npwp }}</td>
        </tr>
        <tr>
            <td>22.</td>
            <td>Alamat NPWP</td>
            <td>:</td>
            <td>{{ $customer->alamat_npwp }}</td>
        </tr>
        <tr>
            <td>23.</td>
            <td>ID Sales</td>
            <td>:</td>
            <td>{{ $customer->id_sales }}</td>
        </tr>
        <tr>
            <td>24.</td>
            <td>GL Akun Piutang</td>
            <td>:</td>
            <td>{{ $customer->gl_akun_piutang }}</td>
        </tr>
        {{-- <tr>
            <td>25.</td>
            <td>Sumber Dana</td>
            <td>:</td>
            <td>{{ $customer->sumber_dana }}</td>
        </tr>
        <tr>
            <td>26.</td>
            <td>Tanda Tangan APJ</td>
            <td>:</td>
            <td>{{ $customer->ttd_apj }}</td>
        </tr>
        <tr>
            <td>27.</td>
            <td>Nama Terang</td>
            <td>:</td>
            <td>{{ $customer->nama_terang }}</td>
        </tr>
        <tr>
            <td>28.</td>
            <td>Dokumen Pendukung</td>
            <td>:</td>
            <td>{{ $customer->dokumen_pendukung }}</td>
        </tr> --}}
    </table>
    <br><br><br>
    Tanda Tangan
    <br>
    <img src="{{ asset('ttd/' . $customer->ttd_apj) }}" alt="{{ $customer->nama_terang }}" width="200"> <br>
    {{ $customer->nama_terang }}
</body>
</html>