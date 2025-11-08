<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Downloads</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" class="mb-4 flex gap-2">
                <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Search files..." class="w-full rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                <button class="px-4 py-2 bg-sky-600 text-white rounded" type="submit">Search</button>
                @if(!empty($search))
                    <a href="{{ route('student.uploads.index') }}" class="px-4 py-2 border rounded">Clear</a>
                @endif
            </form>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium">File</th>
                            <th class="px-4 py-2 text-left text-xs font-medium">Size</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($uploads as $u)
                            <tr>
                                <td class="px-4 py-2">{{ $u->original_name }}</td>
                                <td class="px-4 py-2">{{ number_format($u->size / 1024, 1) }} KB</td>
                                <td class="px-4 py-2 text-right">
                                    <a class="text-sky-600" href="{{ route('student.uploads.download', $u) }}">Download</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="px-4 py-6" colspan="3">No files available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $uploads->links() }}</div>
        </div>
    </div>
</x-app-layout>
