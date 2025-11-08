<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Admin Dashboard</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-md shadow hover:bg-sky-700">Manage Schedules</a>
                <a href="{{ route('admin.schedules.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-sky-700 border border-sky-200 rounded-md hover:bg-sky-50">Publish Schedule</a>
                <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-sky-700 border border-sky-200 rounded-md hover:bg-sky-50">Manage Announcements</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-sky-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="p-4 rounded-lg border border-sky-100 bg-white shadow-sm">
                    <div class="text-sm text-gray-500">Students</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['students'] }}</div>
                </div>
                <div class="p-4 rounded-lg border border-sky-100 bg-white shadow-sm">
                    <div class="text-sm text-gray-500">Professors</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['professors'] }}</div>
                </div>
                <div class="p-4 rounded-lg border border-sky-100 bg-white shadow-sm">
                    <div class="text-sm text-gray-500">Announcements</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['announcements'] }}</div>
                </div>
                <div class="p-4 rounded-lg border border-sky-100 bg-white shadow-sm">
                    <div class="text-sm text-gray-500">Uploads</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['uploads'] }}</div>
                </div>
                <div class="p-4 rounded-lg border border-sky-100 bg-white shadow-sm">
                    <div class="text-sm text-gray-500">Schedules</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['schedules'] }}</div>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <section class="rounded-xl border border-sky-100 bg-white shadow-sm p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Recent Schedules</h3>
                    <div class="space-y-3">
                        @forelse($recentSchedules as $schedule)
                            <article class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $schedule->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $schedule->semester }} &middot; {{ $schedule->major }}</div>
                                </div>
                                <a class="text-sm font-medium text-sky-600 hover:text-sky-700" href="{{ route('admin.schedules.edit', $schedule) }}">Review</a>
                            </article>
                        @empty
                            <div class="text-gray-500">No schedules yet.</div>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-xl border border-sky-100 bg-white shadow-sm p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Recent Announcements</h3>
                    <div class="space-y-3">
                        @forelse($recentAnnouncements as $announcement)
                            <article>
                                <div class="font-medium text-gray-900">{{ $announcement->title }}</div>
                                <div class="text-xs text-gray-500">{{ optional($announcement->published_at)->format('Y-m-d H:i') }}</div>
                            </article>
                        @empty
                            <div class="text-gray-500">No announcements yet.</div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>



