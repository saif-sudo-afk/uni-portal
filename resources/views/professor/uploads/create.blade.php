<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">New Upload</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('professor.uploads.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="file" value="File" />
                            <input id="file" name="file" type="file" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('professor.uploads.index') }}" class="px-3 py-2 border rounded">Cancel</a>
                            <x-primary-button>Upload</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
