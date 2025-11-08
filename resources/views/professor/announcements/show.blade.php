<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Announcement</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-4">
                <h1 class="text-2xl font-semibold">{{ $announcement->title }}</h1>
                <div class="text-sm text-gray-500">Published: {{ optional($announcement->published_at)->format('Y-m-d H:i') ?? '—' }}</div>
                <div class="prose dark:prose-invert max-w-none">{!! nl2br(e($announcement->body)) !!}</div>
            </div>
        </div>
    </div>
</x-app-layout>
