<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use Intervention\Image\Facades\Image;


class PromotionController extends Controller
{
    public function index() {
        $promotions = Promotion::orderBy('end_date', 'desc')->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create() {
        return view('admin.promotions.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'auto_apply' => 'boolean',
            'code' => 'nullable|string|max:50',
        ]);
        Promotion::create($validated);
        return redirect()->route('promotions.index')->with('success', 'Promotion added.');
    }

    public function edit(Promotion $promotion) {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'auto_apply' => 'boolean',
            'code' => 'nullable|string|max:50',
        ]);
        $promotion->update($validated);
        return redirect()->route('promotions.index')->with('success', 'Promotion updated.');
    }

    public function destroy(Promotion $promotion) {
        $promotion->delete();
        return redirect()->route('promotions.index')->with('success', 'Promotion deleted.');
    }
}