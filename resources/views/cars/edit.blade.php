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

                <!-- عرض الصور الموجودة مع أزرار الحذف -->
                @if(isset($car) && is_array($car->images) && !empty($car->images))
                    <div class="form-group">
                        <label>الصور الموجودة</label>
                        <div class="row">
                            @foreach($car->images as $image)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ asset($image) }}" class="img-fluid" alt="صورة السيارة">
                                    <button type="button" class="btn btn-sm btn-danger deleteImage mt-2" data-image-id="{{ $image }}">حذف الصورة</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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

                @php
                $specifications = json_decode($car->specifications);
                @endphp

                @for ($i = 0; $i < count($specifications); $i += 3)
                    <div class="specification-group">
                        @for ($j = $i; $j < min($i + 3, count($specifications)); $j++)
                            <div class="specification mb-2">
                                @if(isset($specifications[$j]->name))
                                    <input type="text" class="form-control" name="specifications[][name]" value="{{ $specifications[$j]->name }}">
                                @endif
                                @if(isset($specifications[$j]->description))
                                    <input type="text" class="form-control" name="specifications[][description]" value="{{ $specifications[$j]->description }}">
                                @endif
                                @if(isset($specifications[$j]->icon))
                                    <input type="text" class="form-control" name="specifications[][icon]" value="{{ $specifications[$j]->icon }}">
                                @endif
                            </div>
                        @endfor
                        <button type="button" class="btn btn-sm btn-danger removeSpecification ml-2">Remove</button>
                    </div>
                @endfor

                <!-- هذا الجزء سيتم إضافته فقط عند النقر على زر "Add Specification" -->
                <div id="additionalSpecifications"></div>

                <button type="button" id="addSpecification" class="btn btn-sm btn-primary">Add Specification</button>
                <button type="submit" class="btn btn-success">{{ isset($car) ? 'Update Car' : 'Add Car' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Add specification field
        $('#addSpecification').click(function() {
            $('#additionalSpecifications').append('<div class="specification mb-2"><input type="text" class="form-control" name="specifications[][name]" placeholder="Specification Name"><input type="text" class="form-control" name="specifications[][description]" placeholder="Specification Description"><input type="text" class="form-control" name="specifications[][icon]" placeholder="Specification Icon"><button type="button" class="btn btn-sm btn-danger removeSpecification ml-2">Remove</button></div>');
        });

        // Remove specification field
        $(document).on('click', '.removeSpecification', function() {
            $(this).closest('.specification').remove();
        });

        // Delete image
        $(document).on('click', '.deleteImage', function() {
            var imageId = $(this).data('image-id');
            // Here you can implement the logic to delete the image via AJAX or form submission
            // Example AJAX call:
            // $.ajax({
            //     url: '/delete-image/' + imageId,
            //     type: 'DELETE',
            //     success: function(response) {
            //         // Handle success
            //     },
            //     error: function(xhr, status, error) {
            //         // Handle error
            //     }
            // });
            // For simplicity, let's remove the image element for now
            $(this).closest('.col-md-3').remove();
        });

           // Remove specification field
           $(document).on('click', '.removeSpecification', function() {
            $(this).closest('.specification-group').remove();
        });
    });
</script>


@endsection
