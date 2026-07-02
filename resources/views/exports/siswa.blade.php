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
<h3>Data Siswa</h3>
<table>
    <thead>
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>No HP Orang Tua</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswas as $siswa)
            <tr>
                <td>{{ $siswa->nis }}</td>
                <td>{{ $siswa->nama }}</td>
                <td>{{ $siswa->kelas?->nama_kelas ?? '-' }}</td>
                <td>{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td>
                <td>{{ $siswa->tempat_lahir ?? '-' }}</td>
                <td>{{ $siswa->tanggal_lahir?->format('Y-m-d') ?? '-' }}</td>
                <td>{{ $siswa->alamat ?? '-' }}</td>
                <td>{{ $siswa->no_hp_ortu ?? '-' }}</td>
                <td>{{ $siswa->status ? 'Aktif' : 'Nonaktif' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
