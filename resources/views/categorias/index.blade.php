    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1 class="my-4">Lista de Categorías</h1>

            <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Crear Categoría</a>
 @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->descripcion }}</td>
                            <td>
                                <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-primary">Editar</a>
                                <button class="btn btn-sm btn-danger" onclick="if (confirm('¿Estás seguro de eliminar esta categoría?')) { document.getElementById('delete-form-{{ $categoria->id }}').submit(); }">
                                    Eliminar
                                </button>
                                <form id="delete-form-{{ $categoria->id }}" action="{{ route('categorias.destroy', $categoria) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No hay categorías registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($categorias->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $categorias->links() }}
                </div>
            @endif
        </div>
    @endsection
