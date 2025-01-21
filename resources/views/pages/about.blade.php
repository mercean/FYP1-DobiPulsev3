@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center mb-6">About Us</h1>
        
        <p class="text-lg mb-6">DobiPulse is a customer engagement platform designed for Dobi Soho Self-Service Laundromat. Our platform focuses on improving customer convenience and loyalty through features like:</p>
        
        <ul class="space-y-4">
            <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-4"></i>
                Real-time laundry status updates
            </li>
            <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-4"></i>
                Automated reward programs
            </li>
            <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-4"></i>
                Seamless bulk order management
            </li>
        </ul>

        <p class="text-lg mt-6">We aim to modernize the laundromat experience while building stronger connections with our customers.</p>
    </div>
@endsection
