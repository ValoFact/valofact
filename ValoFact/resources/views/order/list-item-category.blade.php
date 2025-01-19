@extends('layouts.app')


@section('content')
@include('shared.flash')

<div class="container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itemCategories as $itemCategory)
                <tr>
                    <th>{{ $itemCategory->name }}</th>
                    <th>
                        <div class="d-flex gap-2 w-100 justify-content-end">
                            <a href="{{ route('itemcategory.edit', ['itemCategory' => $itemCategory]) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('itemcategory.destroy', $itemCategory) }}" method="POST" 
                                onsubmit="return confirm('Do you really want to delete this category ?')">
                                @csrf
                                @method("delete")
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>


        
    </div>

@endsection