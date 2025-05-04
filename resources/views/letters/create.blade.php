@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Create Letter</h1>
                        <p class="text-gray-600 mt-1">Create a new official document</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('admin.letters.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Letters
                        </a>
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                This feature is currently under development. You can create a letter, but it will not be saved.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.letters.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Letter Title</label>
                            <input type="text" name="title" id="title" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Enter letter title" required>
                        </div>

                        <div>
                            <label for="letter_type" class="block text-sm font-medium text-gray-700 mb-1">Letter Type</label>
                            <select id="letter_type" name="letter_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="Official">Official</option>
                                <option value="Memo">Memo</option>
                                <option value="Invitation">Invitation</option>
                                <option value="Request">Request</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="recipient" class="block text-sm font-medium text-gray-700 mb-1">Recipient</label>
                            <input type="text" name="recipient" id="recipient" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Enter recipient name or organization">
                        </div>

                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                            <select id="purpose" name="purpose" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="Calendar of Activities">Calendar of Activities</option>
                                <option value="Request/Proposal">Request/Proposal</option>
                                <option value="Financial Statement">Financial Statement</option>
                                <option value="Post-Activity Report">Post-Activity Report</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="draft">Draft</option>
                                <option value="finished">Finished</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8">
                        <label for="editor-container" class="block text-sm font-medium text-gray-700 mb-2">Letter Content</label>
                        <div id="editor-container" class="min-h-[400px] border border-gray-300 rounded-lg"></div>
                        <input type="hidden" name="content" id="content">
                    </div>

                    <div class="flex justify-end space-x-3 mt-8">
                        <a href="{{ route('admin.letters.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                            <i class="fas fa-save mr-2"></i> Save Letter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize form submission
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show success message
            alert('This feature is currently under development. The letter would be created here.');

            // Redirect back to index
            window.location.href = "{{ route('admin.letters.index') }}";
        });
    });
</script>
@endsection
