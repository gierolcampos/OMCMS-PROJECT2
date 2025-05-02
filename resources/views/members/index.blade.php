@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between space-y-4 md:space-y-0 mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Club Members</h1>
                <p class="text-sm text-gray-500 mt-1">Manage your membership database</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('members.export') }}" class="bg-white border border-gray-300 text-gray-700 text-sm py-2 px-4 rounded-md flex items-center justify-center transition duration-200 hover:bg-gray-50 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    Export CSV
                </a>
                <a href="{{ route('members.showImport') }}" class="bg-white border border-gray-300 text-gray-700 text-sm py-2 px-4 rounded-md flex items-center justify-center transition duration-200 hover:bg-gray-50 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v9a1 1 0 11-2 0V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Import CSV
                </a>
                <a href="{{ route('members.create') }}" class="group bg-red-600 hover:bg-red-700 text-white text-sm py-2.5 px-4 rounded-md flex items-center justify-center transition duration-200 transform hover:translate-y-[-2px] shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Member
                </a>
            </div>
        </div>
        
        <!-- Search and filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6 overflow-hidden">
            <form action="{{ route('members.index') }}" method="GET" class="p-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="relative flex-1">
                        <input type="text" name="search" id="search" placeholder="Search by name, email, ID..." value="{{ request('search') }}" 
                            class="pl-10 pr-4 py-2.5 w-full bg-gray-50 border-none rounded-md focus:ring-2 focus:ring-gray-200 focus:bg-white transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 items-center">
                        <div class="min-w-[120px]">
                            <select name="status" class="bg-gray-50 border-none rounded-md py-2.5 pl-3 pr-8 text-sm text-gray-700 focus:ring-2 focus:ring-gray-200 focus:bg-white w-full transition-all duration-200">
                                <option value="" {{ !request('status') ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="min-w-[120px]">
                            <select name="per_page" class="bg-gray-50 border-none rounded-md py-2.5 pl-3 pr-8 text-sm text-gray-700 focus:ring-2 focus:ring-gray-200 focus:bg-white w-full transition-all duration-200">
                                <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10 per page</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-md text-sm font-medium transition duration-200 whitespace-nowrap">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        @if(session('success'))
            <div class="border-l-4 border-green-500 bg-green-50 p-4 mb-6 rounded-md animate-fadeIn" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            @if($members->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Member
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Joined
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($members as $member)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        {{ $member->membership_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-9 w-9">
                                                <div class="h-9 w-9 rounded-full bg-gray-100 flex items-center justify-center">
                                                    <span class="text-gray-700 font-medium">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $member->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $member->phone ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $member->joined_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('members.updateStatus', $member) }}" method="POST" id="status-form-{{ $member->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" 
                                                class="text-xs py-1 px-2 rounded-full font-medium border-0 focus:ring-0 
                                                {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}" 
                                                onchange="document.getElementById('status-form-{{ $member->id }}').submit();">
                                                <option value="active" {{ $member->status === 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $member->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-3">
                                            <a href="{{ route('members.show', $member) }}" class="text-gray-400 hover:text-gray-700 transition-colors duration-150" title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('members.edit', $member) }}" class="text-gray-400 hover:text-gray-700 transition-colors duration-150" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors duration-150" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 bg-white border-t border-gray-200">
                    <div class="pagination-container">
                        @if ($members->hasPages())
                            <div class="flex items-center justify-between">
                                <div class="flex-1 flex justify-between sm:hidden">
                                    {{-- Mobile pagination --}}
                                    @if ($members->onFirstPage())
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $members->appends(request()->except('page'))->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                            Previous
                                        </a>
                                    @endif
                                    
                                    @if ($members->hasMorePages())
                                        <a href="{{ $members->appends(request()->except('page'))->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                            Next
                                        </a>
                                    @else
                                        <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                            Next
                                        </span>
                                    @endif
                                </div>
                                
                                {{-- Desktop pagination --}}
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Showing <span class="font-medium">{{ $members->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $members->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $members->total() }}</span> results
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <nav class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">
                                            {{-- Previous Page Link --}}
                                            @if ($members->onFirstPage())
                                                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                                    <span class="sr-only">Previous</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @else
                                                <a href="{{ $members->appends(request()->except('page'))->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                    <span class="sr-only">Previous</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            @endif
                                            
                                            {{-- Pagination Elements --}}
                                            @foreach ($members->getUrlRange(max($members->currentPage() - 2, 1), min($members->currentPage() + 2, $members->lastPage())) as $page => $url)
                                                @if ($page == $members->currentPage())
                                                    <span aria-current="page" class="relative inline-flex items-center px-4 py-2 border border-red-500 bg-red-50 text-sm font-medium text-red-600">
                                                        {{ $page }}
                                                    </span>
                                                @else
                                                    <a href="{{ $members->appends(request()->except('page'))->url($page) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                        {{ $page }}
                                                    </a>
                                                @endif
                                            @endforeach
                                            
                                            {{-- Next Page Link --}}
                                            @if ($members->hasMorePages())
                                                <a href="{{ $members->appends(request()->except('page'))->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                    <span class="sr-only">Next</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            @else
                                                <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                                    <span class="sr-only">Next</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="py-12 px-4 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No members found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by adding your first member to the database.</p>
                    <div class="mt-6">
                        <a href="{{ route('members.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md shadow-sm transition duration-200 transform hover:-translate-y-0.5">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Member
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 