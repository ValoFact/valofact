@extends('layouts.app')

@section('content')
    <div class="container">
        @if (isset($order))
            <h1>{{ $editMode ? 'Edit Order' : 'View Order' }}</h1>
        @else
            <h1>View Order</h1>
        @endif

        @include('shared.flash')

        @if (isset($order))
            <form
                action="{{ $editMode ? route('order.update', $order) : '#' }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($editMode)
                    @method('PUT')
                @endif

                <!-- Order Details -->
                <div class="card mb-4">
                    <div class="card-header">Order Details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $order->title) }}" {{ $editMode ? '' : 'readonly' }}>
                            @include('shared.error-message', ['name' => 'title'])
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" {{ $editMode ? '' : 'readonly' }}>{{ old('description', $order->description) }}</textarea>
                            @include('shared.error-message', ['name' => 'description'])
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" step="0.01" class="form-control @error('quantity') is-invalid @enderror" id="order-quantity"
                                    name="quantity" value="{{ old('quantity', $order->quantity) }}" readonly>
                                <input type="hidden" id="calculated-order-quantity" name="calculated_quantity"
                                    value="{{ old('calculated_quantity', $order->quantity) }}">
                                @include('shared.error-message', ['name' => 'quantity'])
                            </div>
                            <div class="col-md-6">
                                <label for="quantity_unit" class="form-label">Quantity Unit</label>
                                <select class="form-control" id="quantity_unit" name="quantity_unit"
                                    {{ $editMode ? '' : 'disabled' }}>
                                    <option value="kg"
                                        {{ old('quantity_unit', $order->quantity_unit) == 'kg' ? 'selected' : '' }}>kg
                                    </option>
                                    <option value="ton"
                                        {{ old('quantity_unit', $order->quantity_unit) == 'ton' ? 'selected' : '' }}>ton
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quality" class="form-label">Quality</label>
                            <input type="text" class="form-control @error('quality') is-invalid @enderror" id="quality" name="quality"
                                value="{{ old('quality', $order->quality) }}" {{ $editMode ? '' : 'readonly' }}>
                            @include('shared.error-message', ['name' => 'quality'])
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location"
                                value="{{ old('location', $order->location) }}" {{ $editMode ? '' : 'readonly' }}>
                            @include('shared.error-message', ['name' => 'location'])
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="include_transportation"
                                name="include_transportation"
                                {{ (old('include_transportation', $order->include_transportation) ? 'checked' : '') }}
                                {{ $editMode ? '' : 'disabled' }}>
                            <label class="form-check-label" for="include_transportation">Include
                                Transportation</label>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_price" class="form-label">Start Price</label>
                                <input type="number" step="0.01" class="form-control @error('start_price') is-invalid @enderror" id="start_price"
                                    name="start_price" value="{{ old('start_price', $order->start_price) }}"
                                    {{ $editMode ? '' : 'readonly' }}>
                                @include('shared.error-message', ['name' => 'start_price'])
                            </div>
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="text" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date"
                                    value="{{ old('start_date', $order->start_date) }}"
                                    {{ $editMode ? '' : 'readonly' }}>
                                @include('shared.error-message', ['name' => 'start_date'])
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="text" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date"
                                value="{{ old('end_date', $order->end_date) }}" {{ $editMode ? '' : 'readonly' }}
                                required>
                            @include('shared.error-message', ['name' => 'end_date'])
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="card mb-4">
                    <div class="card-header">Items</div>
                    <div class="card-body">
                        <div id="items-container">
                            @foreach (old('items', $order->items) as $index => $item)
                                <div class="row mb-3">
                                    <input type="hidden" name="items[{{ $index }}][id]"
                                        value="{{ $item['id'] ?? '' }}">
                                    <div class="col-md-4">
                                        <label class="form-label">Item Category</label>
                                        <select class="form-control" name="items[{{ $index }}][item_category_id]"
                                            {{ $editMode ? '' : 'disabled' }}>
                                            @foreach ($itemCategories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ (old('items.' . $index . '.item_category_id', $item->item_category_id ?? ($item['item_category_id'] ?? null)) == $category->id) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Item Name</label>
                                        <input type="text" class="form-control @error('items.*.name') is-invalid @enderror"
                                            name="items[{{ $index }}][name]"
                                            value="{{ old('items.' . $index . '.name', $item->name ?? ($item['name'] ?? '')) }}"
                                            {{ $editMode ? '' : 'readonly' }}>
                                        @include('shared.error-message', ['name' => 'items.*.name'])
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" step="0.01" class="form-control @error('items.*.quantity') is-invalid @enderror"
                                            name="items[{{ $index }}][quantity]"
                                            value="{{ old('items.' . $index . '.quantity', $item->quantity ?? ($item['quantity'] ?? '')) }}"
                                            {{ $editMode ? '' : 'readonly' }}>
                                        @include('shared.error-message', ['name' => 'items.*.quantity'])
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Quantity Unit</label>
                                        <select class="form-control" name="items[{{ $index }}][quantity_unit]"
                                            {{ $editMode ? '' : 'disabled' }}>
                                            <option value="kg"
                                                {{ (old('items.' . $index . '.quantity_unit', $item->quantity_unit ?? ($item['quantity_unit'] ?? '')) == 'kg') ? 'selected' : '' }}>
                                                kg
                                            </option>
                                            <option value="ton"
                                                {{ (old('items.' . $index . '.quantity_unit', $item->quantity_unit ?? ($item['quantity_unit'] ?? '')) == 'ton') ? 'selected' : '' }}>
                                                ton
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Unit Price</label>
                                        <input type="number" step="0.01" class="form-control @error('items.*.unit_price') is-invalid @enderror"
                                            name="items[{{ $index }}][unit_price]"
                                            value="{{ old('items.' . $index . '.unit_price', $item->unit_price ?? ($item['unit_price'] ?? '')) }}"
                                            {{ $editMode ? '' : 'readonly' }}>
                                        @include('shared.error-message', ['name' => 'items.*.unit_price'])
                                    </div>
                                    @if ($editMode)
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-item mt-4">X</button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if ($editMode)
                            <button type="button" class="btn btn-secondary mt-2" id="add-item">Add Item</button>
                        @endif
                    </div>
                </div>

                <!-- Media -->
                <div class="card mb-4">
                    <div class="card-header">Media (Photos/Videos)</div>
                    <div class="card-body">
                        <div id="media-container">
                            @if ($editMode)
                                @foreach (old('medias', $order->medias) as $index => $media)
                                    <div class="mb-3">
                                        <input type="hidden" name="medias[{{ $index }}][id]"
                                            value="{{ $media['id'] ?? '' }}">
                                        <input type="file" class="form-control @error('medias.*.file') is-invalid @enderror"
                                            name="medias[{{ $index }}][file]" accept="image/*,video/*">
                                        @include('shared.error-message', ['name' => 'medias.*.file'])

                                        @if (isset($media) && $media->path)
                                            <a href="{{ Storage::url($media->path) }}"
                                                target="_blank">View</a>
                                        @endif

                                        <button type="button" class="btn btn-danger remove-media mt-2">X</button>
                                    </div>
                                @endforeach
                            @else
                                <!-- Display existing media for viewing -->
                                @foreach ($order->medias as $media)
                                    <div class="mb-3">
                                        @if (pathinfo($media->path, PATHINFO_EXTENSION) == 'mp4')
                                            <video width="320" height="240" controls>
                                                <source src="{{ Storage::url($media->path) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img src="{{ Storage::url($media->path) }}" alt="Media" width="200">
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if ($editMode)
                            <button type="button" class="btn btn-secondary mt-2" id="add-media">Add Media</button>
                        @endif
                    </div>
                </div>

                @if ($editMode)
                    <button type="submit" class="btn btn-primary">Update Order</button>
                @endif
            </form>
        @else
            <p>No order found.</p>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (isset($order))
                // Initialize Flatpickr for date fields
                flatpickr("#start_date", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    defaultDate: "{{ $order->start_date }}"
                });

                flatpickr("#end_date", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    defaultDate: "{{ $order->end_date }}"
                });
            @endif

            let itemIndex = {{ isset($order) ? count(old('items', $order->items)) : 0 }};
            let mediaIndex = {{ isset($order) ? count(old('medias', $order->medias)) : 0 }};

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
                    @if (isset($order) && $editMode)
                        addItemRow();
                    @endif
                });

            @if (isset($order) && $editMode)

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
                <input type="text" class="form-control" name="items[${itemIndex}][name]" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" step="0.01" class="form-control" name="items[${itemIndex}][quantity]" required>
            </div>
            <div class="col-md-3">
                <label for="items[${itemIndex}][quantity_unit]" class="form-label">Quantity Unit</label>
                <select class="form-control" name="items[${itemIndex}][quantity_unit]">
                    <option value="kg">kg</option>
                    <option value="ton">ton</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Unit Price</label>
                <input type="number" step="0.01" class="form-control" name="items[${itemIndex}][unit_price]" required>
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
            @endif

            @if (isset($order) && $editMode)
                addItemButton.addEventListener('click', addItemRow);
                addMediaButton.addEventListener('click', addMediaInput);

                // Add event listeners to existing item rows for deletion
                const existingItemRows = document.querySelectorAll('#items-container .row');
                existingItemRows.forEach(row => {
                    row.querySelector('.remove-item').addEventListener('click', function() {
                        itemsContainer.removeChild(row);
                    });
                });

                // Add event listeners to existing media inputs for deletion
                const existingMediaInputs = document.querySelectorAll('#media-container .mb-3');
                existingMediaInputs.forEach(input => {
                    input.querySelector('.remove-media').addEventListener('click', function() {
                        mediaContainer.removeChild(input);
                    });
                });
            @endif
        });
    </script>
@endsection