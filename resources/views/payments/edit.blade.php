@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Edit Payment</h1>
                        <p class="text-gray-600 mt-1">Modify payment details</p>
                    </div>
                    <div>
                        <a href="{{ route('payments.show', $payment->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Payment Details
                        </a>
                    </div>
                </div>

                @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                        <button class="ml-auto" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times text-red-500"></i>
                        </button>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('payments.update', $payment->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                            <select id="payment_method" name="payment_method" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="">Select Payment Method</option>
                                <option value="CASH" {{ $payment->method == 'CASH' ? 'selected' : '' }}>CASH</option>
                                <option value="GCASH" {{ $payment->method == 'GCASH' ? 'selected' : '' }}>GCASH</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="total_price" class="block text-sm font-medium text-gray-700 mb-1">Amount (₱)</label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₱</span>
                                </div>
                                <input type="number" step="0.01" min="0" id="total_price" name="total_price" value="{{ old('total_price', $payment->total_price) }}" class="block w-full pl-7 pr-12 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="0.00" required>
                            </div>
                            @error('total_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                            <select id="payment_status" name="payment_status" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="Paid" {{ $payment->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Pending" {{ $payment->payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Failed" {{ $payment->payment_status == 'Failed' ? 'selected' : '' }}>Failed</option>
                                <option value="Refunded" {{ $payment->payment_status == 'Refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                            @error('payment_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter payment description (optional)">{{ old('description', $payment->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Cash Payment Details -->
                    <div id="cash-fields" class="space-y-6 bg-gray-50 p-6 rounded-lg border border-gray-200" style="display: none;">
                        <h3 class="text-lg font-medium text-gray-900">Cash Payment Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Officer in Charge -->
                            <div>
                                <label for="officer_in_charge" class="block text-sm font-medium text-gray-700 mb-1">Officer in Charge</label>
                                <input type="text" id="officer_in_charge" name="officer_in_charge" value="{{ old('officer_in_charge', $payment->officer_in_charge) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter officer's name">
                                @error('officer_in_charge')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Receipt Control Number -->
                            <div>
                                <label for="receipt_control_number" class="block text-sm font-medium text-gray-700 mb-1">Receipt Control Number</label>
                                <input type="text" id="receipt_control_number" name="receipt_control_number" value="{{ old('receipt_control_number', $payment->receipt_control_number) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter receipt control number">
                                @error('receipt_control_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- GCash Specific Fields -->
                    <div id="gcash-fields" class="space-y-6 bg-gray-50 p-6 rounded-lg border border-gray-200" style="display: none;">
                        <h3 class="text-lg font-medium text-gray-900">GCash Payment Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- GCash Name -->
                            <div>
                                <label for="gcash_name" class="block text-sm font-medium text-gray-700 mb-1">GCash Account Name</label>
                                <input type="text" id="gcash_name" name="gcash_name" value="{{ old('gcash_name', $payment->gcash_name) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter GCash account name">
                                @error('gcash_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- GCash Number -->
                            <div>
                                <label for="gcash_num" class="block text-sm font-medium text-gray-700 mb-1">GCash Mobile Number</label>
                                <input type="tel" id="gcash_num" name="gcash_num" value="{{ old('gcash_num', $payment->gcash_num) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="09123456789" pattern="[0-9]{11}">
                                <p class="mt-1 text-xs text-gray-500">Enter 11-digit mobile number</p>
                                @error('gcash_num')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- GCash Amount -->
                            <div>
                                <label for="gcash_amount" class="block text-sm font-medium text-gray-700 mb-1">Amount Paid (₱)</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" id="gcash_amount" name="gcash_amount" value="{{ old('gcash_amount', $payment->gcash_amount) }}" class="block w-full pl-7 pr-12 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="0.00">
                                </div>
                                @error('gcash_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Reference Number -->
                            <div>
                                <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-1">Reference Number</label>
                                <input type="text" id="reference_number" name="reference_number" value="{{ old('reference_number', $payment->reference_number) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter GCash reference number">
                                @error('reference_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('payments.show', $payment->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i> Update Payment
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
        const paymentMethod = document.getElementById('payment_method');
        const gcashFields = document.getElementById('gcash-fields');
        const cashFields = document.getElementById('cash-fields');
        const totalPriceInput = document.getElementById('total_price');
        const gcashAmountInput = document.getElementById('gcash_amount');
        
        // Function to toggle payment method fields
        function togglePaymentFields() {
            if (paymentMethod.value === 'GCASH') {
                gcashFields.style.display = 'block';
                cashFields.style.display = 'none';
                // Make GCash fields required
                document.getElementById('gcash_name').required = true;
                document.getElementById('gcash_num').required = true;
                document.getElementById('gcash_amount').required = true;
                document.getElementById('reference_number').required = true;
                // Remove required from cash fields
                document.getElementById('officer_in_charge').required = false;
                document.getElementById('receipt_control_number').required = false;
            } else if (paymentMethod.value === 'CASH') {
                gcashFields.style.display = 'none';
                cashFields.style.display = 'block';
                // Make cash fields required
                document.getElementById('officer_in_charge').required = true;
                document.getElementById('receipt_control_number').required = true;
                // Remove required from GCash fields
                document.getElementById('gcash_name').required = false;
                document.getElementById('gcash_num').required = false;
                document.getElementById('gcash_amount').required = false;
                document.getElementById('reference_number').required = false;
            } else {
                gcashFields.style.display = 'none';
                cashFields.style.display = 'none';
                // Remove required from all fields
                document.getElementById('gcash_name').required = false;
                document.getElementById('gcash_num').required = false;
                document.getElementById('gcash_amount').required = false;
                document.getElementById('reference_number').required = false;
                document.getElementById('officer_in_charge').required = false;
                document.getElementById('receipt_control_number').required = false;
            }
        }

        // Function to validate GCash amount
        function validateGcashAmount() {
            if (paymentMethod.value === 'GCASH') {
                const totalPrice = parseFloat(totalPriceInput.value) || 0;
                const gcashAmount = parseFloat(gcashAmountInput.value) || 0;
                
                if (gcashAmount < totalPrice) {
                    gcashAmountInput.setCustomValidity('Amount paid must be greater than or equal to the payment amount');
                } else {
                    gcashAmountInput.setCustomValidity('');
                }
            }
        }

        // Initial check
        togglePaymentFields();
        
        // Event listeners
        paymentMethod.addEventListener('change', togglePaymentFields);
        totalPriceInput.addEventListener('input', validateGcashAmount);
        gcashAmountInput.addEventListener('input', validateGcashAmount);

        // Show the appropriate fields based on current payment method
        if (paymentMethod.value) {
            togglePaymentFields();
        }
    });
</script>
@endsection 