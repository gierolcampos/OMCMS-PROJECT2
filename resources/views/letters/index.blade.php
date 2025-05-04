@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Letters</h1>
                        <p class="text-gray-600 mt-1">Manage official correspondence and documents</p>
                    </div>
                    <div class="flex flex-wrap mt-4 md:mt-0 gap-3">
                        <a href="{{ route('admin.letters.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                            <i class="fas fa-plus mr-2"></i> Create Letter
                        </a>
                    </div>
                </div>

                <!-- Search and Filter -->
                <form action="{{ route('admin.letters.index') }}" method="GET" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-5">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="text" name="search" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-10 py-2 sm:text-sm border-gray-300 rounded-md" placeholder="Search by title or recipient...">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Statuses</option>
                                <option value="draft">Draft</option>
                                <option value="finished">Finished</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                            <select id="type" name="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Types</option>
                                <option value="coa">Calendar of Activities</option>
                                <option value="request">Request/Proposal</option>
                                <option value="financial">Financial Statement</option>
                                <option value="report">Post-Activity Report</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="md:col-span-3 flex items-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                <i class="fas fa-search mr-2"></i> Search
                            </button>
                            <a href="{{ route('admin.letters.index') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                                <i class="fas fa-times mr-2"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Letters Table -->
                <div class="overflow-x-auto border border-gray-200 rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <div class="bg-gray-100 rounded-full p-4 mb-4">
                                            <i class="fas fa-envelope text-3xl text-gray-400"></i>
                                        </div>
                                        <p class="text-lg font-medium mb-1">No letters found</p>
                                        <p class="text-sm mb-3">Create your first letter to start managing club correspondence.</p>
                                        <a href="{{ route('admin.letters.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                                            <i class="fas fa-plus mr-2"></i> Create your first letter
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
