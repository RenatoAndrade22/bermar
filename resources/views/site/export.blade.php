@extends('layouts.layout')

@section('content')
    <div id="loading">
        <img src="https://media.tenor.com/On7kvXhzml4AAAAi/loading-gif.gif" alt="">
    </div>
  
    <section class="mb-5">
        <div class="row" id="list-representatives">
            <ul>
                @foreach($enterprises as $enterprise)
                    <li>
                        <h5>{{ $enterprise->name}},</h5>

                        <p>Endereço<br>{{ $enterprise['address'][0]['street']}}, {{ $enterprise['address'][0]['number']}}, {{ $enterprise['address'][0]['district']}}, {{ $enterprise['address'][0]['complement']}}, {{ $enterprise['address'][0]['city']}} - {{ $enterprise['address'][0]['state']}}
                        <br>(17) 98122-5539</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection


