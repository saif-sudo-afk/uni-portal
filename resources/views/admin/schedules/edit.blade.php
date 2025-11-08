<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Edit Schedule</h2>
    </x-slot>

    <div class="py-8 bg-sky-50/40">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl bg-white shadow p-6">
                <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="owner_id" value="Owner" />
                        <select id="owner_id" name="owner_id" class="mt-1 block w-full rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500" required>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" @selected(old('owner_id', $schedule->user_id) == $owner->id)>{{ $owner->name }} ({{ ucfirst($owner->role) }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('owner_id')" class="mt-2" />
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="semester" value="Semester" />
                            <x-text-input id="semester" name="semester" type="text" class="mt-1 block w-full" value="{{ old('semester', $schedule->semester) }}" required />
                            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="major" value="Major" />
                            <x-text-input id="major" name="major" type="text" class="mt-1 block w-full" value="{{ old('major', $schedule->major) }}" required />
                            <x-input-error :messages="$errors->get('major')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title', $schedule->title) }}" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500">{{ old('description', $schedule->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label value="Current File" />
                        <a class="text-sky-600 hover:underline" href="{{ Storage::disk('public')->url($schedule->file_path) }}" target="_blank">{{ $schedule->original_name }}</a>
                    </div>
                    <div>
                        <x-input-label for="file" value="Replace File" />
                        <input id="file" name="file" type="file" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    </div>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.schedules.index') }}" class="px-3 py-2 border border-sky-200 text-sky-700 rounded hover:bg-sky-50">Cancel</a>
                        <x-primary-button>Update</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
