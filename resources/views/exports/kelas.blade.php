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
<h3>Data Kelas</h3>
<table>
    <thead><tr><th>Nama Kelas</th><th>Wali Kelas</th></tr></thead>
    <tbody>
        @foreach($kelas as $item)
            <tr><td>{{ $item->nama_kelas }}</td><td>{{ $item->wali_kelas ?? '-' }}</td></tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
