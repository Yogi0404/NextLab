<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; font-size: 12px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

<h2>Laporan Peminjaman</h2>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjamans as $item)
        <tr>
            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
            <td>{{ $item->user->name }}</td>
            <td>
                @if(in_array($item->status, ['request_kembali','dikembalikan']))
                    Pengembalian
                @else
                    Peminjaman
                @endif
            </td>
            <td>{{ $item->alat->nama_alat }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>