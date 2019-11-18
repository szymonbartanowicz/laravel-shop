<div class="flex justify-between items-center text-white bg-black p-3 h-16">
    @guest
        <div>
            <a href="login" class="mr-2">login</a>
            <a href="register">register</a>
        </div>
    @endguest
    @auth
        @if(auth()->user()->orders()->byStatus(\App\Models\Order::STATUS_DRAFT)->exists())
            <div class="flex items-center">
                <form action="{{ route('closeOrder', ['order_id' => auth()->user()->orders()->byStatus(\App\Models\Order::STATUS_DRAFT)->value('id')]) }}"
                      method="POST">
                    @csrf
                    <button type="submit" class="bg-indigo-500 rounded-lg p-2">PAY</button>
                </form>
                <p class="flex items-center ml-2">
                    Total:
                    <span class="justify-center mx-1">{{ auth()->user()->orders()->byStatus(\App\Models\Order::STATUS_DRAFT)->value('total') }}</span>
                    PLN
                    <span class="rounded-full h-4 w-4 flex items-center justify-center bg-red-500 ml-2 text-xs">{{ $totalItems }}</span>
                </p>
            </div>
        @endif
        <div class="ml-auto">
            <a href="logout">logout</a>
            <span class="font-light">({{ Auth::user()->name }})</span>
        </div>
    @endauth
</div>
