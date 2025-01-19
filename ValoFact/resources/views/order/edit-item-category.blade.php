@extends('layouts.app')


@section('content')


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Edit Category: {{ $itemCategory->name }}</h2>
            <form action="{{ route('itemcategory.update', ['itemCategory' => $itemCategory]) }}" method="POST">
            @csrf 
            @method('put')   
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Category Name:</label>
                    <input type="text" class="form-control" id="categoryName" name="name" placeholder="{{ $itemCategory->name }}" value="{{ old('name', $itemCategory->name) }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>


@endsection