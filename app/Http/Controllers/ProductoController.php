<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->paginate(10); // Obtener productos con paginación
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

           Producto::create($request->all());
            // Añadido: Mensaje de éxito con flash session
            return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');

 
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

           Producto::create($request->all());
            // Añadido: Mensaje de éxito con flash session
            return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');

 
    }
   

    public function destroy(Producto $producto)
    {
        $producto->delete();
         return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}