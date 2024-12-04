@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-6">View Task</h1>
        <div id="task-form">
            <!-- Task Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Task Title</label>
                <input type="text" id="title" name="title" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required disabled readonly value="{{ $task->title }}" />
            </div>

            <!-- Task Content -->
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Task Content</label>
                <textarea id="content" name="content" class="mt-1 p-2 w-full border border-gray-300 rounded-md" rows="4" required disabled readonly>{{ $task->content }}</textarea>
            </div>

            <!-- Task Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Task Status</label>
                <select id="status" name="status" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required disabled readonly>
                    <option value="#">{{ $task->status->label() }}</option>
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
                            <div id="bg" class="block {{ $task->published_at ? 'bg-green-500' : 'bg-gray-300' }} w-12 h-6 rounded-full"></div>
                            <div id="dot" class="dot absolute {{ $task->published_at ? '' : 'left-1' }} top-1 bg-white w-4 h-4 rounded-full transition-all duration-300" {{ $task->published_at ? " style='right: 0.25rem'" : '' }}></div>
                        </div>
                    </label>
                    <span id="publication_label">{{ $task->published_at ? 'Published' : 'Draft' }}</span>
                </div>
            </div>

            <div class="mt-4 flex gap-4">
                <!-- Back Button -->
                <button id="back" type="button" class="w-1/2 bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Back</button>
                <!-- Edit Button -->
                <button id="edit" type="button" class="w-1/2 bg-gray-400 text-white py-2 rounded-md hover:bg-blue-600">Edit</button>
            </div>

            <input type="hidden" id="task_id" name="task_id" value="{{ $task->id }}" />
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/task-view.js') }}"></script>
@endsection