<html>

<head>
    <title>Laporan Transaksi Pembelian, {{ $nama_umkm[0]->umkm_name }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style type="text/css">
    .body {
        margin-left: 10px;
        margin-right: 10px;
    }

    .table .tr .td,
    .table .tr .th {
        font-size: 8pt;
    }

    .thead {
        background-color: grey;
    }
</style>

<body>
    <center>
        <h4>Laporan Transaksi Pembelian {{ $nama_umkm[0]->umkm_name }}</h4>
        @if($awal != null || $akhir != null)
        <h4>Periode "{{ $awal }}-{{ $akhir }}"</h4>
        @else
        <h4>Seluruh Periode</h4>
        @endif
        <br>
    </center>
    <div class="col-md-12">
        <div class="col-md-6" style="margin-left:-13px;">
            <label for="">
                @if($awal != null || $akhir != null)
                Periode : <b>{{ $awal }}-{{ $akhir }}</b>
                @else
                Periode : <b>Sampai&nbsp;{{ Carbon\Carbon::now(); }}</b>
                @endif
            </label><br>
            <label for="">
                Dieksport "{{ Carbon\Carbon::now(); }}"
            </label>
        </div>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th style="text-transform:uppercase;">Tanggal Transaksi</th>
                    <th style="text-transform:uppercase;">Tanggal Selesai</th>
                    <th style="text-transform:uppercase;">Harga</th>
                    <th style="text-transform:uppercase;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($page as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->updated_at }}</td>
                    <td>Rp. {{number_format($item->total,2,',','.')}}</td>
                    <td>Rp. {{number_format($item->total,2,',','.')}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Data Kosong</td>
                </tr>
                @endforelse
                <tr>
                    <td colspan="3">Total :</td>
                    <td>Rp. {{number_format($total,2,',','.')}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <p>Jumlah Transaksi Berhasil : <strong>{{ $jumlah }}</strong> Transaksi</p>
        <p>Jumlah Estimasi Pemasukkan : <strong>Rp. {{number_format($total,2,',','.')}}</strong></p>
    </div>
</body>

</html>
<footer style="margin-left:13px;">
    Copyright 2022
    @All rights reserved | This template is made with :D
</footer>