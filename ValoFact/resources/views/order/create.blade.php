@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Create New Order</h2>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    demo
                </button>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    </ul>
            </div>
        </div>
        @include('shared.flash')
        
        
        <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
            <!-- Order Details -->
            <div class="card mb-4">
                <div class="card-header">Order Details</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                        @include('shared.error-message', ['name' => 'title'])
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control  @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @include('shared.error-message', ['name' => 'description'])
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="order-quantity" class="form-label">Quantity</label>
                            <input type="number" step="0.01" class="form-control @error('quantity') is-invalid @enderror" id="order-quantity" name="quantity" value="{{ old('quantity') }}" readonly>
                            <input type="hidden" id="calculated-order-quantity" name="calculated_quantity" value="{{ old('calculated_quantity') }}">
                            @include('shared.error-message', ['name' => 'quantity'])
                        </div>
                        <div class="col-md-6">
                            <label for="quantity_unit" class="form-label">Quantity Unit</label>
                            <select class="form-control" id="quantity_unit" name="quantity_unit">
                                <option value="kg" {{ old('quantity_unit') == 'kg' ? 'selected' : '' }}>kg</option>
                                <option value="ton" {{ old('quantity_unit') == 'ton' ? 'selected' : '' }}>ton</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="quality" class="form-label">Quality</label>
                        <input type="text" class="form-control @error('quality') is-invalid @enderror" id="quality" name="quality" value="{{ old('quality') }}">
                        @include('shared.error-message', ['name' => 'quality'])
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input class="form-control @error('location') is-invalid @enderror" type="text" id="location" name="location" value="{{ old('location') }}">
                        @include('shared.error-message', ['name' => 'location'])
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            @include('shared.checkbox', ['name' => 'include_transportation', 'label' => 'Include Transport'])
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Order Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>AVAILABLE</option>
                                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>SOLD</option>
                                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>EXPIRED</option>
                            </select>
                        </div>


                    </div>
                    <!--
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="include_transportation"
                            name="include_transportation" {{ old('include_transportation') ? 'checked' : '' }}>
                        <label class="form-check-label" for="include_transportation">Include Transportation</label>
                    </div>
                    -->

                    <div class="row mb-3 mt-3">
                        <div class="col-md-6">
                            <label for="start_price" class="form-label">Start Price (DT)</label>
                            <input type="number" step="0.01" class="form-control @error('start_price') is-invalid @enderror" id="start_price" name="start_price" value="{{ old('start_price') }}">
                            @include('shared.error-message', ['name' => 'start_price'])
                        </div>
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="text" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                            @include('shared.error-message', ['name' => 'start_date'])
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="text" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @include('shared.error-message', ['name' => 'end_date'])
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="card mb-4">
                <div class="card-header">Items</div>
                <div class="card-body">
                    <div id="items-container">
                        <!-- Item rows will be added here -->
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" id="add-item">Add Item</button>
                </div>
            </div>

            <!-- Media -->
            <div class="card mb-4">
                <div class="card-header">Media (Photos/Videos)</div>
                <div class="card-body">
                    <div id="media-container">
                        <!-- Media file inputs will be added here -->
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" id="add-media">Add Media</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create Order</button>
        </form>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr for date fields
        flatpickr("#start_date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });

            flatpickr("#end_date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });

        let itemIndex = 0;
        let mediaIndex = 0;

        const itemsContainer = document.getElementById('items-container');
        const mediaContainer = document.getElementById('media-container');
        const addItemButton = document.getElementById('add-item');
        const addMediaButton = document.getElementById('add-media');

        // Fetch item categories (you'll need to implement the route and controller method for this)
        let itemCategories = [];
        fetch('/item-categories')
            .then(response => response.json())
            .then(data => {
                itemCategories = data;
                addItemRow(); // Add the first item row after fetching categories
            });

        
        // Function to calculate total quantity
        function calculateTotalQuantity() {
            let totalQuantity = 0;
            const orderQuantityUnit = document.getElementById('quantity_unit').value;

            const itemRows = document.querySelectorAll('#items-container .row'); // Get all item rows

            itemRows.forEach(row => {
                const itemQuantity = parseFloat(row.querySelector('[name$="[quantity]"]').value);
                const itemQuantityUnit = row.querySelector('[name$="[quantity_unit]"]').value;

                if (!isNaN(itemQuantity)) {
                    if (itemQuantityUnit === orderQuantityUnit) {
                        totalQuantity += itemQuantity;
                    } else if (itemQuantityUnit === 'ton' && orderQuantityUnit === 'kg') {
                        totalQuantity += itemQuantity * 1000; // Convert tons to kg
                    } else if (itemQuantityUnit === 'kg' && orderQuantityUnit === 'ton') {
                        totalQuantity += itemQuantity / 1000; // Convert kg to tons
                    }
                }
            });

            document.getElementById('order-quantity').value = totalQuantity.toFixed(2);
            document.getElementById('calculated-order-quantity').value = totalQuantity.toFixed(2);
        }

        // Add event listeners to item quantity and quantity_unit inputs
        itemsContainer.addEventListener('input', function(event) {
            if (event.target.name.endsWith('[quantity]') || event.target.name.endsWith('[quantity_unit]')) {
                calculateTotalQuantity();
            }
        });

        // Call calculateTotalQuantity initially and when the order quantity unit changes
        calculateTotalQuantity();
        document.getElementById('quantity_unit').addEventListener('change', calculateTotalQuantity);
            


        
        // Add Item Row
        function addItemRow() {
            const itemRow = document.createElement('div');
            itemRow.classList.add('row', 'mb-3');
            itemRow.innerHTML = `
                <div class="col-md-4">
                    <label class="form-label">Item Category</label>
                    <select class="form-control" name="items[${itemIndex}][item_category_id]">
                        ${itemCategories.map(category => `<option value="${category.id}">${category.name}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Item Name</label>
                    <input type="text" class="form-control @error('items.*.name') is-invalid @enderror" name="items[${itemIndex}][name]" value="{{ old('items.*.name') }}">
                    @include('shared.error-message', ['name' => 'items.*.name'])
                </div>
                <div class="col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" step="0.01" class="form-control @error('items.*.quantity') is-invalid @enderror" name="items[${itemIndex}][quantity]" value="{{ old('items.*.quantity') }}">
                    @include('shared.error-message', ['name' => 'items.*.quantity'])
                </div>
                <div class="col-md-3">
                        <label for="items[${itemIndex}][quantity_unit]" class="form-label">Quantity Unit</label>
                        <select class="form-control"  name="items[${itemIndex}][quantity_unit]">
                            <option value="kg" {{ old('quantity_unit') == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="ton" {{ old('quantity_unit') == 'ton' ? 'selected' : '' }}>ton</option>
                        </select>
                    </div>
                <div class="col-md-3">
                    <label class="form-label">Unit Price (DT)</label>
                    <input type="number" step="0.01" class="form-control  @error('items.*.unit_price') is-invalid @enderror" name="items[${itemIndex}][unit_price]" value="{{ old('items.*.unit_price') }}">
                    @include('shared.error-message', ['name' => 'items.*.unit_price'])
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-item mt-4">X</button>
                </div>
            `;
            itemsContainer.appendChild(itemRow);

            // Add event listener to remove item button
            itemRow.querySelector('.remove-item').addEventListener('click', function() {
                itemsContainer.removeChild(itemRow);
            });

            itemIndex++;
        }

        // Add Media Input
        function addMediaInput() {
            const mediaInput = document.createElement('div');
            mediaInput.classList.add('mb-3');
            mediaInput.innerHTML = `
                <input type="file" class="form-control" name="medias[${mediaIndex}][file]" accept="image/*,video/*">
                <button type="button" class="btn btn-danger remove-media mt-2">X</button>
            `;
            mediaContainer.appendChild(mediaInput);

            // Add event listener to remove media button
            mediaInput.querySelector('.remove-media').addEventListener('click', function() {
                mediaContainer.removeChild(mediaInput);
            });

            mediaIndex++;
        }

        addItemButton.addEventListener('click', addItemRow);
        addMediaButton.addEventListener('click', addMediaInput);
    });
</script>
@endsection

