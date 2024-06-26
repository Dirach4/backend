<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>
 
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat datang di app kumala") }}
                    <p><a href="products" class="btn btn-primary">Products</a></p>
                    <p><a href="reports" class="btn btn-primary">Report</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<!-- <p><a href="products" class="btn btn-primary">Products</a></p> -->