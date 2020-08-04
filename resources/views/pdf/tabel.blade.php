@php
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $months = ["januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus",
        "september", "oktober", "november", "december"];
    $smonth = $months[$month - 1];

    if(!function_exists('isWeekend')) {
        function isWeekend($day, $month, $year) {
            return (date('N', strtotime("$day-$month-$year")) >= 6);
        }
    }

    $date = "$smonth $year";

    $count = 0;
    $total = count($data);
@endphp

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ ucfirst($client->name) }} | {{ $date }}</title>

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
            white-space: nowrap;
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
        }

        .page-break {
            page-break-after: always;
        }

        th {
            border-left: 1px solid white;
            border-right: 1px solid white;
            border-collapse: collapse;
            color: grey;
        }

        th.weekend, td.weekend {
            background-color: #3f9ae5;
        }

        .border__day {
            border-collapse: collapse;
            border: 1px solid lightgrey;
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
                <p class="information__text">Datum: <span class="information__text--underline">{{ $date }}</span></p>
            </td>
            <td align="left">
                <p class="information__text">Datum opmaak: <span class="information__text--underline">{{ date("d/m/Y") }}</span></p>
            </td>
            <td align="left">
                <p class="information__text">Adres: <span class="information__text--underline">{{ $client->address }}</span></p>
            </td>
        </tr>
    </table>
</div>

<br/>

<div class="list">
    @foreach($data as $space)
        @php
            $count += 1;
        @endphp
        <table>
            <tr>
                <td align="left">
                    <h3 class="list__title">{{ $space->name }} ({{ $date }})</h3>
                    <hr class="line line--list" width="100%">
                </td>
            </tr>
        </table>
        <table width="100%" class="list__table">
            <thead class="list__table__titles">
            <tr>
                <th>Voorwerp</th>
                <th class="border">Frequentie</th>
                @for($i = 1; $i <= $days; ++$i)
                    @php
                        if($i < 10) {
                            $i = '0'.$i;
                        }
                    @endphp

                    @if(isWeekend($i, $month, $year))
                        <th class="border day weekend">{{$i}}</th>
                    @else
                        <th class="border day">{{$i}}</th>
                    @endif
                @endfor
            </tr>
            </thead>
            <tbody>
                @foreach($space->items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->frequency->name }}</td>
                        @for($i = 1; $i <= $days; ++$i)
                            <td @if(isWeekend($i, $month, $year))
                                    class="weekend border__day"
                                @else
                                    class="border__day"
                                @endif>&nbsp;</td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($count != $total)
            <div class="page-break"></div>
        @endif
    @endforeach
</div>

</body>
</html>