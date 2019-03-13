<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<link href="{{ $cssPath . "/css/mailing.css" }}" rel="stylesheet" data-inline>
<table class="car-collection">
  <h2>{{ $title }}</h2>
    @foreach($newCars as $newCar)
        <tr class="car">
            <td class="image">
                <a href="{!! $newCar->link !!}">
                    <div class="car-image" style="background-image: url('{!! $newCar->image !!}')"></div>
                </a>
            </td>
            <td class="desc">
                <div class="car-title">
                    <a href="{!! $newCar->link !!}">{!! $newCar->title !!}</a>
                </div>
                <div class="car-desc">
                    {!! $newCar->desc !!}
                </div>
                <div class="car-price">
                    {!! $newCar->price !!}
                </div>
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>
