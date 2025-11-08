<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Manage Schedules</h2>
            <a href="{{ route('admin.schedules.create') }}" class="px-3 py-2 bg-sky-600 text-white rounded shadow hover:bg-sky-700">New Schedule</a>
        </div>
    </x-slot>

    <div class="py-8 bg-sky-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md border border-sky-200 bg-white px-4 py-2 text-sm text-sky-700 shadow">{{ session('status') }}</div>
            @endif

            <form method="GET" class="mb-4 grid grid-cols-1 sm:grid-cols-4 gap-3">
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
                    <button class="px-4 py-2 bg-sky-600 text-white rounded shadow hover:bg-sky-700" type="submit">Filter</button>
                    @if(!empty($search) || !empty($semester) || !empty($major))
                        <a href="{{ route('admin.schedules.index') }}" class="px-4 py-2 rounded border border-sky-200 text-sky-700 hover:bg-sky-50">Clear</a>
                    @endif
                </div>
            </form>

            <div class="overflow-hidden rounded-xl bg-white shadow">
                <table class="min-w-full divide-y divide-sky-100">
                    <thead class="bg-sky-50">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-sky-700">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Semester</th>
                            <th class="px-4 py-3">Major</th>
                            <th class="px-4 py-3">Owner</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-100 text-sm text-gray-700">
                        @forelse($schedules as $schedule)
                            <tr class="hover:bg-sky-50/40">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $schedule->title }}</td>
                                <td class="px-4 py-3">{{ $schedule->semester }}</td>
                                <td class="px-4 py-3">{{ $schedule->major }}</td>
                                <td class="px-4 py-3">{{ $schedule->user->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-right space-x-3">
                                    <a class="text-sky-600 hover:text-sky-700" href="{{ Storage::disk('public')->url($schedule->file_path) }}" target="_blank">View</a>
                                    <a class="text-sky-600 hover:text-sky-700" href="{{ route('admin.schedules.edit', $schedule) }}">Edit</a>
                                    <form class="inline" method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" onsubmit="return confirm('Delete this schedule?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-6 text-center text-gray-500" colspan="5">No schedules found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $schedules->links() }}</div>
        </div>
    </div>
</x-app-layout>
