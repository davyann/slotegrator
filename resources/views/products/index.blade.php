@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ isset($showingFavorites) && $showingFavorites ? 'Favorite Products' : 'Products' }}</span>
                        <div>
                            @if(auth()->check())
                                @if(isset($showingFavorites) && $showingFavorites)
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm me-2">All Products</a>
                                @else
                                    <a href="{{ route('products.favorites') }}" class="btn btn-secondary btn-sm me-2">My Favorites</a>
                                @endif
                            @endif
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">Create New Product</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th width="280px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        <a class="btn btn-info btn-sm" href="{{ route('products.show', $product->id) }}">View</a>
                                        <a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product->id) }}">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No products found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
