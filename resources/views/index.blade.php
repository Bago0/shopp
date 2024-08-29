<x-app-layout>
    <div class="container-fluid p-4">
        @if($featuredProducts->isNotEmpty())
            <div class="row">
                <div class="col">
                    <h3>Featured Products</h3>
                    <div class="row">
                        @foreach($featuredProducts as $product)
                            <div class="col-2 mb-4">
                                <a href="{{ route('products.show', $product->id) }}" class="card-link">
                                    <div class="card h-100 d-flex flex-column">
                                        @if($product->images->count())
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="card-img-top product-image " alt="{{ $product->title }}">
                                        @else
                                            <img src="" class="card-img-top product-image" alt="No Image Available">
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $product->title }}</h5>
                                            <p class="card-text"><strong>{{ number_format($product->price / 100, 2) }}</strong></p>
                                        </div>
                                        <div class="mt-auto p-3">
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                                    <i class="bi-cart-fill me-1"></i>
                                                    Add to Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        @foreach($categorizedProducts as $category)
            <div class="row">
                <div class="col">
                    @if($category->products->isNotEmpty())
                        <h3>{{ ucfirst($category->name) }}</h3>
                        <div class="row">
                    @foreach($category->products as $product)
                        <div class="col-2 mb-4">
                            <a href="{{ route('products.show', $product->id) }}" class="card-link">
                                <div class="card h-100 d-flex flex-column">
                                    @if($product->images->count())
                                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="card-img-top product-image " alt="{{ $product->title }}">
                                    @else
                                        <img src="" class="card-img-top product-image " alt="No Image Available">
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $product->title }}</h5>
                                        <p class="card-text"><strong>{{ number_format($product->price / 100, 2) }}</strong></p>
                                    </div>
                                    <div class="mt-auto p-3">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                                <i class="bi-cart-fill me-1"></i>
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                     @endif
                </div>
            </div>
        @endforeach

        @if($uncategorizedProducts->isNotEmpty())
            <div class="row">
                <div class="col">
                    <h3>Other Products</h3>
                    <div class="row">
                        @foreach($uncategorizedProducts as $product)
                            <div class="col-2 mb-4">
                                <a href="{{ route('products.show', $product->id) }}" class="card-link">
                                    <div class="card h-100 d-flex flex-column">
                                        @if($product->images->count())
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="card-img-top product-image " alt="{{ $product->title }}">
                                        @else
                                            <img src="" class="card-img-top product-image " alt="No Image Available">
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $product->title }}</h5>
                                            <p class="card-text"><strong>{{ number_format($product->price / 100, 2) }}</strong></p>
                                        </div>
                                        <div class="mt-auto p-3">
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                                    <i class="bi-cart-fill me-1"></i>
                                                    Add to Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
         @endif
    </div>

    <style>
        .card-link {
            text-decoration: none;
            color: inherit;
        }
        .card-link:hover .card {
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }
        .card {
            transition: box-shadow 0.2s ease;
        }
        .card .btn {
            width: 100%;
        }
        .card-body {
            flex-grow: 1;
        }
        .product-image {
            width: 100%;
            height: 200px; /* Fixed height */
            object-fit: cover; /* Scale image to cover the area, maintaining aspect ratio */
        }
    </style>
</x-app-layout>
