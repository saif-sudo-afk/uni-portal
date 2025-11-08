<x-guest-layout :mono="false">
    <section class="py-12 px-6 lg:px-12 bg-white min-h-[70vh]">
        <div class="max-w-3xl">
            <a href="{{ url()->previous() }}" class="text-sky-700 hover:underline">&larr; Back</a>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">{{ $announcement->title }}</h1>
            <div class="mt-1 text-sm text-gray-500">Published: {{ optional($announcement->published_at)->format('Y-m-d H:i') }}</div>
            <div class="mt-6 prose max-w-none">
                {!! nl2br(e($announcement->body)) !!}
            </div>
        </div>
    </section>
</x-guest-layout>

