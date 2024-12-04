@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center bg-gray-100">
    <div class="max-w-sm w-full bg-white p-8 rounded-lg shadow-lg p-4">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login</h2>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4">
                <ul class="text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('authenticate') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" name="email" type="email" required
                    class="mt-2 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Your email" value="{{ old('email') }}"/>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="mt-2 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Your password"/>
            </div>

            <div>
                <button type="submit"
                    class="w-full py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Login
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('signup') }}" class="text-indigo-600 hover:text-indigo-800">Sign up</a></p>
        </div>
    </div>
</div>
@endsection