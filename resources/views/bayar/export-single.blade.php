<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran UKT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
        }

        .info {
            margin-bottom: 25px;
        }

        .info div {
            margin-bottom: 5px;
        }

        .label {
            display: inline-block;
            width: 150px;
            font-weight: bold;
        }

        .signature {
            margin-top: 80px;
            text-align: right;
        }

        .signature p {
            margin-bottom: 70px;
        }

        .border-box {
            border: 1px solid #444;
            padding: 20px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Bukti Pembayaran UKT</h2>
        <p>Universitas Muhammdiyah Karanganyar</p>
    </div>

    <div class="border-box">
        <div class="info">
            <div><span class="label">Nama Mahasiswa</span>: {{ $data->mahasiswa->mhsw_nama }}</div>
            <div><span class="label">NIM</span>: {{ $data->mahasiswa->mhsw_nim }}</div>
            <div><span class="label">Alamat</span>: {{ $data->mahasiswa->mhsw_alamat ?? '-' }}</div>
            <div><span class="label">Tanggal Bayar</span>: {{ \Carbon\Carbon::parse($data->tanggal_bayar)->translatedFormat('d F Y') }}</div>
            <div><span class="label">Jumlah</span>: Rp. {{ number_format($data->jumlah, 0, ',', '.') }}</div>
            <div><span class="label">Keterangan</span>: {{ $data->keterangan }}</div>
        </div>
    </div>

    <div class="signature">
        <p>Petugas Keuangan</p>
        <p>__________________________</p>
        <p>{{ now()->translatedFormat('d F Y') }}</p>
    </div>

</body>
</html>
