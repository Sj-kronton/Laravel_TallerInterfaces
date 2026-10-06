@extends('layouts.app')

@section('titulo', $plato->nombre)

@section('contenido')
    <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary mb-3">← Volver al menú</a>

    <div class="card shadow-sm">
        <img src="{{ $plato->imagen_url }}" alt="{{ $plato->nombre }}"
             class="card-img-top" style="max-height: 420px; object-fit: cover;">
        <div class="card-body">
            <h1 class="h3">{{ $plato->nombre }}</h1>
            <p class="fs-4 text-success fw-semibold">{{ $plato->precio_formateado }}</p>
            <p class="mb-0">{{ $plato->descripcion }}</p>
        </div>
    </div>
@endsection