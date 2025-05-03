@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Cash Payment Details
                    </h2>
                    <div class="flex space-x-2">
                        <a href="{{ Auth::user()->is_admin ? route('admin.payments.index') : route('client.payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition shadow-sm">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Payments
                        </a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.cash-payments.edit', $payment->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition shadow-sm">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Information</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Transaction ID</p>
                                        <p class="text-base font-medium text-gray-900">#{{ $payment->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Amount</p>
                                        <p class="text-base font-medium text-gray-900">₱{{ number_format($payment->total_price, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Purpose</p>
                                        <p class="text-base font-medium text-gray-900">{{ $payment->purpose }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Payment Status</p>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $payment->payment_status === 'Paid' ? 'bg-green-100 text-green-800' :
                                               ($payment->payment_status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $payment->payment_status }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Date</p>
                                        <p class="text-base font-medium text-gray-900">{{ \Carbon\Carbon::parse($payment->placed_on)->format('M d, Y h:i A') }}</p>
                                    </div>
                                    @if($payment->description)
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Description</p>
                                            <p class="text-base font-medium text-gray-900">{{ $payment->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Cash Payment Details</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Receipt Control Number</p>
                                        <p class="text-base font-medium text-gray-900">{{ $payment->receipt_control_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Officer in Charge</p>
                                        <p class="text-base font-medium text-gray-900">{{ $payment->officer_in_charge }}</p>
                                    </div>
                                    @if($payment->cash_proof_path)
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 mb-2">Proof of Payment</p>
                                            <a href="{{ asset($payment->cash_proof_path) }}" target="_blank" class="block">
                                                <img src="{{ asset($payment->cash_proof_path) }}" alt="Proof of Payment" class="max-w-full h-auto rounded-lg border border-gray-200 shadow-sm" style="max-height: 300px;">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->is_admin && $payment->payment_status === 'Pending')
                    <div class="mt-6 flex space-x-4">
                        <form action="{{ route('admin.cash-payments.approve', $payment->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition shadow-sm">
                                <i class="fas fa-check-circle mr-2"></i> Approve Payment
                            </button>
                        </form>
                        <form action="{{ route('admin.cash-payments.reject', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this payment?');">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition shadow-sm">
                                <i class="fas fa-times-circle mr-2"></i> Reject Payment
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
