<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-dark">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card bg-white shadow-sm border-0 rounded-3">
                <div class="card-body">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
