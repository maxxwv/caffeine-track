@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add a Drink</div>
                <div class="card-body">
                    {{ Form::open(['route' => 'imbibe']) }}
                    <fieldset>
                        {{ Form::token() }}
                        {{ Form::label('drink_id', 'Select a drink: ') }}
                        {{ Form::select('drink_id', $select) }}
                        @error('drink_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>
                    <fieldset>
                        {{ Form::label('servings', 'Number of Servings: ') }}
                        {{ Form::text('servings') }}
                        @error('servings')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>
                    <fieldset>
                        {{ Form::submit('Log it!') }}
                    </fieldset>
                    {{ Form::close() }}
                </div>
            </div>

            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Drink</th>
                                <th scope="col">Amount Left</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($overview as $item)
                            <tr>
                                <th scope="row">{{ $item['name'] }}</th>
                                <td class="amount-left{{ $item['class_name'] }}" data-drink_id="{{ $item['drink_id'] }}">{{ $item['left'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Diary</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table border="1">
                        <thead>
                            <tr>
                                <th scope="col">Drink</th>
                                <th scope="col">Caffeine Content</th>
                                <th scope="col">Servings</th>
                                <th scope="col">When</th>
                                <th scope="col">Total Caffeine</th>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach($diary as $drink)
                            <tr>
                                <th scope="row" class="drink">{{ $drink->name }}
                                <div class="tooltip">{{ $drink->descr }}</div></th>
                                <td class="caffeine">{{ $drink->caffeine }}</td>
                                <td class="servings">{{ $drink->servings_had }}</td>
                                <td class="when">{{ date('g:i a', strtotime($drink->date_ingested)) }}</td>
                                <td class="total">{{ $drink->servings_had * $drink->caffeine }}</td>
                            </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
