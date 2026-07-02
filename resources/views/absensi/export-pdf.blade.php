<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 4px; text-align: center; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 8px; }
        .subtitle { margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="title">Rekap Absensi</div>
    <div class="subtitle">{{ $monthLabel }} · {{ $activeYear?->tahun ?? '-' }}</div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Siswa</th>
                @for($day = 1; $day <= $daysInMonth; $day++)
                    <th>{{ $day }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $index => $siswa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $siswa->nama }}</td>
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $date = \Illuminate\Support\Carbon::create($selectedYear, $selectedMonth, $day)->toDateString();
                            $record = $attendanceMap[$siswa->id][$date] ?? null;
                        @endphp
                        <td>{{ $record->status ?? '-' }}</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
