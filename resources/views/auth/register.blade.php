<x-app-layout :title="'Register'">
    <div class="min-h-screen grid place-items-center p-6">
        <div class="w-full max-w-md rounded-2xl border border-primary/20 bg-white p-7 shadow-lg shadow-primary/20">
            <h1 class="text-3xl font-bold leading-tight">Create account</h1>
            <p class="mt-2 mb-6 text-sm text-primary/75">Start now and continue to your dashboard.</p>

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-info/30 bg-info/10 px-3 py-2 text-sm text-info">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="grid gap-4">
                @csrf
                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium">Name</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" class="block w-full rounded-lg border-primary/25 bg-white text-primary placeholder-primary/40 focus:border-info focus:ring-info">
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium">Email</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" class="block w-full rounded-lg border-primary/25 bg-white text-primary placeholder-primary/40 focus:border-info focus:ring-info">
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium">Password</label>
                    <input id="password" name="password" type="password" required class="block w-full rounded-lg border-primary/25 bg-white text-primary placeholder-primary/40 focus:border-info focus:ring-info">
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="block w-full rounded-lg border-primary/25 bg-white text-primary placeholder-primary/40 focus:border-info focus:ring-info">
                </div>

                <a href="{{ route('login') }}" class="text-sm font-medium text-info hover:underline">Already have an account?</a>

                <button type="submit" class="mt-1 inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 font-semibold text-white transition hover:bg-info">Create account</button>
            </form>
        </div>
    </div>
</x-app-layout>
