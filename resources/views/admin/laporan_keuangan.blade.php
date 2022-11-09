<html>

<head>
    <title>Laporan Keuangan, {{ $nama_umkm[0]->umkm_name }}</title>
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
        <h4>Laporan Keuangan {{ $nama_umkm[0]->umkm_name }}</h4>
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
        <!-- Tabel Penjualan -->
        <label for="">Tabel Penjualan (Tanpa Ongkir)</label>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th style="text-transform:uppercase;">Tanggal Transaksi</th>
                    <th style="text-transform:uppercase;">Tanggal Selesai</th>
                    <th style="text-transform:uppercase;">Potongan</th>
                    <th style="text-transform:uppercase;">Ongkir</th>
                    <th style="text-transform:uppercase;">Harga</th>
                    <th style="text-transform:uppercase;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($page as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->updated_at }}</td>
                    <td>Rp. {{number_format($item->potongan,2,',','.')}}</td>
                    <td>Rp. {{number_format($item->ongkir,2,',','.')}}</td>
                    <td>Rp. {{number_format($item->total-$item->ongkir+$item->potongan,2,',','.')}}</td>
                    <td>Rp. {{number_format($item->total,2,',','.')}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Data Kosong</td>
                </tr>
                @endforelse
                <tr>
                    <td colspan="5">Total :</td>
                    <td>Rp. {{number_format($totalder,2,',','.')}}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <!-- Tabel Custom -->
        <label for="">Tabel Pemesanan Custom (Tanpa Ongkir)</label>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th style="text-transform:uppercase;">Tanggal Transaksi</th>
                    <th style="text-transform:uppercase;">Tanggal Selesai</th>
                    <th style="text-transform:uppercase;">Jumlah Order</th>
                    <th style="text-transform:uppercase;">Ongkir</th>
                    <th style="text-transform:uppercase;">Harga</th>
                    <th style="text-transform:uppercase;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($custom as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->updated_at }}</td>
                    <td>{{ $item->qty }} Pcs</td>
                    <td>Rp. {{number_format($item->ongkir,2,',','.')}}</td>
                    <td>Rp. {{number_format($item->subtotal,2,',','.')}}</td>
                    <td>Rp. {{number_format($item->total,2,',','.')}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Data Kosong</td>
                </tr>
                @endforelse
                <tr>
                    <td colspan="5">Total :</td>
                    <td>Rp. {{number_format($totalcus,2,',','.')}}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <!-- Tabel Pembelian -->
        <label for="">Tabel Pembelian Material</label>
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
                @forelse($pembelian as $items)
                <tr>
                    <td>{{ $items->date }}</td>
                    <td>{{ $items->updated_at }}</td>
                    <td>Rp. {{number_format($items->total,2,',','.')}}</td>
                    <td>Rp. {{number_format($items->total,2,',','.')}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Data Kosong</td>
                </tr>
                @endforelse
                <tr>
                    <td colspan="3">Total :</td>
                    <td>Rp. {{number_format($totalpem,2,',','.')}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <p>Rincian :</p>
        <p>Jumlah Transaksi Penjualan : <strong>{{ $jumlahder }}</strong> Transaksi</p>
        <p>Jumlah Transaksi Pemesanan Custom : <strong>{{ $jumlahcus }}</strong> Transaksi</p>
        <p>Jumlah Transaksi Pembelian : <strong>{{ $jumlahpem }}</strong> Transaksi</p>
        <p>Jumlah Estimasi Pemasukkan Bersih: <strong>Rp.
                {{number_format($totalder+$totalcus-$totalpem,2,',','.')}}</strong></p>
        <p>Jumlah Estimasi Pemasukkan : <strong>Rp. {{number_format($totalder+$totalcus,2,',','.')}}</strong></p>
        <p>Jumlah Estimasi Pengeluaran : <strong>Rp. {{number_format($totalpem,2,',','.')}}</strong></p>
    </div>
</body>

</html>
<footer style="margin-left:13px;">
    Copyright 2022
    @All rights reserved | This template is made with :D
</footer>