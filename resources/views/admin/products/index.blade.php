<x-admin-layout>
    <div class="container">
        <h1>Product List</h1>

        <!-- Table for DataTables -->
        <table id="productsTable" class="display table ">
            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Quantity</th>
                <th scope="col">Featured</th>
                <th scope="col">Images</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description ?? '' }}</td>
                    <td>{{ $product->price / 100 ?? '' }}</td>
                    <td>{{ $product->category->name ?? '' }}</td>
                    <td>{{ $product->quantity ?? '' }}</td>
                    <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                    <td>
                        @foreach ($product->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" width="50" />
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.remove', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </tbody>
        </table>
    </div>

{{--    <script type="module">--}}
{{--        $('#productsTable').DataTable({--}}
{{--            paging: true,--}}
{{--            searching: true,--}}
{{--            info: true--}}
{{--        });--}}
{{--    </script>--}}
</x-admin-layout>
