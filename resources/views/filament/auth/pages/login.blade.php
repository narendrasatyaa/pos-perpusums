<div class="min-h-screen grid place-items-center p-4 sm:p-6 lg:p-8">
    <div class="w-full max-w-6xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl">
        <div class="grid md:grid-cols-[1.15fr_0.85fr]">
            <section class="relative min-h-[280px] border-b border-slate-200 bg-[#ece5f7] md:min-h-[760px] md:border-b-0 md:border-r">
                <img src="{{ asset('img/img-login-regis.webp') }}" alt="foto perpus" class="absolute inset-0 h-full w-full object-cover object-top">
                <div class="absolute inset-0 bg-gradient-to-b from-[#ece5f7]/35 via-transparent to-[#ece5f7]/20"></div>
            </section>

            <section class="px-6 py-8 sm:px-10 md:px-12 md:py-12">
                <div class="mx-auto flex w-full max-w-md flex-col">
                    <img src="{{ asset('img/logo-footer.webp') }}" alt="Logo perpus" class="mx-auto h-10 w-auto">

                    <div class="mt-10">
                        {{ $this->content }}
                    </div>

                    <div class="mt-8 flex justify-center">
                        <img src="{{ asset('img/sosmed-hitam.webp') }}" alt="footer" class="h-auto w-full max-w-sm md:max-w-md">
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>