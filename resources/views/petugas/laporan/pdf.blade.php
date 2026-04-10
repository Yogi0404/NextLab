<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px;}
        th, td { border: 1px solid #000; padding: 6px; text-align: left;}
    </style>
</head>
<body>

    <h2>Laporan Peminjaman - NEXTLAB</h2>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alat</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $item)
            <tr>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->alat->nama_alat }}</td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>