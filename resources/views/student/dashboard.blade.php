<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Student Dashboard</h2>
    </x-slot>

    <div class="py-12 bg-sky-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl bg-white shadow">
                <div class="border-b border-sky-100 bg-sky-50 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="text-gray-900 font-semibold">
                        Welcome, {{ auth()->user()->name }} (Student)
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('schedule.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-sky-700 border border-sky-200 rounded-md hover:bg-white transition">View Schedule</a>
                        <a href="{{ route('student.uploads.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-md shadow hover:bg-sky-700 transition">Go to Downloads</a>
                    </div>
                </div>

                <div class="px-6 py-6 space-y-8">
                    <section>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Latest Announcements</h3>
                        <div class="space-y-3">
                            @forelse($announcements as $a)
                                <article class="p-4 rounded-lg border border-sky-100 bg-white/80">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <div class="font-semibold text-gray-900">{{ $a->title }}</div>
                                        <div class="text-sm text-gray-500">{{ optional($a->published_at)->format('Y-m-d H:i') }}</div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($a->body, 140) }}</p>
                                    <div class="mt-3">
                                        <a href="{{ route('public.announcements.show', $a) }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View Details</a>
                                    </div>
                                </article>
                            @empty
                                <p class="text-gray-500">No announcements yet.</p>
                            @endforelse
                        </div>
                    </section>

                    <section>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Recent Files</h3>
                        <div class="space-y-2">
                            @forelse(($recentUploads ?? []) as $u)
                                <article class="p-4 rounded-lg border border-sky-100 bg-white/80 flex items-center justify-between">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $u->original_name }}</div>
                                        <div class="text-xs text-gray-500">{{ number_format($u->size/1024,1) }} KB</div>
                                    </div>
                                    <a class="text-sm font-medium text-sky-600 hover:text-sky-700" href="{{ route('student.uploads.download', $u) }}">Download</a>
                                </article>
                            @empty
                                <div class="text-gray-500">No files yet.</div>
                            @endforelse
                        </div>
                    </section>

                    <section>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                            <h3 class="text-lg font-semibold text-gray-900">Class Schedules</h3>
                            <a href="{{ route('schedule.index') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-900">Open schedule page &rarr;</a>
                        </div>
                        <div class="space-y-2">
                            @forelse(($latestSchedules ?? []) as $schedule)
                                <article class="p-4 rounded-lg border border-sky-100 bg-white/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $schedule->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $schedule->semester }} &middot; {{ $schedule->major }}</div>
                                    </div>
                                    <a class="inline-flex items-center px-3 py-2 text-sm font-medium text-sky-700 border border-sky-200 rounded-md hover:bg-sky-50 transition" href="{{ route('schedule.download', $schedule) }}">
                                        Download
                                    </a>
                                </article>
                            @empty
                                <div class="text-gray-500">Schedules will appear here once published.</div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

