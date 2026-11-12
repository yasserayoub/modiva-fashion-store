<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::withCount('variants')
            ->orderBy('name')
            ->get();

        return view('admin.colors.index', compact('colors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:colors,name'],
            'hexcode' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        Color::create($validated);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color added successfully.');
    }

    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('colors', 'name')->ignore($color->id),
            ],
            'hexcode' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $color->update($validated);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color updated successfully.');
    }

    public function destroy(Color $color)
    {
        if ($color->variants()->exists()) {
            return redirect()->route('admin.colors.index')
                ->with('error', 'This color is assigned to product variants and cannot be deleted.');
        }

        $color->delete();

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color deleted successfully.');
    }
}
