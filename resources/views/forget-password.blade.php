@include('includes.header')

<main>
    <div class="h-full flex items-center justify-center">
        <form action="{{ route('forget-password-post') }}" method="POST"
            class="w-full max-w-[500px] text-slate-800 p-4 mx-4 space-y-2 shadow-md rounded-md">
            @csrf
            <h1 class="text-start">We will send a link to your email, use that link to reset your
                password.</h1>
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
            <button type="submit"
                class="w-full bg-slate-800 hover:bg-slate-700 text-slate-200 p-2 rounded-md transition">Submit</button>
            <div>
        </form>
    </div>
</main>
