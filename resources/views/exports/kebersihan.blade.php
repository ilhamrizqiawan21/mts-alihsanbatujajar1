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
<h3>Data Kebersihan Kelas</h3>
<table>
    <thead><tr><th>Kelas</th><th>Tanggal</th><th>Nilai Lantai</th><th>Nilai Sampah</th><th>Nilai Rak</th><th>Nilai Penataan</th><th>Total Nilai</th><th>Keterangan</th></tr></thead>
    <tbody>
        @foreach($records as $record)
            <tr><td>{{ $record->kelas?->nama_kelas ?? '-' }}</td><td>{{ $record->tanggal?->format('Y-m-d') ?? '-' }}</td><td>{{ $record->nilai_lantai }}</td><td>{{ $record->nilai_sampah }}</td><td>{{ $record->nilai_rak }}</td><td>{{ $record->nilai_penataan }}</td><td>{{ $record->nilai_lantai + $record->nilai_sampah + $record->nilai_rak + $record->nilai_penataan }}</td><td>{{ $record->keterangan ?? '-' }}</td></tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
