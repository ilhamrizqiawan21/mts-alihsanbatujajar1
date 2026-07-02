@extends('layouts.app')

@section('title', 'Edit Kebersihan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Edit Data Kebersihan</h3>
                <form method="POST" action="{{ route('kebersihan.update', $kebersihan) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-select">
                            @foreach($kelas as $item)
                                <option value="{{ $item->id }}" {{ $kebersihan->kelas_id == $item->id ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $kebersihan->tanggal?->format('Y-m-d') }}">
                    </div>
                    <div class="row g-3">
                        @foreach(['nilai_lantai' => 'Lantai', 'nilai_sampah' => 'Sampah', 'nilai_rak' => 'Rak', 'nilai_penataan' => 'Penataan'] as $field => $label)
                            <div class="col-md-6">
                                <label class="form-label">{{ $label }}</label>
                                <select name="{{ $field }}" class="form-select">
                                    @for($i=0; $i<=5; $i++)
                                        <option value="{{ $i }}" {{ $kebersihan->$field == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ $kebersihan->keterangan }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('kebersihan.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
