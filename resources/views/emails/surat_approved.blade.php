<!DOCTYPE html>
<html>
<head>
    <title>Surat Disetujui / Ditolak</title>
</head>
<body>
    <h1>Halo {{ $surat->mahasiswa->nama }}</h1>
    <p>
        Surat <strong>{{ $surat->jenis }}</strong>
        telah 
        @if ($surat->status === 'approved')
            <strong>disetujui</strong>.
        @elseif ($surat->status === 'rejected')
            <strong>ditolak</strong>.
        @else
            <strong>dalam proses</strong>.
        @endif
    </p>
</body>
</html>
