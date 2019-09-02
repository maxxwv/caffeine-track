@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

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
