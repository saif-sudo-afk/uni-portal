<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">New Announcement</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('professor.announcements.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="title" value="Title" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required/>
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="body" value="Body" />
                            <textarea id="body" name="body" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900" rows="6" required>{{ old('body') }}</textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>
                        <!-- published_at removed: announcement auto-publishes on create -->
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('professor.announcements.index') }}" class="px-3 py-2 border rounded">Cancel</a>
                            <x-primary-button>Create</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
