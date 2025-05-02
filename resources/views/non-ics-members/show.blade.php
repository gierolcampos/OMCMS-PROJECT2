@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Non-ICS Member Details</h1>
                        <p class="text-gray-600 mt-1">View and manage member information</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <a href="{{ route('admin.non-ics-members.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back to List
                        </a>
                        <a href="{{ route('admin.non-ics-members.edit', $nonIcsMember->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                    </div>
                </div>

                <!-- Member Information -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Member Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Full Name</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->fullname }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Email</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->email }}</p>
                            </div>
                            
                            @if($nonIcsMember->alternative_email)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Alternative Email</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->alternative_email }}</p>
                            </div>
                            @endif
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Course/Year/Section</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->course_year_section }}</p>
                            </div>
                            
                            @if($nonIcsMember->student_id)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Student ID</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->student_id }}</p>
                            </div>
                            @endif
                            
                            @if($nonIcsMember->department)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Department/College</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->department }}</p>
                            </div>
                            @endif
                            
                            @if($nonIcsMember->mobile_no)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Mobile Number</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->mobile_no }}</p>
                            </div>
                            @endif
                            
                            @if($nonIcsMember->address)
                            <div class="md:col-span-2">
                                <h3 class="text-sm font-medium text-gray-500">Address</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->address }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Membership Information -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Membership Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Payment Status</h3>
                                <div class="mt-1">
                                    @if($nonIcsMember->payment_status == 'Paid')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                    @elseif($nonIcsMember->payment_status == 'Pending')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        None
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($nonIcsMember->membership_type)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Membership Type</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->membership_type }}</p>
                            </div>
                            @endif
                            
                            @if($nonIcsMember->membership_expiry)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Membership Expiry</h3>
                                <p class="mt-1 text-base text-gray-900">{{ \Carbon\Carbon::parse($nonIcsMember->membership_expiry)->format('M d, Y') }}</p>
                            </div>
                            @endif
                            
                            @if($nonIcsMember->notes)
                            <div class="md:col-span-2">
                                <h3 class="text-sm font-medium text-gray-500">Notes</h3>
                                <p class="mt-1 text-base text-gray-900">{{ $nonIcsMember->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Payment History -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-medium text-gray-900">Payment History</h2>
                        <a href="{{ route('admin.payments.create') }}?payer_type=non_ics_member&non_ics_email={{ $nonIcsMember->email }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus mr-1"></i> Add Payment
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($payments as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->method }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->purpose }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($payment->total_price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($payment->payment_status == 'Paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Paid
                                        </span>
                                        @elseif($payment->payment_status == 'Pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $payment->payment_status }}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No payment records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
