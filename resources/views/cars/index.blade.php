@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>Cars List</h2>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Video</th>
                        <th>Specifications</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $car)
                    <tr>
                        <td>
                            @if (!empty($car->images))
                                <img src="{{ asset($car->images[0]) }}" alt="{{ $car->title }}" style="max-width: 100px;">
                            @endif
                        </td>
                        <td>{{ $car->title }}</td>
                        <td>{{ $car->price }}</td>
                        <td>{{ $car->video }}</td>
                        <td>
                            @foreach (json_decode($car->specifications, true) as $specification)
                            @if(isset($specification['name']))
                                <li><strong>Name:</strong> {{ $specification['name'] }}</li>
                            @endif
                            @if(isset($specification['description']))
                                <li><strong>Description:</strong> {{ $specification['description'] }}</li>
                            @endif
                            @if(isset($specification['icon']))
                                <li><strong>Icon:</strong> {{ $specification['icon'] }}</li>
                            @endif
                        @endforeach



                        </td>
                        <td>
                            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-primary btn-sm">View</a>
                            <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
