<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Invoice Transaction Custom</title>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        /* .invoice-box table tr td:nth-child(2) {
            text-align: right;
        } */

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="5">
                    <table>
                        <tr>
                            <td class="title">
                                <!-- Gambar -->
                                <img src="#" style="width: 100%; max-width: 300px" />
                            </td>
                            <td style="text-align:right;">
                                Invoice #: INV/CUS/{{ $custom[0]->umkms_id }}/{{ $custom[0]->date }}/{{
                                $custom[0]->id_custom }}<br>
                                Order In: {{ $custom[0]->date }}<br>
                                Due:
                                {{
                                $date = Carbon\Carbon::parse($custom[0]->date)->addDays(2)->toDateString()
                                }}<br>
                                Last Updated: {{ $custom[0]->updated_at }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="5">
                    <table>
                        <tr>
                            <!-- Data Pelanggan -->
                            <td style="text-transform:uppercase;">
                                <strong>Informasi Penerima:</strong><br>
                                {{ $custom[0]->first_name }}&nbsp;{{ $custom[0]->last_name }}<br>
                                {{ $custom[0]->address }},{{ $custom[0]->districts }},{{ $custom[0]->ward }}<br>
                                {{ $custom[0]->city }},{{ $custom[0]->province }}<br>
                                Kode Pos :&nbsp;{{ $custom[0]->postal_code }}
                            </td>
                            <!-- Data Perusahaan -->
                            <td style="text-align:right;text-transform:uppercase;">
                                <strong>Informasi Penjual:</strong><br>
                                {{ $custom[0]->umkm_name }}<br>
                                {{ $custom[0]->no_umkm }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td colspan="3">Jenis Order</td>
                <td style="text-align:right;">Nominal Pembayaran</td>
                <td style="text-align:right;">Status Pembayaran</td>
            </tr>
            <tr class="details">
                <td colspan="3">Custom</td>
                <td style="text-align:right;">Rp. {{number_format($custom[0]->total,2,',','.')}}</td>
                <td style="text-align:right;">Lunas</td>
            </tr>
            <tr class="heading">
                <td colspan="3">Jenis Pengiriman</td>
                <td style="text-align:right;">Nomor Pengiriman</td>
                <td style="text-align:right;">Tanggal Pengiriman</td>
            </tr>
            <tr class="details">
                <td colspan="3" style="text-transform:uppercase;">{{ $custom[0]->shipping }}</td>
                <td style="text-align:right;">{{ $custom[0]->no_resi = Str::limit($custom[0]->no_resi, 15) }}</td>
                <td style="text-align:right;">{{ $custom[0]->tgl_pengiriman }}</td>
            </tr>
            <!-- End Baris Atas -->
            <tr class="heading">
                <td colspan="2">Nama Item</td>
                <td style="text-align:right;">Qty</td>
                <td style="text-align:right;">Price</td>
                <td style="text-align:right;">Subtotal</td>
            </tr>
            <!-- Data Produk -->
            <tr class="item">
                <td colspan="2">Customize</td>
                <td style="text-align:right;">{{ $custom[0]->qty }}</td>
                <td style="text-align:right;"></td>
                <td style="text-align:right;">Rp. {{number_format($custom[0]->subtotal,2,',','.')}}</td>
            </tr>
            <tr class="item">
                <td colspan="2">Promo</td>
                <td style="text-align:right;"></td>
                <td style="text-align:right;">Rp. 0,00</td>
                <td style="text-align:right;">Rp. 0,00</td>
            </tr>
            <tr class="item">
                <td colspan="2">Ongkir</td>
                <td style="text-align:right;"></td>
                <td style="text-align:right;">Rp. {{number_format($custom[0]->ongkir,2,',','.')}}</td>
                <td style="text-align:right;">Rp. {{number_format($custom[0]->ongkir,2,',','.')}}</td>
            </tr>
            <!-- Total Subtotal -->
            <tr class="total">
                <td style="text-align:right;" colspan="5">Total: Rp. {{number_format($custom[0]->total,2,',','.')}}</td>
            </tr>
        </table>
        <div class="col-md-12">
            <p><strong>Deskripsi Order:</strong>&nbsp;<br>
                {{ $custom[0]->keterangan }}
            </p>
            <p><strong>Deskripsi Alamat:</strong>&nbsp;<br>
                {{ $custom[0]->desc }}
            </p>
        </div>
    </div>
</body>

</html>
<p class="footer-text m-0">
    Copyright 2022
    @All rights reserved | This template is made with :D
</p>