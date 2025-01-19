@extends('layouts.app')


@section('content')


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Enter Category Name</h2>
            <form action="{{ route('itemcategory.store') }}" method="POST">
            @csrf 
            @method('post')   
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Category Name:</label>
                    <input type="text" class="form-control" id="categoryName" name="name" placeholder="Enter category name" value="{{ old('name') }}">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>


@endsection