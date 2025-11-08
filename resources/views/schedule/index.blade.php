<x-guest-layout :mono="false">
    <div class="py-16 px-6 lg:px-12 bg-white min-h-[80vh]">
        <div class="max-w-6xl mx-auto">
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900">Class Schedules</h1>
                <p class="mt-2 text-gray-600">Select your semester and major to find the schedule you need.</p>
            </header>

            <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-8">
                <select name="semester" class="rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                    <option value="">All Semesters</option>
                    @foreach($semesters as $item)
                        <option value="{{ $item }}" @selected(($semester ?? '') === $item)>{{ $item }}</option>
                    @endforeach
                </select>
                <select name="major" class="rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                    <option value="">All Majors</option>
                    @foreach($majors as $item)
                        <option value="{{ $item }}" @selected(($major ?? '') === $item)>{{ $item }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-sky-600 text-white rounded" type="submit">Filter</button>
                    @if(!empty($semester) || !empty($major))
                        <a href="{{ route('schedule.index') }}" class="px-4 py-2 border rounded">Clear</a>
                    @endif
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($schedules as $schedule)
                    <div class="p-5 border border-slate-200 rounded-xl shadow-sm">
                        <div class="text-sm text-gray-500">{{ $schedule->semester }} &middot; {{ $schedule->major }}</div>
                        <h2 class="mt-2 text-lg font-semibold text-gray-900">{{ $schedule->title }}</h2>
                        @if($schedule->description)
                            <p class="mt-2 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($schedule->description, 120) }}</p>
                        @endif
                        <div class="mt-4 flex gap-3">
                            <a href="{{ route('schedule.view', $schedule) }}" target="_blank" class="px-3 py-2 bg-sky-600 text-white rounded">View</a>
                            <a href="{{ route('schedule.download', $schedule) }}" class="px-3 py-2 border rounded">Download</a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No schedules found for the selected filters.</p>
                @endforelse
            </div>

            <div class="mt-8">{{ $schedules->links() }}</div>
        </div>
    </div>
</x-guest-layout>
