<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'shopp') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-vh-100 bg-light">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-white shadow-sm border-bottom">
            <div class="container py-3">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main>
        {{ $slot }}
        <div class="offcanvas w-50 offcanvas-end" tabindex="-1" id="cart" aria-labelledby="cartLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="cartTittleLabel">Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Available</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-right">Price</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="cart-items">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                    <td id="cart-total" class="text-right"><strong>0.00</strong></td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col mb-2">
                        <form id="checkout-form" action="{{ route('order.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact_phone" class="form-label">Contact Phone</label>
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone">
                            </div>
                            <button type="submit" id="checkout-button"
                                    class="btn btn-lg btn-block btn-success text-uppercase">Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
<script>
    document.getElementById('cartButton').addEventListener('click', function () {
        fetchCartItems();
    });

    function fetchCartItems() {
        fetch('/cart')
            .then(response => response.json())
            .then(cartItems => {
                const cartTableBody = document.querySelector('#cart-items');
                const cartTotal = document.querySelector('#cart-total');
                cartTableBody.innerHTML = '';
                let total = 0;

                if (cartItems.length === 0) {
                    cartTableBody.innerHTML = '<tr><td colspan="6">Your cart is empty</td></tr>';
                } else {
                    cartItems.forEach(item => {
                        const imagePath = item.product.images[0]?.image_path || '';
                        const itemTotal = (item.quantity * (item.price / 100));
                        total += itemTotal;

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><img src="/storage/${imagePath}" alt="${item.product.title}" width="50"></td>
                            <td>${item.product.title}</td>
                            <td>${item.product.quantity > 0 ? 'In stock' : 'Out of stock'}</td>
                            <td><input class="form-control quantity-input" type="number" value="${item.quantity}" min="1" data-price="${item.price}" data-id="${item.id}"></td>
                            <td class="text-right">${itemTotal.toFixed(2)} </td>
                            <td class="text-right">
                                <form action="/cart/remove/${item.id}" method="POST">
                                    @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </td>`;
                        cartTableBody.appendChild(row);
                    });


                    cartTotal.textContent = `${total.toFixed(2)} `;


                    document.querySelectorAll('.quantity-input').forEach(input => {
                        input.addEventListener('change', updateQuantity);
                    });
                }
            })
            .catch(error => console.error('Error fetching cart items:', error));
    }

    function updateQuantity(event) {
        const input = event.target;
        const quantity = parseInt(input.value, 10);
        const itemId = input.dataset.id;
        const price = parseFloat(input.dataset.price);

        if (isNaN(quantity) || quantity < 1) {
            return;
        }

        fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({quantity})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const itemTotal = quantity * (price / 100);
                    input.closest('tr').querySelector('td.text-right').textContent = `${itemTotal.toFixed(2)}`;

                    let total = 0;
                    document.querySelectorAll('#cart-items tr').forEach(row => {
                        const rowTotal = parseFloat(row.querySelector('td.text-right').textContent.replace('', ''));
                        total += rowTotal;
                    });

                    document.querySelector('#cart-total').textContent = `${total.toFixed(2)}`;
                } else {
                    console.error('Failed to update quantity');
                }
            })
            .catch(error => console.error('Error updating quantity:', error));
    }


</script>
