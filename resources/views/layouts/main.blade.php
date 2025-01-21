@extends('layouts.master')

@section('content')
    <!-- Main Content -->
    <div class="main-page-container text-center p-6 flex items-center justify-center">
        <!-- Text Section -->
        <div class="text-section">
            <h1 class="main-page-title">Welcome to DobiPulse</h1>
            <p class="text-xl mb-6">Ready to make an order?</p>
            <a href="{{ route('login') }}" class="cta-button">
                Sign in
            </a>
        </div>

        <!-- Image Section (placed on the right side) -->
        <img src="{{ asset('images/welcome-image.jpg') }}" alt="DobiPulse" class="welcome-image">
    </div>

    <!-- About Section -->
    <div class="about-mainpage-container flex justify-between items-center mt-12 p-6">
        <!-- About Image -->
        <img src="{{ asset('images/mainpagebanner.jpg') }}" alt="Laundromat" class="about-image">
        
        <!-- About Text -->
        <div class="about-text w-1/2 ml-6">
            <h2 class="about-heading mb-4">About Us</h2>
            <p class="about-description mb-4">
                DobiPulse is a customer engagement platform designed for Dobi Soho Self-Service Laundromat. Our platform focuses on improving customer convenience and loyalty through features like real-time laundry status updates, automated reward programs, and seamless bulk order management. We aim to modernize the laundromat experience while building stronger connections with our customers.
            </p>
            <p class="font-semibold text-gray-800">
                Scan QR code on our laundry machine to earn points & calculate pricing for bulk orders.
            </p>
        </div>
    </div>
@endsection
