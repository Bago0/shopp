<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col p-3">
                <h3>Your Orders</h3>
                <table id="ordersTable" class="display table table-auto">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Total Price</th>
                <th scope="col">Creation Time</th>
                <th scope="col">Status</th>
                <th scope="col">Cancel Order</th>
                <th scope="col">Show Order</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr data-id="{{ $order->id }}">
                    <th scope="col">{{ $order->id }}</th>
                    <td>${{ number_format($order->total_price / 100, 2) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <form action="{{route('remove.order',$order->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"  data-id="{{ $order->id }}">Remove</button>
                        </form>
                    </td>
                    <td><a class="btn btn-warning" href='{{route('show.order',$order->id)}}' data-id="{{ $order->id }}">Show Order Details</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="module">
    $('#ordersTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true
    });
</script>
