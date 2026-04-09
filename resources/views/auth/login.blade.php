<x-app-layout :title="'Login'">
    <div class="min-h-screen grid place-items-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-6xl rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden">
            <div class="grid md:grid-cols-[1.15fr_0.85fr]">
                <section
                    class="relative min-h-[280px] md:min-h-[760px] border-b md:border-b-0 md:border-r border-slate-200 bg-[#ece5f7]">
                    <img src="{{ asset('img/img-login-regis.webp') }}" alt="foto perpus"
                        class="absolute inset-0 h-full w-full object-cover object-top">
                    <div class="absolute inset-0 bg-gradient-to-b from-[#ece5f7]/35 via-transparent to-[#ece5f7]/20">
                    </div>
                </section>

                <section class="px-6 py-8 sm:px-10 md:px-12 md:py-12">
                    <div class="mx-auto w-full max-w-md">
                        <img src="{{ asset('img/logo-footer.webp') }}" alt="Logo perpus" class="mx-auto h-10 w-auto">

                        <h1 class="mt-10 text-4xl font-semibold tracking-tight text-slate-900">Login</h1>
                        <p class="mt-2 text-sm text-slate-500">Masukkan kredensial Anda untuk akses sistem</p>

                        @if ($errors->any())
                            <div class="mt-5 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ $loginAction ?? route('login.store') }}" class="mt-7 grid gap-5">
                            @csrf
                            <div>
                                <label for="email"
                                    class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                                <input id="email" name="email" type="email" required autofocus
                                    value="{{ old('email') }}"
                                    class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 placeholder-slate-400 focus:border-primary focus:bg-white focus:ring-primary"
                                    placeholder="upt@ums.ac.id">
                            </div>

                            <div>
                                <label for="password"
                                    class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                                <input id="password" name="password" type="password" required
                                    class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 placeholder-slate-400 focus:border-primary focus:bg-white focus:ring-primary"
                                    placeholder="••••••••">
                            </div>

                            <div class="flex items-center justify-between gap-3 text-sm">
                                <label class="inline-flex items-center gap-2 text-slate-600">
                                    <input type="checkbox" name="remember"
                                        class="rounded border-slate-300 text-primary focus:ring-primary">
                                    Remember me
                                </label>
                                {{-- <a href="{{ route('register') }}" class="font-medium text-primary hover:text-primary/80">Get Yours Now</a> --}}
                            </div>
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-3 font-semibold text-slate-700 transition-all duration-200 ease-in-out hover:border-slate-400 hover:bg-slate-50">
                                <span>Masuk</span>
                                <i class="fas fa-arrow-right text-sm"></i>
                            </button>

                            <div class="relative my-1">
                                <div class="absolute inset-0 flex items-center">
                                    <span class="w-full border-t border-slate-200"></span>
                                </div>
                                <div class="relative flex justify-center text-xs uppercase">
                                    <span class="bg-white px-2 text-slate-400">atau</span>
                                </div>
                            </div>

                            <button type="button"
                                class="w-full flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-3 font-semibold text-slate-700 transition-all duration-200 ease-in-out hover:border-slate-400 hover:bg-slate-50">
                                <i class="fa-brands fa-google text-base"></i>
                                <span>Login with Google</span>
                            </button>

                            <div class="mt-8 flex justify-center">
                                <img src="{{ asset('img/sosmed-hitam.webp') }}" alt="footer" class="w-full max-w-sm md:max-w-md h-auto">
                            </div>
                            </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
