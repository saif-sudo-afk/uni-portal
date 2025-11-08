<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">New Announcement</h2>
    </x-slot>

    <div class="py-8 bg-sky-50/40">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl bg-white shadow p-6">
                <form method="POST" action="{{ route('admin.announcements.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="body" value="Body" />
                        <textarea id="body" name="body" rows="6" class="mt-1 block w-full rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500" required>{{ old('body') }}</textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="published_at" value="Publish At (optional)" />
                        <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1 block w-full" value="{{ old('published_at') }}" />
                        <p class="mt-1 text-xs text-gray-500">Leave empty to publish immediately.</p>
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.announcements.index') }}" class="px-3 py-2 border border-sky-200 text-sky-700 rounded hover:bg-sky-50">Cancel</a>
                        <x-primary-button>Save</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
