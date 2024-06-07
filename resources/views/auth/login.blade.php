<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @include('includes.header')
</head>

<body>
    <div class="w-full h-screen flex items-center justify-center">
        <form action="{{ route('login-user') }}" method="POST"
            class="w-full max-w-[500px] text-slate-800 p-4 mx-4 space-y-2 shadow-md rounded-md">
            @csrf
            <h1 class="text-2xl text-center font-bold">Sign In</h1>
            @if (session()->has('invalid'))
                <div class="p-4 my-4 bg-rose-200  text-rose-800 rounded">
                    {{ session('invalid') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="p-4 my-4 bg-rose-200  text-rose-800 rounded">
                    {{ session('error') }}
                </div>
            @endif
            @if (session()->has('success'))
                <div class="p-4 my-4 bg-green-200  text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <div class="flex flex-col gap-1">
                <label for="email" class="font-semibold">Email</label>
                <input name="email" type="text" placeholder="Enter your email" value="{{ old('email') }}"
                    class="p-2 border border-slate-300 rounded focus:outline-slate-800">
                <span class="text-rose-500 text-sm">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <label for="password" class="font-semibold">Password</label>
                <div class="relative">
                    <input name="password" id="password" type="password" placeholder="Enter your password"
                        value="{{ old('password') }}"
                        class="p-2 border border-slate-300 rounded focus:outline-slate-800 w-full pr-10" />
                    <button type="button" id="togglePassword"
                        class="text-slate-800 absolute right-2 top-1/2 transform -translate-y-1/2 ">
                        Show
                    </button>
                </div>
                <span class="text-rose-500 text-sm">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <button type="submit"
                class="w-full bg-slate-800 hover:bg-slate-700 text-slate-200 p-2 rounded-md transition">Login</button>
            <div>
                <a href="#" class="text-sm underline cursor-pointer">Forgot your
                    password?</a>
            </div>
            <div class="flex flex-col items-center justify-center">
                <p class="text-sm text-center m-4">Don't have an account? <a href="register"
                        class="text-blue-400 hover:text-blue-300 cursor-pointer transition">Register
                        here</a> </p>
            </div>
        </form>
    </div>

    <script>
        // Toggles the visibility of password
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('togglePassword').addEventListener('click', () => {
                const passwordField = document.getElementById('password');
                const passwordFieldType = passwordField.getAttribute('type');
                if (passwordFieldType === 'password') {
                    passwordField.setAttribute('type', 'text');
                    this.textContent = 'Hide';
                } else {
                    passwordField.setAttribute('type', 'password');
                    this.textContent = 'Show';
                }
            });
        });
    </script>
</body>

</html>
