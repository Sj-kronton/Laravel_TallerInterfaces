<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use Illuminate\Contracts\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $platos = Plato::query()
            ->select(['id', 'nombre', 'precio'])
            ->orderBy('nombre')
            ->get();

        return view('menu.index', compact('platos'));
    }

    public function show(Plato $plato): View
    {
        return view('menu.show', compact('plato'));
    }
}
