<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Edit Announcement</h2>
    </x-slot>

    <div class="py-8 bg-sky-50/40">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl bg-white shadow p-6">
                <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title', $announcement->title) }}" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="body" value="Body" />
                        <textarea id="body" name="body" rows="6" class="mt-1 block w-full rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500" required>{{ old('body', $announcement->body) }}</textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="published_at" value="Publish At" />
                        <x-text-input
                            id="published_at"
                            name="published_at"
                            type="datetime-local"
                            class="mt-1 block w-full"
                            value="{{ old('published_at', optional($announcement->published_at)->format('Y-m-d\TH:i')) }}"
                        />
                        <p class="mt-1 text-xs text-gray-500">Update the publish time or leave as-is to keep the current value.</p>
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('admin.announcements.index') }}" class="text-sm text-sky-700 hover:text-sky-800">Back to announcements</a>
                        <div class="flex gap-2">
                            <button form="delete-announcement" class="px-3 py-2 border border-red-200 text-red-600 rounded hover:bg-red-50" type="submit">Delete</button>
                            <x-primary-button>Update</x-primary-button>
                        </div>
                    </div>
                </form>

                <form id="delete-announcement" method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Delete this announcement?')">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
