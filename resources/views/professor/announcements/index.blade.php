<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Announcements
            </h2>
            <a href="{{ route('professor.announcements.create') }}" class="px-3 py-2 bg-sky-600 text-white rounded">New</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 text-green-700 bg-green-100 dark:bg-green-900/30 px-4 py-2 rounded">{{ session('status') }}</div>
            @endif

            <form method="GET" class="mb-4 flex gap-2">
                <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Search announcements..." class="w-full rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                <button class="px-4 py-2 bg-sky-600 text-white rounded" type="submit">Search</button>
                @if(!empty($search))
                    <a href="{{ route('professor.announcements.index') }}" class="px-4 py-2 border rounded">Clear</a>
                @endif
            </form>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium">Title</th>
                            <th class="px-4 py-2 text-left text-xs font-medium">Published</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($announcements as $a)
                            <tr>
                                <td class="px-4 py-2">{{ $a->title }}</td>
                                <td class="px-4 py-2">{{ optional($a->published_at)->format('Y-m-d H:i') ?? '-' }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a class="text-sky-600" href="{{ route('professor.announcements.edit', $a) }}">Edit</a>
                                    <form class="inline" method="POST" action="{{ route('professor.announcements.destroy', $a) }}" onsubmit="return confirm('Delete this announcement?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-6" colspan="3">No announcements yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $announcements->links() }}</div>
        </div>
    </div>
</x-app-layout>
