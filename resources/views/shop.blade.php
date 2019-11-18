@extends('app')
@section('content')
    <table class="mt-6 bg-black text-white mx-auto w-full">
        <thead class="bg-red-500 font-bold">
        <tr class="mb-1 m-6">
            <th class="p-3">Name</th>
            <th class="p-3">Price</th>
            <th class="p-3">Currency</th>
            <th class="p-3">#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <th class="font-normal p-3"><a
                            href="{{ route('products.show', $product['id']) }}">{{ $product['name'] }}</a></th>
                <th class="font-normal p-3">{{ $product['price'] }}</th>
                <th class="font-normal p-3">PLN</th>
                <th class="font-bold">
                    @auth
                        <form action="{{ route('addItemToOrder', ['user_id' => auth()->id(), 'product_id' => $product['id']]) }}"
                              method="POST">
                            @csrf
                            <button class="p-2 font-bold text-red-500" type="submit">+</button>
                        </form>
                    @endauth
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
