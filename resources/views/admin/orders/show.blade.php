<x-admin-layout>
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header">
                <h2>Order #{{ $order->id }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Placed on:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                <p><strong>Contact Name:</strong> {{ $order->contact_name }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Cart Items</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Images</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($order->cart->items))
                            @foreach($order->cart->items as $item)
                                <tr>
                                    <td>{{ $item->product->title ?? '' }}</td>
                                    <td>{{ $item->quantity ?? '' }}</td>
                                    <td>${{ number_format($item->price / 100, 2) ?? '' }}</td>
                                    <td>
                                        @if(!empty($item->product->images))
                                            @foreach($item->product->images as $image)
                                                <img src="/storage/{{ $image->image_path }}" alt="{{ $item->product->name }}" class="img-thumbnail" width="100">
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
