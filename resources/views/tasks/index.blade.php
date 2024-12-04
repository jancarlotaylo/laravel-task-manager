@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-6">Task List</h1>

        <div class="flex justify-between items-center mb-6">
            <!-- Welcome message -->
            <p>Welcome, {{ Auth::user()->name }}!</p>

            <!-- Buttons container -->
            <div class="space-x-4">
                <!-- Button to add new task -->
                <a href="{{ route('tasks.add') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block">Add New Task</a>

                <!-- Logout button -->
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</button>
                </form>
            </div>
        </div>

        <!-- Search and Status Filter Form -->
        <form action="{{ route('tasks.index') }}" method="GET" class="flex items-center space-x-4 mb-4">
            <!-- Search by Title -->
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Title..." class="p-2 border rounded w-1/4" />

            <!-- Status Filter Dropdown -->
            <select name="status" class="p-2 border rounded w-1/4">
                <option value="">All Statuses</option>
                @foreach($taskStatuses as $status)
                    <option value="{{ $status['value'] }}" {{ request('status') == $status['value'] ? 'selected' : '' }}>
                        {{ $status['label'] }}
                    </option>
                @endforeach
            </select>

            <!-- Search Button -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
        </form>

        <!-- Table to display tasks -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500">ID</th>

                        <!-- Title Column with Sorting -->
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500 hover:bg-gray-200">
                            <a href="{{ route('tasks.index', ['sort' => 'title', 'direction' => request('sort') === 'title' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                            class="hover:text-blue-600 hover:underline">
                                Title
                                @if(request('sort') == 'title')
                                    @if(request('direction') == 'asc')
                                        &#9650; <!-- Upward Triangle Arrow for Ascending -->
                                    @else
                                        &#9660; <!-- Downward Triangle Arrow for Descending -->
                                    @endif
                                @endif
                            </a>
                        </th>

                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500">Status</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500">Publication</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500">Date Published</th>

                        <!-- Date Created Column with Sorting -->
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500 hover:bg-gray-200">
                            <a href="{{ route('tasks.index', ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                            class="hover:text-blue-600 hover:underline">
                                Date Created
                                @if(request('sort') == 'created_at')
                                    @if(request('direction') == 'asc')
                                        &#9650; <!-- Upward Triangle Arrow for Ascending -->
                                    @else
                                        &#9660; <!-- Downward Triangle Arrow for Descending -->
                                    @endif
                                @endif
                            </a>
                        </th>

                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr class="border-t">
                            <td class="py-3 px-6 text-sm font-medium text-gray-900">{{ $task->id }}</td>
                            <td class="py-3 px-6 text-sm font-medium text-gray-900">{{ $task->title }}</td>
                            <td class="py-3 px-6 text-sm text-center">
                                <span class="px-2 py-1 text-xs font-semibold text-white rounded-full {{ $task->status->color() }}">
                                    {{ $task->status->label() }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-sm text-center">
                                <span class="px-2 py-1 text-xs font-semibold text-white rounded-full {{ $task->publication === 'published' ? 'bg-green-500' : 'bg-gray-400' }}">
                                    {{ $task->publication }}
                                </span>
                            </td>
                            <td>{{ $task->published_at ? $task->published_at->format('Y-m-d H:i:s') : '' }}</td>
                            <td class="py-3 px-6 text-sm text-gray-600">{{ $task->created_at->format('Y-m-d h:i:s A') }}</td>
                            <td class="py-3 px-6 text-sm">
                                <a href="{{ route('tasks.show', $task) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-2">View</a>
                                <a href="{{ route('tasks.edit', $task) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 mr-2">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Dropdown to select number of records per page -->
        <div class="mb-4 mt-4">
            <form action="{{ route('tasks.index') }}" method="GET" class="flex items-center space-x-4">
                <label for="limit" class="text-sm text-gray-700">Records per page:</label>
                <select name="limit" id="limit" class="p-2 border rounded">
                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Apply</button>

                <!-- Reset Button -->
                <a href="{{ route('tasks.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    Reset
                </a>
            </form>
        </div>

        <!-- Pagination links -->
        <div class="mt-6 flex justify-center">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection