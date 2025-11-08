@php
    $normalizedFeatures = collect($features ?? [])->map(function ($feature) {
        return [
            'title' => trim($feature['title'] ?? ''),
            'description' => trim($feature['desc'] ?? ($feature['description'] ?? '')),
        ];
    })->filter(fn ($feature) => $feature['title'] || $feature['description'])->values();

    $announcementCards = collect($latest_announcements ?? [])->map(function ($announcement) {
        return [
            'title' => $announcement->title,
            'published_at' => optional($announcement->published_at)->format('M j, Y'),
            'url' => route('public.announcements.show', $announcement),
        ];
    });
@endphp

<x-guest-layout :mono="false">
    <div class="bg-white text-slate-900">
        <header class="border-b border-slate-100 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-4 px-4 py-4 sm:flex-nowrap">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight text-slate-900">
                    {{ config('app.name', 'UNI-Portale') }}
                </a>

                <nav class="flex flex-1 items-center gap-6 text-sm font-medium text-slate-600">
                    <a href="#features" class="transition hover:text-slate-900">Features</a>
                    <a href="#announcements" class="transition hover:text-slate-900">Announcements</a>
                    <a href="#contact" class="transition hover:text-slate-900">Contact</a>
                </nav>

                @if (Route::has('login'))
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                           class="rounded-full border border-sky-200 px-4 py-2 text-sm font-semibold text-sky-700 transition hover:border-sky-300 hover:text-sky-900">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="rounded-full bg-sky-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-600">
                                Register
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </header>

        <main>
            <section class="bg-gradient-to-b from-sky-50 via-white to-white">
                <div class="mx-auto flex max-w-6xl flex-col items-center gap-10 px-4 py-16 text-center lg:flex-row lg:text-left">
                    <div class="flex-1 space-y-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">University Portal</p>
                        <h1 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
                            {{ $hero_title }}
                        </h1>
                        <p class="text-lg leading-relaxed text-slate-600">
                            {{ $hero_subtitle }}
                        </p>
                        <div class="flex flex-wrap items-center justify-center gap-4 lg:justify-start">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="rounded-full bg-sky-500 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-sky-200 transition hover:bg-sky-600">
                                    Create an account
                                </a>
                            @endif
                            <a href="{{ route('login') }}"
                               class="rounded-full border border-sky-200 px-6 py-3 text-base font-semibold text-sky-700 transition hover:border-sky-300 hover:text-sky-900">
                                Log in
                            </a>
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="rounded-3xl border border-sky-100 bg-white p-6 shadow-xl shadow-sky-100/60">
                            <p class="text-sm font-semibold uppercase tracking-wide text-sky-600">Today’s snapshot</p>
                            <div class="mt-6 grid grid-cols-2 gap-6 text-left">
                                <div>
                                    <p class="text-4xl font-semibold text-slate-900">{{ $announcementCards->count() }}</p>
                                    <p class="text-sm text-slate-500">Latest announcements</p>
                                </div>
                                <div>
                                    <p class="text-4xl font-semibold text-slate-900">{{ $normalizedFeatures->count() }}</p>
                                    <p class="text-sm text-slate-500">Key features</p>
                                </div>
                                <div>
                                    <p class="text-4xl font-semibold text-slate-900">24/7</p>
                                    <p class="text-sm text-slate-500">Anytime access</p>
                                </div>
                                <div>
                                    <p class="text-4xl font-semibold text-slate-900">100%</p>
                                    <p class="text-sm text-slate-500">Role-based</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="features" class="border-t border-slate-100 bg-white py-16">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="max-w-3xl space-y-4 text-center sm:text-left">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Features</p>
                        <h2 class="text-3xl font-semibold text-slate-900">Everything you need, none of the clutter</h2>
                        <p class="text-base text-slate-600">
                            Clear modules for students and professors, real-time communication, and quick access to resources.
                        </p>
                    </div>

                    <div class="mt-12 grid gap-8 md:grid-cols-3">
                        @forelse ($normalizedFeatures as $feature)
                            <div class="rounded-2xl border border-slate-100 bg-sky-50/40 p-6 shadow-sm shadow-sky-100/40">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $feature['title'] }}</h3>
                                <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $feature['description'] }}</p>
                            </div>
                        @empty
                            <p class="text-slate-500">Feature highlights will appear here once they are configured.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="announcements" class="bg-sky-50 py-16">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Announcements</p>
                            <h2 class="text-3xl font-semibold text-slate-900">Stay updated without digging around</h2>
                        </div>
                        <a href="{{ route('schedule.index') }}"
                           class="text-sm font-semibold text-sky-700 underline-offset-4 hover:underline">
                            View class schedule
                        </a>
                    </div>

                    <div class="mt-10 grid gap-6 md:grid-cols-3">
                        @forelse ($announcementCards as $announcement)
                            <a href="{{ $announcement['url'] }}"
                               class="group rounded-2xl border border-sky-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                <p class="text-xs uppercase tracking-wide text-sky-600">{{ $announcement['published_at'] ?? 'Draft' }}</p>
                                <h3 class="mt-3 text-lg font-semibold text-slate-900 group-hover:text-sky-700">
                                    {{ $announcement['title'] }}
                                </h3>
                                <p class="mt-4 text-sm font-semibold text-sky-600">Read more &rarr;</p>
                            </a>
                        @empty
                            <div class="rounded-2xl border border-dashed border-sky-200 bg-white p-6 text-center text-slate-500">
                                No announcements have been published yet. Check back soon.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="contact" class="border-t border-slate-100 bg-white py-16">
                <div class="mx-auto max-w-4xl px-4 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Need help?</p>
                    <h2 class="mt-4 text-3xl font-semibold text-slate-900">We keep support simple</h2>
                    <p class="mt-4 text-base text-slate-600">
                        Questions about schedules, announcements, or onboarding new faculty? Reach out and we’ll respond quickly.
                    </p>
                    <a href="mailto:{{ $contact_email }}"
                       class="mt-8 inline-flex items-center justify-center rounded-full bg-sky-500 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-sky-200 transition hover:bg-sky-600">
                        {{ $contact_email }}
                    </a>
                </div>
            </section>
        </main>

        <footer class="border-t border-slate-100 bg-white py-6 text-center text-sm text-slate-500">
            © {{ now()->year }} {{ config('app.name', 'UNI-Portale') }} · Organized learning for admins, professors, and students.
        </footer>
    </div>
</x-guest-layout>
