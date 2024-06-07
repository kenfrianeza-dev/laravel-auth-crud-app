@include('includes.header')

<main>
    <div class="h-full flex items-center justify-center">
        <form action="{{ route('reset-password-post') }}" method="POST"
            class="w-full max-w-[500px] text-slate-800 p-4 mx-4 space-y-2 shadow-md rounded-md">
            @csrf
            <input name="token" type="text" class="hidden" value="{{ $token }}">
            <h1 class="text-start font-bold text-lg">Enter your new password
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
            <div class="flex flex-col gap-1 relative">
                <label for="password" class="font-semibold">New Password</label>
                <div class="relative">
                    <input name="password" id="password" type="password" placeholder="Enter new password"
                        value="{{ old('password') }}"
                        class="p-2 border border-slate-300 rounded focus:outline-slate-800 w-full pr-10">
                    <button type="button" id="togglePassword" class="absolute right-2 top-2">
                        Show
                    </button>
                </div>
                <span class="text-rose-500 text-sm">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="flex flex-col gap-1 relative">
                <label for="password_confirmation" class="font-semibold">Confirm New Password</label>
                <div class="relative">
                    <input name="password_confirmation" id="password_confirmation" type="password"
                        placeholder="Confirm new password" value="{{ old('password_confirmation') }}"
                        class="p-2 border border-slate-300 rounded focus:outline-slate-800 w-full pr-10">
                    <button type="button" id="togglePasswordConfirmation" class="absolute right-2 top-2">
                        Show
                    </button>
                </div>
                <span class="text-rose-500 text-sm">
                    @error('password_confirmation')
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

<script>
    // triggers an event when the DOM Content loaded
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');

        // triggers an event when the toggle password is clicked
        togglePassword.addEventListener('click', () => {
            const passwordField = document.getElementById('password');
            const passwordFieldType = passwordField.getAttribute('type');

            // toggles the visibility of the password
            if (passwordFieldType === 'password') {
                passwordField.setAttribute('type', 'text');
                this.textContent = 'Hide';
            } else {
                passwordField.setAttribute('type', 'password');
                this.textContent = 'Show';
            }
        });

        // triggers an event when the toggle password confirmation is clicked
        togglePasswordConfirmation.addEventListener('click', () => {
            const passwordField = document.getElementById('password_confirmation');
            const passwordFieldType = passwordField.getAttribute('type');

            // toggles the visibility of the password confirmation
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
