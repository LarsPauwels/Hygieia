<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ ucfirst($client->name) }} | {{ date("d/m/Y") }}</title>

    <style type="text/css">
        @page {
            margin: 150px 10px;
            margin-bottom: 20px;
        }

        @font-face {
            font-family: 'Montserrat-Regular';
            src: url({{ storage_path('fonts\Montserrat-Regular.ttf') }}) format("truetype");
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: 'Montserrat-Light';
            src: url({{ storage_path('fonts\Montserrat-Light.ttf') }}) format("truetype");
            font-weight: 300;
            font-style: normal;
        }

        body {
            margin: 0;
        }

        * {
            font-family: Montserrat-Regular, Arial, sans-serif;
        }

        table {
            margin: 0;
            font-size: x-small;
        }

        header { 
            position: fixed; 
            top: -125px; 
            left: 0; 
            right: 0;
        }

        footer { 
            position: fixed; 
            bottom: 15px; 
            left: 0; 
            right: 0;
            margin: 0 35px;
        }

        .header {
            margin-bottom: 0;
        }

        .header__name {
            margin: 0;
            text-transform: capitalize;
            margin-left: 35px;
            font-family: Montserrat-Light, Arial, sans-serif;
            font-weight: 300;
            font-size: 30px;
            color: #3f9ae5;
        }

        .line {
            border: none;
            border-top: 1px solid grey;
            margin: 0;
            margin-top: 7px;
        }

        .line--list {
            border-top: 2px solid black;
        }

        .header__logo {
            max-height: 60px;
            max-width: 80px;
        }

        .information {
            margin: 0;
            margin-left: 35px;
            margin-top: -65px;
        }

        .information__text {
            color: grey;
        }

        .information__text--underline {
            text-decoration: underline;
        }

        .list__title {
            margin: 0;
            margin-left: 35px;
            font-size: 20px;
            text-transform: capitalize;
        }

        .list__table {
            margin: 0 35px;
            margin-top: 15px;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .list__table__titles {
            border-bottom: 1px solid grey;
            border-collapse: collapse;
        }

        .list__table__title {
            color: grey;
        }

        .list__table tbody tr:nth-child(odd) {
            background: #f5f5f5;
        }

        .list__table tbody td {
            padding: 7px 0;
            color: grey;
            border-collapse: collapse;
            border: 1px solid lightgrey;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<header class="header">
    <table width="100%">
        <tr>
            <td align="left">
                <h1 class="header__name">{{ $client->name }}</h1>
                <hr class="line">
            </td>
            <td align="left" style="width: 80px;">
                @if($client->logo_path)
                    <img src="{{ public_path($client->logo_path) }}" alt="Logo" class="header__logo"/>
                @endif
            </td>
        </tr>
    </table>
</header>

<footer>
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} {{ config('app.url') }} - All rights reserved.
            </td>
            <td align="right" style="width: 50%;">
                Hygieia
            </td>
        </tr>
    </table>
</footer>

<div class="information">
    <table width="100%">
        <tr>
            <td align="left">
                <p class="information__text">Datum: <span class="information__text--underline">{{ date("d/m/Y") }}</span></p>
            </td>
            <td align="left">
                <p class="information__text">Adres: <span class="information__text--underline">{{ $client->address }}</span></p>
            </td>
        </tr>
    </table>
</div>

<br/>

<div class="list">
    @php($len = count($data))
    @php($i = 0)
    @foreach($data as $space)
        <table>
            <tr>
                <td align="left">
                    <h3 class="list__title">{{ $space->name }}</h3>
                    <hr class="line line--list" width="100%">
                </td>
            </tr>
        </table>
        <table width="100%" class="list__table">
            <thead class="list__table__titles">
            <tr>
                <th class="list__table__title">Voorwerp</th>
                <th class="list__table__title">Producten</th>
                <th class="list__table__title">Dosering</th>
                <th class="list__table__title">Poetsmethode</th>
                <th class="list__table__title">Frequentie</th>
            </tr>
            </thead>
            <tbody>
                @foreach($space->items as $item)
                    @php($begin = true)
                    @php($cnt = $item->products->count())
                    @if($item->products->count() > 0)
                        @php($last =end($item->products))
                        @foreach($item->products as $product)
                            <tr>
                                @if($begin)
                                    <td style="text-align: center;{{ $cnt > 1 ? "border-bottom: 0px;" : "" }}">
                                        <br/>
                                        @if($item->icon)
                                            <img src="{{ public_path($item->icon->image_url) }}" style="max-width: 80px; max-height: 80px;"><br/>
                                        @endif
                                        {{ $item->name }}
                                        <br/>
                                    </td>
                                @else
                                    <td style="{{ ($cnt > 1 ? "border-top: 0px;" : "").($product == $last ? "" : "border-bottom: 0px;") }}">&nbsp;</td>
                                @endif
                                <td style="text-align: center;">
                                    <br/>
                                    @if($product->icon)
                                        <img src="{{ public_path($product->icon->image_url) }}" style="max-width: 80px; max-height: 80px;"><br/>
                                    @endif
                                    {{ $product->name }}
                                    <br/>
                                </td>
                                <td>
                                    {{ $product->quantity ?? " " }}
                                </td>
                                @if($begin)
                                    <td rowspan="{{ $cnt }}">{{ $item->procedure->description ?? " " }}</td>
                                    <td rowspan="{{ $cnt }}">{{ $item->frequency->name ?? "&nbsp;" }}</td>
                                @endif
                            </tr>
                            @php($begin = false)
                        @endforeach
                    @else
                        <tr>
                            <td style="text-align: center;">
                                <br/>
                                @if($item->icon)
                                    <img src="{{ public_path($item->icon->image_url) }}" style="max-width: 80px; max-height: 80px;"><br/>
                                @endif
                                {{ $item->name }}
                                <br/>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>{{ $item->procedure->description ?? " " }}</td>
                            <td>{{ $item->frequency->name ?? " " }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        @if($i != $len - 1)
            <div class="page-break"></div>
        @endif
        @php($i++)
    @endforeach
</div>

</body>
</html>
