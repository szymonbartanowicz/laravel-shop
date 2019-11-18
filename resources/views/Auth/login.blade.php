@extends('app')
@section('content')
    <div class="p-3 lg:w-1/2 mx-auto">
        <form method="post" action="login">

            @csrf

            <div class="flex items-center border-b border-b-2 border-red-500 py-2">
                <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                       type="email" placeholder="Email" id="email" name="email">
            </div>
            <div class="flex items-center border-b border-b-2 border-red-500 py-2">
                <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                       type="password" placeholder="Password" id="password" name="password">
            </div>
            <button class="bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-sm border-4 text-white py-1 px-2 mt-3 rounded"
                    type="submit">
                Login
            </button>
        </form>

        @include('errors')
    </div>

@endsection