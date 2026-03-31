@extends('layouts.app')

@section('title', 'About Us — Deepify')
@section('meta-desc', 'Learn about Deepify — a futuristic streetwear brand engineered for the next generation of style.')

@section('content')

{{-- Hero Section --}}
<section class="relative h-[70vh] md:h-screen flex items-center justify-center overflow-hidden bg-[var(--bg)]">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1544441893-675973e31985?w=1600&q=80" 
             alt="Deepify brand story" 
             class="w-full h-full object-cover opacity-30 grayscale"
             style="animation: subtle-zoom 30s ease-out forwards;">
        <div class="absolute inset-0 bg-gradient-to-t from-[var(--bg)] via-[var(--bg)]/80 to-transparent"></div>
    </div>

    <div class="relative z-10 text-center px-6" data-animate>
        <div class="flex justify-center mb-8">
            <div class="w-px h-20 bg-brand"></div>
        </div>
        <h1 class="font-headline text-6xl md:text-9xl font-black text-[var(--text)] tracking-tight leading-none capitalize"
            style="text-shadow: 0 0 60px var(--brand-glow);" data-i18n="about-us">
            About Us
        </h1>
    </div>

    <div class="absolute bottom-10 start-10 font-headline text-[10px] text-[var(--text-muted)] tracking-[0.4em] capitalize leading-relaxed hidden lg:block">
        EST. {{ date('Y') }}<br>Core Module: DEEPIFY_v1
    </div>
    <div class="absolute bottom-10 end-10 text-end font-headline text-[10px] text-[var(--text-muted)] tracking-[0.4em] capitalize leading-relaxed hidden lg:block">
        LAT: 30.0444° N<br>LNG: 31.2357° E
    </div>

    <style>
    @keyframes subtle-zoom {
        from { transform: scale(1); }
        to   { transform: scale(1.08); }
    }
    </style>
</section>

