<x-admin-layout>
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
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr data-id="{{ $order->id }}">
                    <th scope="col">{{ $order->id }}</th>
                    <td>${{ number_format($order->total_price / 100, 2) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <form action="{{route('change.order.status',$order->id)}}" method="POST">
                            @csrf
                            <select class="form-select" name="status">
                                <option value="{{ $order->status }}" selected>{{ $order->status }}</option>
                                <option value="stale">stale</option>
                                <option value="new">new</option>
                                <option value="active">active</option>
                                <option value="finished">finished</option>
                                <option value="rejected">rejected</option>
                            </select>
                            <button  type="submit" class="btn btn-warning">Change status</button>
                        </form>
                    </td>
                    <td><a class="btn btn-secondary" href='{{route('admin.show.order',$order->id)}}' data-id="{{ $order->id }}">Show Order Details</a></td>
                </tr>
            @endforeach
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
            </tbody>
        </table>
            </div>
        </div>
    </div>
</x-admin-layout>

{{--<script type="module">--}}
{{--    $('#ordersTable').DataTable({--}}
{{--        "paging": true,--}}
{{--        "searching": true,--}}
{{--        "ordering": true--}}
{{--    });--}}
{{--</script>--}}
