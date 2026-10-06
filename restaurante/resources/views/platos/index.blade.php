@extends('layouts.app')

@section('titulo', 'Administración de platos')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Administración de platos</h1>
        <a href="{{ route('platos.create') }}" class="btn btn-primary btn-lg">+ Crear plato</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($platos as $plato)
                        <tr>
                            <td>{{ $plato->id }}</td>
                            <td>
                                <img src="{{ $plato->imagen_url }}" alt="{{ $plato->nombre }}"
                                     class="rounded" style="width: 64px; height: 64px; object-fit: cover;">
                            </td>
                            <td>{{ $plato->nombre }}</td>
                            <td>{{ $plato->precio_formateado }}</td>
                            <td class="text-end">
                                <a href="{{ route('platos.edit', $plato) }}"
                                   class="btn btn-sm btn-warning">Editar</a>

                                <form action="{{ route('platos.destroy', $plato) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar el plato &quot;{{ $plato->nombre }}&quot;?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No hay platos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection