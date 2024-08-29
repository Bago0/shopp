@php use Illuminate\Support\Facades\Auth; @endphp
@php $user = Auth::user(); @endphp

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">

        <!-- Toggler Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-4 h3">
                    <li class="nav-item">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>
                    </li>
                    @if($categories->count() > 5)
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="btn p-1 nav-link text-secondary border-bottom border-transparent hover:text-dark hover:border-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Categories
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($categories as $category)
                                        <li class="nav-item">
                                            <x-nav-link :href="route('category.products',$category->id)" :active="request()->is('category/products/' . $category->id . '*')">
                                                {{ ucfirst($category->name) }}
                                            </x-nav-link>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        @foreach($categories as $category)
                            <li class="nav-item">
                                <x-nav-link :href="route('category.products',$category->id)" :active="request()->is('category/products/' . $category->id . '*')">
                                    {{ ucfirst($category->name) }}
                                </x-nav-link>
                            </li>
                        @endforeach
                    @endif
                    @if($user)
                    <li class="nav-item">
                        <x-nav-link :href="route('myOrders')" :active="request()->routeIs('myOrders')">
                            {{ __('Orders') }}
                        </x-nav-link>
                    </li>
                    @endif
            </ul>

            <!-- Settings Dropdown -->
            <ul class="navbar-nav ms-auto">
                @if($user)
                    <li class="nav-item">
                        <button class="btn btn-outline-secondary" data-bs-toggle="offcanvas" href="#cart" role="button" aria-controls="offcanvasExample" id="cartButton">
                            <a href="{{route('cart.show')}}"></a><i class="bi-cart-fill me-1"></i>
                        </button>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="/register">{{ __('Sign Up') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">{{ __('Log In') }}</a>
                        </li>
                    @endguest
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="row">
    <div class="col-12">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        @endif
    </div>
</div>
