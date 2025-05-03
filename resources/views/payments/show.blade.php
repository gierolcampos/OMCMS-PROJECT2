@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Payment Details</h1>
                        <p class="text-gray-600 mt-1">View payment transaction information</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-[#c21313] bg-white hover:bg-gray-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Payments
                        </a>
                        @else
                        <a href="{{ route('client.payments.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-[#c21313] bg-white hover:bg-gray-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Payments
                        </a>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                    <!-- Transaction Details -->
                    <div class="px-6 py-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Transaction Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Transaction ID</p>
                                <p class="mt-1 text-sm text-gray-900">#{{ $payment->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Payment Status</p>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $payment->payment_status === 'Paid' ? 'bg-green-100 text-green-800' :
                                           ($payment->payment_status === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                                           'bg-red-100 text-red-800') }}">
                                        {{ $payment->payment_status }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Payment Method</p>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ isset($payment->method) && $payment->method === 'CASH' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800' }}">
                                        @if(isset($payment->method))
                                            {{ $payment->method }}
                                        @elseif(get_class($payment) === 'App\Models\CashPayment')
                                            CASH
                                        @elseif(get_class($payment) === 'App\Models\GcashPayment')
                                            GCASH
                                        @else
                                            Unknown
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date & Time</p>
                                <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($payment->placed_on)->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Amount</p>
                                <p class="mt-1 text-sm text-gray-900">₱{{ number_format($payment->total_price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Purpose</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->purpose ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Member</p>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if(isset($payment->user) && $payment->user)
                                        {{ $payment->user->firstname }} {{ $payment->user->lastname }}
                                    @elseif(get_class($payment) === 'App\Models\NonIcsMember')
                                        {{ $payment->fullname }} (Non-ICS)
                                    @else
                                        Guest
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Officer in-charge</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->officer_in_charge ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Receipt Control Number</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->receipt_control_number ?? 'N/A' }}</p>
                            </div>
                            @if($payment->description)
                            <div class="md:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Description</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Method Specific Details -->
                    @php
                        $isGcash = (isset($payment->method) && $payment->method === 'GCASH') || get_class($payment) === 'App\Models\GcashPayment';
                        $isCash = (isset($payment->method) && $payment->method === 'CASH') || get_class($payment) === 'App\Models\CashPayment';
                    @endphp

                    @if($isGcash)
                    <div class="px-6 py-4 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">GCash Payment Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">GCash Account Name</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->gcash_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">GCash Number</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->gcash_num ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Reference Number</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->reference_number ?? 'N/A' }}</p>
                            </div>

                            @if(isset($payment->gcash_proof_path) && $payment->gcash_proof_path)
                            <div class="md:col-span-2 mt-4">
                                <p class="text-sm font-medium text-gray-500 mb-2">Proof of Payment</p>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <img src="{{ asset($payment->gcash_proof_path) }}" alt="GCash Payment Proof" class="w-full max-w-md h-auto">
                                </div>
                                <div class="mt-2">
                                    <a href="{{ asset($payment->gcash_proof_path) }}" target="_blank" class="text-sm text-[#c21313] hover:text-red-800">
                                        <i class="fas fa-external-link-alt mr-1"></i> View Full Image
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($isCash)
                    <div class="px-6 py-4 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Cash Payment Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Officer in Charge</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->officer_in_charge ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Receipt Control Number</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->receipt_control_number ?? 'N/A' }}</p>
                            </div>

                            @if(isset($payment->cash_proof_path) && $payment->cash_proof_path)
                            <div class="md:col-span-2 mt-4">
                                <p class="text-sm font-medium text-gray-500 mb-2">Proof of Payment</p>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <img src="{{ asset($payment->cash_proof_path) }}" alt="Cash Payment Proof" class="w-full max-w-md h-auto">
                                </div>
                                <div class="mt-2">
                                    <a href="{{ asset($payment->cash_proof_path) }}" target="_blank" class="text-sm text-[#c21313] hover:text-red-800">
                                        <i class="fas fa-external-link-alt mr-1"></i> View Full Image
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="mt-6 flex justify-end space-x-3">
                    @if(Auth::user()->is_admin)
                        @if($payment->payment_status === 'Pending')
                            @php
                                $paymentClass = get_class($payment);
                                $approveRoute = '';
                                $rejectRoute = '';

                                if ($paymentClass === 'App\Models\Order') {
                                    $approveRoute = route('admin.payments.approve', $payment->id);
                                    $rejectRoute = route('admin.payments.reject', $payment->id);
                                } elseif ($paymentClass === 'App\Models\CashPayment') {
                                    $approveRoute = route('payment.types.cash.approve', $payment->id);
                                    $rejectRoute = route('payment.types.cash.reject', $payment->id);
                                } elseif ($paymentClass === 'App\Models\GcashPayment') {
                                    $approveRoute = route('payment.types.gcash.approve', $payment->id);
                                    $rejectRoute = route('payment.types.gcash.reject', $payment->id);
                                } elseif ($paymentClass === 'App\Models\NonIcsMember') {
                                    $approveRoute = route('admin.payments.approve-non-ics', $payment->id);
                                    $rejectRoute = route('admin.payments.reject-non-ics', $payment->id);
                                }
                            @endphp

                            @if($approveRoute && $rejectRoute)
                            <form action="{{ $approveRoute }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 transition">
                                    <i class="fas fa-check-circle mr-2"></i> Approve
                                </button>
                            </form>
                            <form action="{{ $rejectRoute }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this payment?');">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-white bg-[#c21313] hover:bg-red-800 transition">
                                    <i class="fas fa-times-circle mr-2"></i> Reject
                                </button>
                            </form>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection