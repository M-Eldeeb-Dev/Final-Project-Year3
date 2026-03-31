@extends('layouts.app')

@section('title', 'Contact Us — Deepify')
@section('meta-desc', 'Get in touch with Deepify — we respond to all inquiries within 24 hours.')

@section('content')

<div class="bg-[var(--bg)] border-b border-[var(--border)] px-4 md:px-10 py-12 md:py-20 grid-bg">
    <div class="max-w-screen-xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-8 border-b border-[var(--border)] pb-12">
            <div>
                <span class="text-brand font-label text-[11px] tracking-[0.5em] capitalize flex items-center gap-3 mb-5">
                    <span class="w-8 h-px bg-brand"></span> Contact Channel
                </span>
                <h1 class="font-headline text-6xl md:text-[8rem] font-black tracking-tight text-[var(--text)] leading-none capitalize" data-i18n="contact-us">
                    Connect
                </h1>
            </div>
            <div class="max-w-xs mb-2">
                <p class="text-[11px] text-[var(--text-muted)] font-label leading-relaxed tracking-wider capitalize opacity-70">
                    Technical inquiries, collaborations, or product questions. We respond within 24 hours.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 md:px-10 py-10 md:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">

        <div class="lg:col-span-7">
            <div class="bg-[var(--bg-2)] border border-[var(--border)] p-8 md:p-14 relative">
                <div class="absolute top-0 start-0 w-2 h-2 bg-brand"></div>

                @if(session('success'))
                <div class="mb-8 p-4 bg-green-500/10 border border-green-500/30 text-green-400 text-sm font-label tracking-widest capitalize flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    {{ session('success') }}
                </div>
                @endif

                <form id="contact-form" action="{{ route('contact.send') }}" method="POST" class="space-y-10">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="group">
                            <label class="block font-label text-[11px] tracking-[0.3em] text-[var(--text-muted)] capitalize mb-3 group-focus-within:text-brand transition-colors" data-i18n="name">
                                Full Name
                            </label>
                            <input type="text" name="name" required
                                   class="dp-input @error('name') border-red-500 @enderror"
                                   placeholder="Full Name"
                                   value="{{ old('name') }}">
                            @error('name')<p class="text-red-400 text-[10px] mt-1.5">{{ $message }}</p>@enderror
                        </div>

                        <div class="group">
                            <label class="block font-label text-[11px] tracking-[0.3em] text-[var(--text-muted)] capitalize mb-3 group-focus-within:text-brand transition-colors" data-i18n="email">
                                Email Address
                            </label>
                            <input type="email" name="email" required
                                   class="dp-input @error('email') border-red-500 @enderror"
                                   placeholder="your@email.com"
                                   value="{{ old('email') }}">
                            @error('email')<p class="text-red-400 text-[10px] mt-1.5">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="group">
                        <label class="block font-label text-[11px] tracking-[0.3em] text-[var(--text-muted)] capitalize mb-3 group-focus-within:text-brand transition-colors" data-i18n="subject">
                            Subject
                        </label>
                        <input type="text" name="subject" required
                               class="dp-input @error('subject') border-red-500 @enderror"
                               placeholder="Type of inquiry"
                               value="{{ old('subject') }}">
                        @error('subject')<p class="text-red-400 text-[10px] mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div class="group">
                        <label class="block font-label text-[11px] tracking-[0.3em] text-[var(--text-muted)] capitalize mb-3 group-focus-within:text-brand transition-colors" data-i18n="message">
                            Message
                        </label>
                        <textarea name="message" rows="5" required
                                  class="dp-input resize-none @error('message') border-red-500 @enderror"
                                  placeholder="Write your message here...">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-400 text-[10px] mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 pt-4">
                        <div class="space-y-1">
                            <span class="text-[10px] text-[var(--text-muted)] font-label tracking-[0.4em] block capitalize opacity-50">Location</span>
                            <span class="text-[11px] text-[var(--text)] font-label tracking-widest">Nasr City, Cairo, Egypt</span>
                        </div>
                        <button id="contact-submit-btn" type="submit"
                                class="shimmer-btn bg-brand text-black font-label font-bold text-[11px] tracking-[0.4em] capitalize px-14 py-5 hover:bg-lime-400 transition-all duration-300 active:scale-[0.98] w-full md:w-auto"
                                data-i18n="send">Send Message</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-5 flex flex-col gap-12">

            <div class="space-y-10">
                @foreach([
                    ['icon'=>'location_on','title'=>'Address','lines'=>['Nasr City, Cairo','Egypt']],
                    ['icon'=>'mail','title'=>'Email','lines'=>['ops@deepify.store','support@deepify.store']],
                    ['icon'=>'schedule','title'=>'Working Hours','lines'=>['Sunday – Thursday: 9am – 6pm ','Emergency: 24/7 via email']],
                ] as $info)
                <section data-animate>
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-1.5 h-1.5 bg-brand"></span>
                        <h3 class="font-headline text-[11px] tracking-[0.3em] text-[var(--text)] capitalize">{{ $info['title'] }}</h3>
                    </div>
                    <div class="space-y-1 ps-5">
                        @foreach($info['lines'] as $line)
                        <p class="text-[var(--text-muted)] text-sm tracking-wide">{{ $line }}</p>
                        @endforeach
                    </div>
                </section>
                @endforeach

                <section data-animate>
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-1.5 h-1.5 bg-brand"></span>
                        <h3 class="font-headline text-[11px] tracking-[0.3em] text-[var(--text)] capitalize">Social Media</h3>
                    </div>
                    <div class="ps-5 flex flex-wrap gap-5">
                        @foreach(['Instagram','X / Twitter','Discord','TikTok'] as $social)
                        <a href="#" class="font-label text-[11px] tracking-[0.3em] capitalize text-[var(--text-muted)] hover:text-brand border-b border-[var(--border)] hover:border-brand pb-1 transition-all">
                            {{ $social }}
                        </a>
                        @endforeach
                    </div>
                </section>
            </div>

            <div class="relative flex items-center justify-center p-10 border border-[var(--border)] overflow-hidden aspect-square bg-[var(--bg-2)] group" data-animate>
                <div class="absolute inset-0 grid-bg opacity-40"></div>
                <img src="{{ asset('assets/images/Deebify-full-logo-light.webp') }}" alt="Deepify Brand" class="relative z-10 w-full max-w-sm dark:hidden block opacity-80 group-hover:opacity-100 transition-opacity duration-500 hover:scale-105 transform">
                <img src="{{ asset('assets/images/Deebify-full-logo-dark.webp') }}" alt="Deepify Brand" class="relative z-10 w-full max-w-sm hidden dark:block opacity-80 group-hover:opacity-100 transition-opacity duration-500 hover:scale-105 transform">
            </div>
        </div>
    </div>
</div>

@endsection
