@extends('layouts.master')
@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    @include('components.admin.sidebar') {{-- Make sure this path exists --}}
    
    <main class="flex-1 p-6 lg:p-10 space-y-6 container mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">➕ Create Promotion</h2>

        <form method="POST" action="{{ route('promotions.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md space-y-4 max-w-2xl">
            @include('admin.promotions._form')
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Save</button>
        </form>
    </main>
</div>

<!-- _form.blade.php -->
@csrf
<div class="grid gap-4">
    <input type="text" name="title" placeholder="Title" value="{{ old('title', $promotion->title ?? '') }}" required class="input">
    
    <textarea name="description" placeholder="Description" class="input">{{ old('description', $promotion->description ?? '') }}</textarea>

    <select name="type" required class="input">
        <option value="fixed" {{ old('type', $promotion->type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed (RM)</option>
        <option value="percent" {{ old('type', $promotion->type ?? '') == 'percent' ? 'selected' : '' }}>Percent (%)</option>
    </select>

    <input type="number" name="value" step="0.01" placeholder="Value" value="{{ old('value', $promotion->value ?? '') }}" required class="input">

    <input type="date" name="start_date" value="{{ old('start_date', isset($promotion) ? $promotion->start_date->toDateString() : '') }}" required class="input">
    <input type="date" name="end_date" value="{{ old('end_date', isset($promotion) ? $promotion->end_date->toDateString() : '') }}" required class="input">

    <label><input type="checkbox" name="auto_apply" value="1" {{ old('auto_apply', $promotion->auto_apply ?? false) ? 'checked' : '' }}> Auto Apply</label>

    <input type="text" name="code" placeholder="Optional Code" value="{{ old('code', $promotion->code ?? '') }}" class="input">
</div>
@endsection