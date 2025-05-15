@extends('layouts.master')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-xl font-bold mb-4">➕ Create Promotion</h2>
    <form method="POST" action="{{ route('promotions.store') }}">
        @include('admin.promotions._form')
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded mt-4">Save</button>
    </form>
</div>
@endsection
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
