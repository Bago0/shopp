<x-admin-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-dark">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card p-4 bg-white shadow-sm">
                        <div class="card-body">
                            <p>Your generated token is: <strong>{{ session('token') }}</strong></p>
                            <form action="{{route('tokens.create')}}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="text" value="token" name="token_name" hidden>
                                <button class="btn btn-warning" type="submit">Generate token</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card p-4 bg-white shadow-sm">
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card p-4 bg-white shadow-sm">
                        <div class="card-body">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
