@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Non-ICS Members</h1>
                        <p class="text-gray-600 mt-1">Manage non-ICS members and their payments</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('admin.non-ics-members.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i> Add Non-ICS Member
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <i class="fas fa-users text-blue-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Members</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalMembers }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 mr-4">
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Paid Members</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $paidMembers }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 mr-4">
                                <i class="fas fa-clock text-yellow-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pending Members</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $pendingMembers }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="mb-6">
                    <form action="{{ route('admin.non-ics-members.index') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or course..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-48">
                            <select name="payment_status" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                                <option value="">All Payment Status</option>
                                <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Pending" {{ request('payment_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="None" {{ request('payment_status') == 'None' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                        
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-filter mr-2"></i> Filter
                            </button>
                        </div>
                        
                        @if(request('search') || request('payment_status'))
                        <div>
                            <a href="{{ route('admin.non-ics-members.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-times mr-2"></i> Clear
                            </a>
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Members Table -->
                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course/Year/Section</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($nonIcsMembers as $member)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->fullname }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->course_year_section }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($member->payment_status == 'Paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                    @elseif($member->payment_status == 'Pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        None
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.non-ics-members.show', $member->id) }}" class="text-indigo-600 hover:text-indigo-900" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.non-ics-members.edit', $member->id) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.non-ics-members.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No non-ICS members found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $nonIcsMembers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
