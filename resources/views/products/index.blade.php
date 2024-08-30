<x-app-layout>
    <div class="container px-4 px-lg-5 my-5">
        <div class="card">
            <div class="card-body">
                <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <div class="row">
                    @if($product->images->count())
                        <div class="col-2">
                            @foreach ($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid" alt="{{ $product->title }}">
                            @endforeach
                        </div>
                        <div class="col-9">
                            @if(!$image->is_main)
                                @foreach ($product->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top mb-5 mb-md-0" alt="{{ $product->title }}">
                                @endforeach
                            @else
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="card-img-top mb-5 mb-md-0" alt="{{ $product->title }}">
                            @endif
                        </div>
                    @else
                        <img src="" class="img-fluid" alt="No Image Available">
                    @endif
                </div>
            </div>
            <div class="col-1">
                <div class="d-flex" style="height: 300px;">
                    <div class="vr"></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="small mb-1">SKU: {{ $product->id }}</div>
                <h1 class="display-5 fw-bolder">{{ $product->title }}</h1>
                <div class="fs-5 mb-5">
                    <span>{{ number_format($product->price / 100, 2) }}</span>
                </div>
                <p class="lead">{{ $product->description }}</p>
                <div class="d-flex">
                    <input class="form-control text-center me-3" id="quantity_input" name="quantity" type="number" min="1" value="1" style="max-width: 3rem" />
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</x-app-layout>
