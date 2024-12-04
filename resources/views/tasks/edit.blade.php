@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-6">Edit Task #{{ $task->id }}</h1>
        
        <form id="task-form" action="{{ route('tasks.update', $task) }}" method="POST">
            <!-- CSRF Token (if using Laravel) -->
            @csrf

            <!-- Task Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Task Title</label>
                <input type="text" id="title" name="title" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required value="{{ $task->title }}" />
            </div>

            <!-- Task Content -->
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Task Content</label>
                <textarea id="content" name="content" class="mt-1 p-2 w-full border border-gray-300 rounded-md" rows="4" required>{{ $task->content }}</textarea>
            </div>

            <!-- Task Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Task Status</label>
                <select id="status" name="status" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
                    @foreach ($taskStatuses as $status)
                        <option value="{{ $status['value'] }}" {{ $task->status->value === $status['value'] ? 'selected' : '' }}>
                            {{ $status['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Publish Toggle -->
            <div class="mb-4">
                <label for="published" class="block text-sm font-medium text-gray-700">Publish?</label>
                <div class="flex items-center space-x-4">
                    <!-- Toggle Switch -->
                    <label for="published-toggle" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" id="published-toggle" name="published" class="sr-only" 
                                value="1" {{ $task->published_at ? 'checked' : '' }} />
                            <div id="bg" class="block bg-gray-300 w-12 h-6 rounded-full"></div>
                            <div id="dot" class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all duration-300"></div>
                        </div>
                    </label>
                    <span id="publication_label">Draft</span>
                </div>
            </div>

            <div class="mt-4 flex gap-4">
                <!-- Submit Button -->
                <button type="submit" class="w-1/2 bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Update</button>
                <!-- Edit Button -->
                <button id="cancel" type="button" class="w-1/2 bg-gray-400 text-white py-2 rounded-md hover:bg-blue-600">Cancel</button>
            </div>

            <input type="hidden" id="user_id" name="user_id" value="{{ auth()->id() }}" />
            <input type="hidden" id="task_id" name="task_id" value="{{ $task->id }}" />
            <input type="hidden" id="published_at" name="published_at" value="{{ $task->published_at ? $task->published_at : '' }}">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/task-edit.js') }}"></script>
@endsection