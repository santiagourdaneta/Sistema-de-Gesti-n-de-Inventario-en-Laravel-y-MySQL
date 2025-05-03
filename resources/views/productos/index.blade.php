    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1 class="my-4">Lista de Productos</h1>

            <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Crear Producto</a>

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
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->precio }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->categoria->nombre }}</td>
                            <td>
                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-primary">Editar</a>
                                <button class="btn btn-sm btn-danger" onclick="if (confirm('¿Estás seguro de eliminar este producto?')) { document.getElementById('delete-form-{{ $producto->id }}').submit(); }">
                                    Eliminar
                                </button>
                                <form id="delete-form-{{ $producto->id }}" action="{{ route('productos.destroy', $producto) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($productos->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $productos->links() }}
                </div>
            @endif
        </div>
    @endsection
