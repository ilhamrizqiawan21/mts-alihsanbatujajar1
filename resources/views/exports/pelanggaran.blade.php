<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
<h3>Data Pelanggaran</h3>
<table>
    <thead><tr><th>Siswa</th><th>Kelas</th><th>Jenis Pelanggaran</th><th>Tanggal</th><th>Keterangan</th></tr></thead>
    <tbody>
        @foreach($pelanggarans as $item)
            <tr><td>{{ $item->siswa?->nama ?? '-' }}</td><td>{{ $item->siswa?->kelas?->nama_kelas ?? '-' }}</td><td>{{ $item->jenisPelanggaran?->nama ?? '-' }}</td><td>{{ $item->tanggal?->format('Y-m-d') ?? '-' }}</td><td>{{ $item->keterangan ?? '-' }}</td></tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
