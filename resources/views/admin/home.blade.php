<x-admin-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4>Total Products</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ $productCount }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4>Total Order Price (Finished Orders)</h4>
                    </div>
                    <div class="card-body">
                        <p>${{ number_format($totalOrderPrice, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4>Order Counts</h4>
                    </div>
                    <div class="card-body">
                        <p>Active Orders: {{ $activeOrdersCount }}</p>
                        <p>New Orders: {{ $newOrdersCount }}</p>
                        <p>Completed Orders: {{ $completedOrdersCount }}</p>
                        <p>Rejected Orders: {{ $rejectedOrdersCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
