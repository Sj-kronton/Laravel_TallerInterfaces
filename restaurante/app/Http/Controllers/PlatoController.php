<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlatoRequest;
use App\Http\Requests\UpdatePlatoRequest;
use App\Models\Plato;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class PlatoController extends Controller
{
    public function index(): View
    {
        $platos = Plato::query()->latest()->paginate(10);

        return view('platos.index', compact('platos'));
    }

    public function create(): View
    {
        return view('platos.create');
    }

    public function store(PlatoRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $imagePath = $request->file('imagen')->store('platos/'.now()->format('Y/m'), 'public');

        if ($imagePath === false) {
            throw new RuntimeException('No se pudo guardar la imagen del plato.');
        }

        $validated['imagen'] = $imagePath;
        Plato::query()->create($validated);

        return redirect()
            ->route('platos.create')
            ->with('success', 'Plato creado correctamente.');
    }

    public function edit(Plato $plato): View
    {
        return view('platos.edit', compact('plato'));
    }

    public function update(UpdatePlatoRequest $request, Plato $plato): RedirectResponse
    {
        $validated = $request->validated();
        $oldImagePath = $plato->imagen;
        $image = $request->file('imagen');
        $newImagePath = null;

        if ($image !== null) {
            $newImagePath = $image->store('platos/'.now()->format('Y/m'), 'public');

            if ($newImagePath === false) {
                throw new RuntimeException('No se pudo guardar la nueva imagen del plato.');
            }

            $validated['imagen'] = $newImagePath;
        } else {
            unset($validated['imagen']);
        }

        $plato->update($validated);

        if ($newImagePath !== null && $oldImagePath !== null && ! Storage::disk('public')->delete($oldImagePath)) {
            throw new RuntimeException('No se pudo eliminar la imagen anterior del plato.');
        }

        return redirect()
            ->route('platos.index')
            ->with('success', 'Plato actualizado correctamente.');
    }

    public function destroy(Plato $plato): RedirectResponse
    {
        $plato->delete();

        return redirect()
            ->route('platos.index')
            ->with('success', 'Plato eliminado correctamente.');
    }
}
