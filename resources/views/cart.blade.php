@extends('app')
@section('content')
    <div class="flex justify-center">
        <div>
            <table class="table-auto">
                <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Qty</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        <td class="border px-4 py-2">
                            <a href="{{ route('products.show', $item->product->id) }}">
                                {{ $item->product->name }}
                            </a>
                        </td>
                        <td class="border px-4 py-2">
                            {{ $item->product->price }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $item->qty }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <h6 class="text-xl text-right">
                Total: {{ auth()->user()->orders()->byStatus(\App\Models\Order::STATUS_DRAFT)->value('total') }}</h6>
        </div>
    </div>
@endsection
