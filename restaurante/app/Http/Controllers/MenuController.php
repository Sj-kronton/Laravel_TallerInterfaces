<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $platos = Plato::orderBy('nombre')->get();

        return view('menu.index', compact('platos'));
    }

    public function show(Plato $plato): View
    {
        return view('menu.show', compact('plato'));
    }
}