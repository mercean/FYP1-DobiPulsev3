@extends('layouts.master')

@section('content')
<div class="p-8 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">📷 DobiPulse QR Code Demo</h1>

    <p class="mb-4 text-gray-600 dark:text-gray-300">
        This QR code simulates the scanning process. It leads to the core system route <code>/qr</code>, which:
        <ul class="list-disc list-inside text-sm mt-2 text-gray-500 dark:text-gray-400">
            <li>Prompts login for registered users.</li>
            <li>Allows guests to proceed to machine selection directly.</li>
        </ul>
    </p>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center">
        {!! QrCode::size(250)->generate(route('qr.entry')) !!}
        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
            Scans to: <code>{{ route('qr.entry') }}</code>
        </p>
    </div>

    <form method="GET" action="{{ route('qr.demo') }}" class="text-center mt-6">
        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white px-5 py-2 rounded-lg shadow">
            🔁 Regenerate QR
        </button>
    </form>
</div>
@endsection
