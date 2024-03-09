<!-- resources/views/cars/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>Car Details</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $car->title }}</h5>
                    <p class="card-text">Price: {{ $car->price }}</p>
                    <p class="card-text">Video URL: {{ $car->video }}</p>
                    <p class="card-text">Specifications:</p>
                    <ul>
                        @foreach ($car->specifications as $specification)
                            <li>{{ $specification }}</li>
                        @endforeach
                    </ul>
                    <img src="{{ asset($car->image) }}" alt="{{ $car->title }}" style="max-width: 100%;">
                    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary mt-3">Edit</a>
                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-3" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
