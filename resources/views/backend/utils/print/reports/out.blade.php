<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
{{-- <title>Arpan Electric Sales Invoice {{$sales->invoice_number}}</title> --}}
</head>
<body>
<div class="container">
    <table>
        <tr>
            <td>
                <img src="{{ asset('images/logo.png') }}" alt="logo" width="100px" height="100px">
            </td>
            <td>
                <h1>Arpan Electric</h1>
                <p>
                    <strong>Address:</strong>
                    <br>
                    <strong>Phone:</strong>
                    <br>
                    <strong>Email:</strong>
                </p>
            </td>
        </tr>
    </table>
    <hr>
    <h2>Sales Report</h2>

    <table>
        <tr>
            <td>
                <strong>Invoice Number:</strong>
                <br>
                <strong>Invoice Date:</strong>
                <br>
                <strong>Customer Name:</strong>
                <br>
                <strong>Customer Address:</strong>
                <br>
                <strong>Customer Phone:</strong>
                <br>
                <strong>Customer Email:</strong>
            </td>
            <td>
                {{-- {{$sales->invoice_number}}
                <br>
                {{$sales->invoice_date}}
                <br>
                {{$sales->customer->name}}
                <br>
                {{$sales->customer->address}}
                <br>
                {{$sales->customer->phone}}
                <br>
                {{$sales->customer->email}} --}}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>Tanggal</td>
            <td>Faktur</td>
            <td>Pelanggan</td>
            <td>Nama Barang</td>
            <td>Harga</td>
            <td>Jumlah</td>
            <td>Total</td>
        </tr>

        @foreach ($sales as $sale)
            @foreach ($sale->details as $detail)
                <tr>
                    <td>{{$sale->created_at}}</td>
                    <td>{{$sale->invoice_number}}</td>
                    <td>{{$sale->customer->name}}</td>
                    <td>{{$detail->product->name}}</td>
                    <td>{{$detail->unit_price}}</td>
                    <td>{{$detail->quantity}}</td>
                    <td>{{$detail->total}}</td>
                </tr>
            @endforeach
        @endforeach
    </table>

</div>
</body>
</html>
