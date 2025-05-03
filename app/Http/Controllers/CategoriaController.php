<?php

  
    
    namespace App\Http\Controllers;

    use App\Models\Categoria;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class CategoriaController extends Controller
    {
        /**
         * Muestra una lista de las categorías.
         */
        public function index()
        {
            $categorias = Categoria::paginate(10); // Pagina los resultados, 10 por página
            return view('categorias.index', compact('categorias'));
        }

        /**
         * Muestra el formulario para crear una nueva categoría.
         */
        public function create()
        {
            return view('categorias.create');
        }

        /**
         * Guarda una nueva categoría en la base de datos.
         */
        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255|unique:categorias',
                'descripcion' => 'nullable|string',
            ]);

           if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            Categoria::create($request->all());
            // Añadido: Mensaje de éxito con flash session
            return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
        }

        /**
         * Muestra los detalles de una categoría específica.
         *
         * @param  \App\Models\Categoria  $categoria
         * @return \Illuminate\Http\Response
         */
        public function show(Categoria $categoria)
        {
            return view('categorias.show', compact('categoria')); // Por lo general, no se usa show para las categorías, pero se deja por completar el resource
        }

        /**
         * Muestra el formulario para editar una categoría existente.
         */
        public function edit(Categoria $categoria)
        {
            return view('categorias.edit', compact('categoria'));
        }

        /**
         * Actualiza una categoría existente en la base de datos.
         */
        public function update(Request $request, Categoria $categoria)
        {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id, // Excluye la categoría actual de la validación de unicidad
                'descripcion' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $categoria->update($request->all());
            return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
        }

        /**
         * Elimina una categoría de la base de datos.
         */
          public function destroy(Categoria $categoria)
    {
        if ($categoria->productos()->count() > 0) {
            return redirect()->route('categorias.index')->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        }

        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
    }
