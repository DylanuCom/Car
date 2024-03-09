@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>{{ isset($car) ? 'Edit Car' : 'Add New Car' }}</h2>
            <form action="{{ isset($car) ? route('cars.update', $car->id) : route('cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($car))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="images">Images</label>
                    <input type="file" class="form-control-file" id="images" name="images[]" accept="image/*" multiple>
                </div>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ isset($car) ? $car->title : '' }}">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Price" value="{{ isset($car) ? $car->price : '' }}">
                </div>
                <div class="form-group">
                    <label for="video">Video URL</label>
                    <textarea class="form-control" id="video" name="video" placeholder="Video URL">{{ isset($car) ? $car->video : '' }}</textarea>
                </div>
                <div class="form-group" id="specifications">
                    <label>Specifications</label>
                    @if(isset($car))
                        @foreach ($car->specifications as $specification)
                            <div class="specification mb-2">
                                <input type="text" class="form-control" name="specifications[][name]" placeholder="Specification Name" value="{{ $specification['name'] }}">
                                <input type="text" class="form-control" name="specifications[][description]" placeholder="Specification Description" value="{{ $specification['description'] }}">
                                <input type="text" class="form-control" name="specifications[][icon]" placeholder="Specification Icon" value="{{ $specification['icon'] }}">
                                <button type="button" class="btn btn-sm btn-danger removeSpecification ml-2">Remove</button>
                            </div>
                        @endforeach
                    @else
                        <div class="specification mb-2">
                            <input type="text" class="form-control" name="specifications[][name]" placeholder="Specification Name">
                            <input type="text" class="form-control" name="specifications[][description]" placeholder="Specification Description">
                            <input type="text" class="form-control" name="specifications[][icon]" placeholder="Specification Icon">
                            <button type="button" class="btn btn-sm btn-danger removeSpecification ml-2">Remove</button>
                        </div>
                    @endif
                </div>
                <button type="button" id="addSpecification" class="btn btn-sm btn-primary">Add Specification</button>
                <button type="submit" class="btn btn-success">{{ isset($car) ? 'Update Car' : 'Add Car' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addSpecification').click(function() {
            $('#specifications').append('<div class="specification mb-2"><input type="text" class="form-control" name="specifications[][name]" placeholder="Specification Name"><input type="text" class="form-control" name="specifications[][description]" placeholder="Specification Description"><input type="text" class="form-control" name="specifications[][icon]" placeholder="Specification Icon"><button type="button" class="btn btn-sm btn-danger removeSpecification ml-2">Remove</button></div>');
        });

        $(document).on('click', '.removeSpecification', function() {
            $(this).closest('.specification').remove();
        });
    });
</script>
@endsection
