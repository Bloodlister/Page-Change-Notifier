<link href="./css/mailing.css" rel="stylesheet" data-inline>
<table class="car-collection">
    @foreach($newCars as $newCar)
    <tr class="car">
        <td class="image">
            <a href="{{ $newCar->link }}">
                    <div class="car-image" style="background-image: url('{{ $newCar->image }}')"></div>
                </a>
            </td>
            <td class="desc">
                <div class="car-title">
                    <a href="{{ $newCar->link }}">{{ $newCar->title }}</a>
                </div>
                <div class="car-desc">
                    {{ $newCar->desc }}
                </div>
                <div class="car-price">
                    {{ mb_convert_encoding($newCar->price, 'UTF-8') }}
                </div>
            </td>
        </tr>
    @endforeach
</table>