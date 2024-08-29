@php use Illuminate\Support\Facades\Auth; @endphp
@php $user = Auth::user(); @endphp

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        @if($user)
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <x-application-logo class="h-9 w-auto fill-current text-gray-800"/>
            </a>
        @endif

        <!-- Toggler Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if($user)
                    <li class="nav-item">
                        <x-nav-link :href="route('admin.home')" :active="request()->routeIs('admin.home')">
                            {{ __('Home') }}
                        </x-nav-link>
                    </li>
                    <li class="nav-item">
                        <x-nav-link :href="route('create.categoriesAndProducts')" :active="request()->routeIs('create.categoriesAndProducts')">
                            {{ __('Create') }}
                        </x-nav-link>
                    </li>
                    <li class="nav-item">
                        <x-nav-link :href="route('admin.products')" :active="request()->routeIs('admin.products')">
                            {{ __('Products') }}
                        </x-nav-link>
                    </li>
                    <li class="nav-item">
                        <x-nav-link :href="route('allOrders')" :active="request()->routeIs('allOrders')">
                            {{ __('Orders') }}
                        </x-nav-link>
                    </li>
                @endif
            </ul>

            <!-- Settings Dropdown -->
            <div class="d-flex">
                @if($user)
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('profile.edit-admin') }}">{{ __('Profile') }}</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    @guest
                        <a class="btn btn-link" href="/register">{{ __('Sign Up') }}</a>
                        <a class="btn btn-link ms-2" href="/login">{{ __('Log In') }}</a>
                    @endguest
                @endif
            </div>
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
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
        @endif
    </div>
</div>
