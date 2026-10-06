<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlatoRequest;
use App\Http\Requests\UpdatePlatoRequest;
use App\Models\Plato;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlatoController extends Controller
{
    public function index(): View
    {
        $platos = Plato::orderBy('id')->get();

        return view('platos.index', compact('platos'));
    }

    public function create(): View
    {
        return view('platos.create');
    }

    public function store(PlatoRequest $request): RedirectResponse
    {
        $datos = $request->validated();
        $datos['imagen'] = $this->guardarImagen($request->file('imagen'), $datos['nombre']);

        Plato::create($datos);

        return redirect()
            ->route('platos.create')
            ->with('success', 'El plato se creó correctamente.');
    }

    public function edit(Plato $plato): View
    {
        return view('platos.edit', compact('plato'));
    }

    public function update(UpdatePlatoRequest $request, Plato $plato): RedirectResponse
    {
        $datos = $request->validated();

        if ($request->hasFile('imagen')) {
            // Se guarda primero la nueva; si falla, la anterior sigue intacta
            $nuevaRuta = $this->guardarImagen($request->file('imagen'), $datos['nombre']);

            // Eliminación física de la imagen antigua
            Storage::disk('public')->delete($plato->imagen);

            $datos['imagen'] = $nuevaRuta;
        } else {
            // Sin imagen nueva: se conserva la anterior
            unset($datos['imagen']);
        }

        $plato->update($datos);

        return redirect()
            ->route('platos.index')
            ->with('success', 'El plato se actualizó correctamente.');
    }

    public function destroy(Plato $plato): RedirectResponse
    {
        // Soft delete: se marca deleted_at. La imagen se conserva por si se restaura el registro.
        $plato->delete();

        return redirect()
            ->route('platos.index')
            ->with('success', 'El plato se eliminó correctamente.');
    }

    /**
     * Guarda la imagen en storage/app/public/platos/AAAA/MM
     * y retorna la ruta relativa (ej: platos/2026/10/hamburguesa-artesanal-a1b2c3.png).
     */
    private function guardarImagen(UploadedFile $archivo, string $nombre): string
    {
        $directorio = 'platos/' . now()->format('Y/m');
        $nombreArchivo = Str::slug($nombre) . '-' . Str::lower(Str::random(6))
            . '.' . $archivo->extension();

        return $archivo->storeAs($directorio, $nombreArchivo, 'public');
    }
}