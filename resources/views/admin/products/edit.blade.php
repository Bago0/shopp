<x-admin-layout>
    <div class="container">
        <h1>Edit Product</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <button type="submit" class="btn btn-primary mt-3">{{ __('Update Product') }}</button>
            <div class="form-group mt-3">
                <label for="title">{{ __('Title') }}</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $product->title) }}" required>
                @error('title')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="description">{{ __('Description') }}</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="price">{{ __('Price') }}</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', ($product->price)/100) }}" required>
                @error('price')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="category_id">{{ __('Category') }}</label>
                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="quantity">{{ __('Quantity') }}</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}">
                @error('quantity')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="images">{{ __('Upload New Images') }}</label>
                <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
                @error('images')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </form>
        <div class="mt-4">
            <h5>Existing Images</h5>
            <div class="row">
                @foreach ($product->images as $image)
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <form action="{{ route('productImages.remove', $image->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                @if (!$image->is_main)
                                    <form action="{{ route('productImages.setMain', $image->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Set as Main</button>
                                    </form>
                                @else
                                    <span class="badge bg-success mt-2">Main Image</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin-layout>
