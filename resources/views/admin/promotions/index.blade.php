@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-xl font-bold mb-4">📢 Promotions</h2>
    <a href="{{ route('promotions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ New Promotion</a>

    <table class="w-full table-auto text-left bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Title</th>
                <th class="p-2">Type</th>
                <th class="p-2">Value</th>
                <th class="p-2">Start</th>
                <th class="p-2">End</th>
                <th class="p-2">Auto</th>
                <th class="p-2">Code</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($promotions as $promo)
                <tr class="border-t">
                    <td class="p-2">{{ $promo->title }}</td>
                    <td class="p-2">{{ ucfirst($promo->type) }}</td>
                    <td class="p-2">
                        @if($promo->type === 'percent')
                            {{ $promo->value }}%
                        @else
                            RM{{ number_format($promo->value, 2) }}
                        @endif
                    </td>
                    <td class="p-2">{{ $promo->start_date->format('Y-m-d') }}</td>
                    <td class="p-2">{{ $promo->end_date->format('Y-m-d') }}</td>
                    <td class="p-2">{{ $promo->auto_apply ? 'Yes' : 'No' }}</td>
                    <td class="p-2">{{ $promo->code ?? '-' }}</td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('promotions.edit', $promo) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('promotions.destroy', $promo) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this promotion?')" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="p-4 text-center">No promotions yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
