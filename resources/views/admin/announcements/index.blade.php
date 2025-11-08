<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Manage Announcements</h2>
            <a href="{{ route('admin.announcements.create') }}" class="px-3 py-2 bg-sky-600 text-white rounded shadow hover:bg-sky-700">New Announcement</a>
        </div>
    </x-slot>

    <div class="py-8 bg-sky-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md border border-sky-200 bg-white px-4 py-2 text-sm text-sky-700 shadow">{{ session('status') }}</div>
            @endif

            <form method="GET" class="mb-4 flex flex-col sm:flex-row gap-3">
                <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Search title or body" class="rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500 w-full sm:w-auto flex-1">
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-sky-600 text-white rounded shadow hover:bg-sky-700" type="submit">Search</button>
                    @if(!empty($search))
                        <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 border border-sky-200 text-sky-700 rounded hover:bg-sky-50">Clear</a>
                    @endif
                </div>
            </form>

            <div class="overflow-hidden rounded-xl bg-white shadow">
                <table class="min-w-full divide-y divide-sky-100">
                    <thead class="bg-sky-50">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-sky-700">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Published</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-100 text-sm text-gray-700">
                        @forelse($announcements as $announcement)
                            <tr class="hover:bg-sky-50/40">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $announcement->title }}</td>
                                <td class="px-4 py-3">{{ optional($announcement->published_at)->format('Y-m-d H:i') ?? '—' }}</td>
                                <td class="px-4 py-3 text-right space-x-3">
                                    <a href="{{ route('public.announcements.show', $announcement) }}" class="text-sky-600 hover:text-sky-700">View</a>
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-sky-600 hover:text-sky-700">Edit</a>
                                    <form class="inline" method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Delete this announcement?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-6 text-center text-gray-500" colspan="3">No announcements found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $announcements->links() }}</div>
        </div>
    </div>
</x-app-layout>
