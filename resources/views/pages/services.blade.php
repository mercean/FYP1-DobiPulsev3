@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center mb-6">Our Services</h1>
        
        <p class="text-lg mb-6">DobiPulse offers a wide range of services to enhance your laundromat experience:</p>

        <ul class="space-y-4">
            <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-4"></i>
                Real-time laundry status updates
            </li>
            <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-4"></i>
                Automated rewards program
            </li>
            <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-4"></i>
                Seamless bulk order management
            </li>
            <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-4"></i>
                Secure and fast online payments
            </li>
        </ul>
    </div>
@endsection
