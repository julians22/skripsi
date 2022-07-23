<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Arpan Electric Product Price List</title>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
@include('backend.utils.print.includes.font_face')

@php
    $body_width = '100%';
    if ($paper_size == 'A4') {
        $body_width = '100%';
    } else if ($paper_size == 'A5') {
        $body_width = '148mm';
    } else if ($paper_size == 'A3') {
        $body_width = '297mm';
    } else if ($paper_size == 'A2') {
        $body_width = '420mm';
    } else if ($paper_size == 'A1') {
        $body_width = '594mm';
    } else if ($paper_size == 'A0') {
        $body_width = '841mm';
    }
@endphp

<style>
*{
    font-family: 'Source Sans Pro', sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

h1, h2, h3, h4, h5, h6, p{
    margin: 0;
}

body{
	width: 100%;
    font-weight: 300;
    padding: 0;
    margin: 0;
}

table{
    border-collapse: collapse;
    width: 100%;
}

table.logo{
    width: 100%;
    margin-bottom: 10px;
}

table.wrapper{
    width: 100%;
    margin: 0 auto;
    max-width: {{ $body_width }};
}

table.product-list{
    border-collapse: collapse;
    width: 100%;
    margin: 0 auto;
    border-width: 1px;
    border-color: #eee;
    font-size: 12px;
    font-weight: 400;
}

table.product-list td{
    border-width: 1px;
    padding: 10px;
    border-style: solid;
    border-color: rgb(85, 85, 85);
}

table.product-list tr.head{
    border-color: rgb(85, 85, 85);
    background-color: #000;
    color: #fff;
    font-weight:900;
}

table.product-list tr.category{
    background-color: rgb(85, 85, 85);
    color: #fff;
    font-weight:900;
}

table.product-list tr.product-row{
    page-break-inside: avoid !important;
}

tr.page-break{
    page-break-after: always;
}

tr.page-break td{
    padding: 0;
}

.heading{
    text-decoration: underline;
}



</style>

</head>

<body>
<table class="wrapper">
<tr>
<td>
    <table class="logo">
        <tr>
            <td align="center">
                <img src="{{ asset(setting('invoice_logo', 'img/brand/logo.jpeg')) }}" alt="" style="width: 100%; max-width: 120px">
            </td>
        </tr>
        <tr>
            <td align="center">
                <h2 class="heading">DAFTAR HARGA BARANG {{ date('Y-m-d') }}</h2>
            </td>
        </tr>
    </table>
    <table class="product-list">
        <tr class="head">
            <td>Nama Barang</td>
            <td>Kode Barang</td>
            <td>Harga</td>
        </tr>
        @php
            $i = 1;
            $breakOn = 19;
            $pageOn = 1;
        @endphp
        @foreach ($data as $product)
            @if ($product['show'])
                <tr class="category">
                    <td colspan="3" align="center">{{ $product['category'] }}</td>
                </tr>
                @foreach ($product['products'] as $product)
                    <tr class="product-row">
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['code'] }}</td>
                        <td>{{ rupiah($product['price']) }}</td>
                    </tr>
                    @if ($i % $breakOn == 0 && $pageOn == 1)
                        @php
                            $pageOn++;
                            $breakOn = 25;
                            $i = 0;
                        @endphp
                    @endif
                    @if ($i % $breakOn == 0 && $pageOn > 1)
                        <tr class="page-break">
                            <td colspan="3"></td>
                        </tr>
                        @php
                            $pageOn++;
                            $i = 0;
                        @endphp
                    @endif
                    @php
                        $i++;
                    @endphp
                @endforeach
                @if ($i % $breakOn == 0 && $pageOn > 1)
                    <tr class="page-break">
                        <td colspan="3"></td>
                    </tr>
                    @php
                        $pageOn++;
                        $i = 0;
                    @endphp
                @endif
                @php
                    $i++;
                @endphp
            @endif
        @endforeach
    </table>
</td>
</tr>
</table>
</body>
</html>
