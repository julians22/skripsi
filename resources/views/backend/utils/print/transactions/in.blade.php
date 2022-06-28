<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Arpan Electric Purchase Invoice {{$purchase->invoice_number}}</title>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">

@include('backend.utils.print.includes.font_face')

<style type="text/css">
*{
    font-family: 'Source Sans Pro', sans-serif;
    font-weight: 400;
}
body{
	width: 100%;
    font-size: 14px;
    font-weight: 300;
}
.head-table, .head-table * {
	font-size: 10px;
	font-weight: 700;
}
.table-transaction {
    margin-top: 20px;
    border-width: 1px;
    border-color: #eee;
    border-collapse: collapse;
}
.table-transaction th, .table-transaction td {
    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #eee;
}

.table-transaction tbody .heading {
	background-color: #eee;
}
table {
	border-collapse: collapse;
}
.table-transaction tbody .footer.odd {
	background-color: #eee;
}
.table-transaction tbody .footer.even {
	background-color: #fff;
}
.table-transaction tbody .footer-grand {
	font-size: 14px;
	background-color: black;
    color: white;
	font-weight: 700;
}

.invoice-badge{
    background-color: #eee;
    color: #000;
    padding: 5px;
    border-radius: 5px;
}
</style>
</head>
<body>
	<table width="100%" border="0" cellpadding="5" class="head-table">
      <tbody>
        <tr>
          <td>
            <img src="{{ asset('img/brand/logo.jpeg') }}" style="width: 100%; max-width: 180px" />
          </td>
          <td width="50%">
          	<table border="0" cellpadding="5" class="head-information">
              <tbody>
                <tr>
                  <th align="left">No. Faktur</th>
                  <td>: <span class="invoice-badge">{{ $purchase->invoice_number }}</span></td>
                </tr>
                <tr>
                  <th align="left">Tanggal Transaksi</th>
                  <td>: @displayDate($purchase->created_at, 'Y/m/d')</td>
                </tr>
                <tr>
                    <th align="left">Nama Pelanggan</th>
                    <td>: Tn/Ny {{ $purchase->supplier->name }}</td>
                </tr>
                <tr>
                    <th align="left">No. HP.</th>
                    <td>: {{ $purchase->supplier->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th align="left">Email</th>
                    <td>: {{ $purchase->supplier->email ?? '-' }}</td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>

    <table width="100%" class="table-transaction">
      <tbody>
        <tr class="heading">
          <th width="51%" scope="col">Item</th>
          <th width="11%" scope="col">Jml</th>
          <th width="19%" scope="col">Harga</th>
          <th width="19%" scope="col" align="center">Total</th>
        </tr>
        @foreach ($purchase->details as $detail)
            <tr class="item">
                <td>{{ $detail->product->name }}</td>
                <td style="text-align: center">{{ $detail->quantity }}</td>
                <td>{{ rupiah($detail->price) }}</td>
                <td align="left">{{ rupiah($detail->total) }}</td>
            </tr>
        @endforeach
        <tr class="footer odd">
        	<th colspan="3" align="right">
            	Subtotal
            </th>
            <td align="left">
                {{ rupiah($purchase->total) }}
            </td>
        </tr>
        @if ($purchase->transaction->hasPayment())
        @php
            $payment = $purchase->transaction->payment;
        @endphp
        <tr>
            <th>
                Pembayaran
            </th>
            <th colspan="2" align="right">
                @displayDate($payment->created_at, 'Y/m/d')
            </th>
            <td align="left">
                {{ rupiah($payment->amount) }}
            </td>
        </tr>
        @else
            <tr>
                <th>
                    Pembayaran
                </th>
                <th colspan="2" align="right">
                    -
                </th>
                <td align="left">
                    -
                </td>
            </tr>
        @endif
      </tbody>
    </table>
</body>
</html>
