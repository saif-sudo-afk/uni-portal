<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Professor Dashboard</h2>
    </x-slot>

    <div class="py-12 bg-sky-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl bg-white shadow">
                <div class="border-b border-sky-100 bg-sky-50 px-6 py-4 text-gray-900 font-semibold">
                    Welcome, {{ auth()->user()->name }} (Professor)
                </div>

                <div class="px-6 py-6 space-y-8">
                    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                        <div class="p-4 rounded-lg border border-sky-100 bg-white/90">
                            <div class="text-sm text-gray-500">Announcements</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['announcements'] ?? 0 }}</div>
                        </div>
                        <div class="p-4 rounded-lg border border-sky-100 bg-white/90">
                            <div class="text-sm text-gray-500">Uploads</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['uploads'] ?? 0 }}</div>
                        </div>
                        <div class="p-4 rounded-lg border border-sky-100 bg-white/90">
                            <div class="text-sm text-gray-500">Schedules</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['schedules'] ?? 0 }}</div>
                            <a href="{{ route('professor.schedules.index') }}" class="mt-3 inline-flex items-center text-sm font-medium text-sky-700 hover:text-sky-900">Manage schedules &rarr;</a>
                        </div>
                        <div class="p-4 rounded-lg border border-sky-100 bg-white/90">
                            <div class="text-sm text-gray-500">Quick Action</div>
                            <a href="{{ route('professor.announcements.create') }}" class="mt-3 inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-sky-600 rounded-md shadow hover:bg-sky-700 transition">New Announcement</a>
                        </div>
                        <div class="p-4 rounded-lg border border-sky-100 bg-white/90">
                            <div class="text-sm text-gray-500">Quick Action</div>
                            <a href="{{ route('professor.uploads.create') }}" class="mt-3 inline-flex items-center px-3 py-2 text-sm font-medium text-sky-700 border border-sky-200 rounded-md hover:bg-sky-50 transition">New Upload</a>
                        </div>
                        <div class="p-4 rounded-lg border border-sky-100 bg-white/90">
                            <div class="text-sm text-gray-500">Quick Action</div>
                            <a href="{{ route('professor.schedules.create') }}" class="mt-3 inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-sky-600 rounded-md shadow hover:bg-sky-700 transition">Upload Schedule</a>
                        </div>
                    </section>

                    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="rounded-lg border border-sky-100 bg-white/90 p-5">
                            <h3 class="font-semibold text-gray-900 mb-3">Recent Announcements</h3>
                            <div class="space-y-2">
                                @forelse($recentAnnouncements ?? [] as $a)
                                    <article class="p-3 rounded border border-sky-100 bg-white flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $a->title }}</div>
                                            <div class="text-xs text-gray-500">{{ optional($a->published_at)->format('Y-m-d H:i') }}</div>
                                        </div>
                                        <a class="text-sm font-medium text-sky-600 hover:text-sky-700" href="{{ route('professor.announcements.edit', $a) }}">Edit</a>
                                    </article>
                                @empty
                                    <div class="text-gray-500">No announcements yet.</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="rounded-lg border border-sky-100 bg-white/90 p-5">
                            <h3 class="font-semibold text-gray-900 mb-3">Recent Uploads</h3>
                            <div class="space-y-2">
                                @forelse($recentUploads ?? [] as $u)
                                    <article class="p-3 rounded border border-sky-100 bg-white flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $u->original_name }}</div>
                                            <div class="text-xs text-gray-500">{{ number_format($u->size/1024,1) }} KB</div>
                                        </div>
                                        <form method="POST" action="{{ route('professor.uploads.destroy', $u) }}" onsubmit="return confirm('Delete file?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm font-medium text-red-600 hover:text-red-700">Delete</button>
                                        </form>
                                    </article>
                                @empty
                                    <div class="text-gray-500">No uploads yet.</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="rounded-lg border border-sky-100 bg-white/90 p-5">
                            <h3 class="font-semibold text-gray-900 mb-3">Recent Schedules</h3>
                            <div class="space-y-2">
                                @forelse($recentSchedules ?? [] as $schedule)
                                    <article class="p-3 rounded border border-sky-100 bg-white flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $schedule->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $schedule->semester }} &middot; {{ $schedule->major }}</div>
                                        </div>
                                        <a class="text-sm font-medium text-sky-600 hover:text-sky-700" href="{{ route('professor.schedules.edit', $schedule) }}">Edit</a>
                                    </article>
                                @empty
                                    <div class="text-gray-500">No schedules yet.</div>
                                @endforelse
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('professor.schedules.index') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-900">Go to schedule manager &rarr;</a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
