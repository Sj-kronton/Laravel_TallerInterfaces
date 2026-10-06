@extends('layouts.app')

@section('titulo', 'Carta del restaurante')

@section('contenido')
    <h1 class="h3 mb-4">Carta del restaurante</h1>

    <div class="list-group shadow-sm">
        @forelse ($platos as $plato)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h5 mb-1">{{ $plato->nombre }}</h2>
                    <span class="text-success fw-semibold">{{ $plato->precio_formateado }}</span>
                </div>
                <a href="{{ route('menu.show', $plato) }}" class="btn btn-outline-primary">Ver detalle</a>
            </div>
        @empty
            <div class="list-group-item text-center text-muted py-4">
                Aún no hay platos disponibles.
            </div>
        @endforelse
    </div>
@endsection