<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plato extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'imagen',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    // $plato->precio_formateado → "$ 28.500"
    protected function precioFormateado(): Attribute
    {
        return Attribute::get(
            fn () => '$ ' . number_format($this->precio, 0, ',', '.')
        );
    }

    // $plato->imagen_url → "http://tu-app/storage/platos/2026/10/archivo.png"
    protected function imagenUrl(): Attribute
    {
        return Attribute::get(fn () => asset('storage/' . $this->imagen));
    }
}