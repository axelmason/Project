@extends('layouts.app')

@section('title', 'Автомобиль ' . $car->name)

@section('content')
    <div class="container fs-5">
        <h2 class="text-center my-5">Информация об автомобиле {{ $car->name }}</h2>
        <p>{{ $car->name }}</p>
        <p>Количество свободных мест:
            {{ App\Services\CarService::free_seats($car) }} из {{ $car->seats->count() }}
        </p>
        <p class="d-flex">Дата и время поездки:
            {{ \Carbon\Carbon::parse($car->booking_date)->format('d.m.Y') }}
            {{ \Carbon\Carbon::parse($car->booking_time)->format('H:i') }}
        </p>
        <form class="booking-form" data-car-id="{{ $car->id }}" method="POST">
            <div class="d-flex">
                @foreach ($car->seats as $seat)
                    <input type="checkbox" name="seat_number-{{ $seat->seat_number }}"
                        id="seat_number-{{ $seat->seat_number }}" class="btn-check" autocomplete="off"
                        @if ($seat->user_id !== null) disabled @endif data-id="{{ $seat->seat_number }}">
                    <label for="seat_number-{{ $seat->seat_number }}"
                        class="btn @if(auth()->user()->id == $seat->user_id) btn-success @else btn-outline-dark @endif me-2 fs-5">{{ $seat->seat_number }}</label>
                @endforeach
            </div>
            <button type="submit" class="booking-btn btn btn-outline-success my-2"
                style="display: none">Забронировать</button>
        </form>
    </div>
@endsection

@section('customJS')
    <script>
        $(document).ready(function() {
            var check = 0;
            $('input[type=checkbox]').on('change', function() {
                if ($(this).is(':checked')) {
                    check += 1;
                } else if (!$(this).is(':checked')) {
                    check -= 1;
                }
                if (check > 0) {
                    $('.booking-btn').show();
                } else {
                    $('.booking-btn').hide();
                }
                return false;
            });

            $('.booking-form').on('submit', function() {
                var car_id = $(this).data('car-id');
                console.log(car_id);
                var checked = [];
                $.each($('input[type=checkbox]'), function (indexInArray, valueOfElement) {
                    if($(valueOfElement).is(':checked')) {
                        checked.push($(this).data('id'));
                    }
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('booking') }}",
                    data: {
                        'checked': checked,
                        'car_id': car_id
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            })
        });
    </script>
@endsection
