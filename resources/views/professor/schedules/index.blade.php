<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Schedules</h2>
            <a href="{{ route('professor.schedules.create') }}" class="px-3 py-2 bg-sky-600 text-white rounded">New Schedule</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 text-green-700 bg-green-100 dark:bg-green-900/30 px-4 py-2 rounded">{{ session('status') }}</div>
            @endif

            <form method="GET" class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Search title or description" class="rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500">
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
                    @if(!empty($search) || !empty($semester) || !empty($major))
                        <a href="{{ route('professor.schedules.index') }}" class="px-4 py-2 border rounded">Clear</a>
                    @endif
                </div>
            </form>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium">Title</th>
                            <th class="px-4 py-2 text-left text-xs font-medium">Semester</th>
                            <th class="px-4 py-2 text-left text-xs font-medium">Major</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($schedules as $schedule)
                            <tr>
                                <td class="px-4 py-2">{{ $schedule->title }}</td>
                                <td class="px-4 py-2">{{ $schedule->semester }}</td>
                                <td class="px-4 py-2">{{ $schedule->major }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a class="text-sky-700" href="{{ Storage::disk('public')->url($schedule->file_path) }}" target="_blank">View</a>
                                    <a class="text-sky-700" href="{{ route('professor.schedules.edit', $schedule) }}">Edit</a>
                                    <form class="inline" method="POST" action="{{ route('professor.schedules.destroy', $schedule) }}" onsubmit="return confirm('Delete this schedule?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-6 text-center" colspan="4">No schedules yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $schedules->links() }}</div>
        </div>
    </div>
</x-app-layout>
