<x-admin-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Category and Product') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="container mt-5">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Create Category
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body custom-bg">
                                            <div class="d-flex flex-wrap pe-3 w-100 justify-content-between">
                                                @foreach ($categories as $category)
                                                    <h5>
                                                        <div class="chip p-2 pl-3 pr-3 border border-info rounded-pill mr-2 d-flex align-items-center " data-chip="{{ $category['id'] }}">
                                                                <?php
                                                                echo $category['name'];
                                                                ?>
                                                            <a href="{{ URL::current().'/category/remove/'.$category['id'] }}" class="ms-2">
                                                                <i class="bi bi-trash text-danger"></i>
                                                            </a>
                                                        </div>
                                                    </h5>
                                                @endforeach
                                            </div>
                                            <form method="POST" action="{{ route('categories.store') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Category Name</label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                {{ __('Product') }}
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="title">{{ __('Title') }}</label>
                                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="description">{{ __('Description') }}</label>
                                                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="price">{{ __('Price') }}</label>
                                                        <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="category_id">{{ __('Category') }}</label>
                                                        <select class="form-control" id="category_id" name="category_id" >
                                                            <option value="" selected>select</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="quantity">{{ __('Quantity') }}</label>
                                                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}">
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="images">{{ __('Images') }}</label>
                                                        <input type="file" class="form-control" id="images" name="images[]" multiple="multiple" required>
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <label for="main_image">{{ __('Main Image Index') }}</label>
                                                        <input type="number" class="form-control"  id="main_image" name="main_image" value="{{ old('main_image') }}" required>
                                                        <small class="form-text text-muted">{{ __('Enter the index (starting from 0) of the main image in the upload order.') }}</small>
                                                    </div>

                                                    <div class="form-group mt-3 form-check">
                                                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_featured">{{ __('Is Featured?') }}</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-3">{{ __('Save Product') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
