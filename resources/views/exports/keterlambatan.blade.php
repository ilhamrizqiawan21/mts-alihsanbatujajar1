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
<h3>Data Keterlambatan</h3>
<table>
    <thead><tr><th>Siswa</th><th>Kelas</th><th>Tanggal</th><th>Jam Datang</th><th>Alasan</th><th>Keterangan</th></tr></thead>
    <tbody>
        @foreach($records as $record)
            <tr><td>{{ $record->siswa?->nama ?? '-' }}</td><td>{{ $record->siswa?->kelas?->nama_kelas ?? '-' }}</td><td>{{ $record->tanggal?->format('Y-m-d') ?? '-' }}</td><td>{{ $record->jam_datang }}</td><td>{{ $record->alasan ?? '-' }}</td><td>{{ $record->keterangan ?? '-' }}</td></tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