{{-- Mission Statement --}}
<section class="px-4 md:px-10 py-20 md:py-32 bg-[var(--bg)]">
    <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-16">
        <div class="md:col-span-5 space-y-8" data-animate>
            <h2 class="font-headline text-4xl md:text-6xl font-black capitalize text-[var(--text)] leading-[0.9] tracking-tight">
                PRECISION<br>
                <span class="text-brand">THROUGH</span><br>
                DESIGN
            </h2>
            <div class="w-24 h-0.5 bg-brand"></div>
        </div>
        <div class="md:col-span-7 md:col-start-6 space-y-8" data-animate>
            <blockquote class="text-lg md:text-2xl text-[var(--text)] leading-snug font-light italic border-s-2 border-brand ps-6">
                "We do not create clothes. We construct the uniform for the next stage of human evolution — functional, intentional, and built for those who live at the edge of the future."
            </blockquote>
            <p class="text-sm text-[var(--text-muted)] leading-relaxed">
                Founded by a collective of designers and technologists, Deepify rejects the noise of fashion to reveal the purity of form. Every garment is engineered, not decorated. Every thread has a purpose. We build for people who demand more from what they wear.
            </p>
            <div class="grid grid-cols-2 gap-8 pt-6 border-t border-[var(--border)]">
                <div>
                    <p class="font-headline text-[11px] text-brand tracking-widest capitalize mb-2">Focus</p>
                    <p class="text-[11px] capitalize text-[var(--text-muted)] tracking-wider leading-relaxed">Futuristic Streetwear<br>Technical Precision</p>
                </div>
                <div>
                    <p class="font-headline text-[11px] text-brand tracking-widest capitalize mb-2">Location</p>
                    <p class="text-[11px] capitalize text-[var(--text-muted)] tracking-wider">Cairo, Egypt<br>Global Operations</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="bg-[var(--bg-3)] border-y border-[var(--border)] px-4 md:px-10 py-16 md:py-24">
    <div class="max-w-screen-xl mx-auto">
        <div class="text-center mb-14" data-animate>
            <span class="text-[11px] text-brand font-label tracking-[0.5em] capitalize flex items-center justify-center gap-2 mb-3">
                <span class="w-1.5 h-1.5 bg-brand"></span> THE DEEPIFY PILLARS
            </span>
            <h2 class="font-headline text-3xl md:text-4xl font-black capitalize tracking-tight text-[var(--text)]" data-i18n="our-values">Our Values</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-[var(--border)]">
            @foreach([
                ['icon'=>'architecture','title'=>'PRECISION','color'=>'brand','desc'=>'Every seam is a calculated decision. Every fabric is chosen with purpose. We reject randomness and embrace the geometry of excellence.'],
                ['icon'=>'remove_red_eye','title'=>'VISION','color'=>'brand','desc'=>'We do not design for today. We engineer for the day after tomorrow — for people who see the future before it arrives.'],
                ['icon'=>'rocket_launch','title'=>'FUTURE','color'=>'brand','desc'=>'Deepify is not a brand. It is a trajectory. We are building the uniform for the next chapter of human aesthetic evolution.'],
            ] as $pillar)
            <div class="group bg-[var(--bg-2)] p-10 md:p-14 hover:bg-white dark:hover:bg-white transition-all duration-700 cursor-default" data-animate>
                <span class="material-symbols-outlined text-brand group-hover:text-black mb-10 text-3xl block transition-colors duration-700">{{ $pillar['icon'] }}</span>
                <h3 class="font-headline text-2xl font-bold text-[var(--text)] group-hover:text-black mb-6 capitalize tracking-widest transition-colors duration-700">{{ $pillar['title'] }}</h3>
                <p class="text-sm text-[var(--text-muted)] group-hover:text-black/60 leading-relaxed transition-colors duration-700">{{ $pillar['desc'] }}</p>
                <div class="mt-10 h-px w-0 group-hover:w-full bg-black transition-all duration-700"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="px-4 md:px-10 py-16 md:py-24 bg-[var(--bg)]">
    <div class="max-w-screen-xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-px bg-[var(--border)]" data-animate>
            @foreach([
                ['num'=>'50+','label'=>'Products'],
                ['num'=>'10K+','label'=>'Happy Customers'],
                ['num'=>'30+','label'=>'Countries'],
                ['num'=>date('Y'),'label'=>'Established'],
            ] as $stat)
            <div class="bg-[var(--bg-2)] p-8 md:p-12 text-center group hover:bg-brand transition-all duration-500">
                <p class="font-headline text-4xl md:text-5xl font-black text-brand group-hover:text-black tracking-tight mb-2 transition-colors">{{ $stat['num'] }}</p>
                <p class="text-[11px] font-label tracking-[0.35em] capitalize text-[var(--text-muted)] group-hover:text-black transition-colors">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="px-4 md:px-10 py-20 md:py-32 bg-[var(--bg-3)] border-t border-[var(--border)] text-center">
    <div class="max-w-2xl mx-auto" data-animate>
        <span class="text-[11px] text-brand font-label tracking-[0.5em] capitalize block mb-6">JOIN THE TRAJECTORY</span>
        <h2 class="font-headline text-3xl md:text-5xl font-black capitalize tracking-tight text-[var(--text)] mb-8">
            Ready to Wear the Future?
        </h2>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('products.index') }}"
               class="shimmer-btn bg-brand text-black font-label font-bold text-[11px] tracking-[0.35em] capitalize px-10 py-4 hover:bg-lime-400 transition-all duration-300"
               data-i18n="shop-now">Shop Now</a>
            <a href="{{ route('contact') }}"
               class="border border-[var(--border)] text-[var(--text)] font-label text-[11px] tracking-[0.35em] capitalize px-10 py-4 hover:border-brand hover:text-brand transition-all duration-300"
               data-i18n="contact-us">Contact Us</a>
        </div>
    </div>
</section>

@endsection
