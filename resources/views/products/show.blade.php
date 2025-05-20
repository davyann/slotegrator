@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Product Details</span>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Back to Products</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label text-md-right">Name:</label>
                        <div class="col-md-6">
                            <p class="form-control-static">{{ $product->name }}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label text-md-right">Description:</label>
                        <div class="col-md-6">
                            <p class="form-control-static">{{ $product->description ?? 'No description available' }}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label text-md-right">Price:</label>
                        <div class="col-md-6">
                            <p class="form-control-static">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label text-md-right">Stock:</label>
                        <div class="col-md-6">
                            <p class="form-control-static">{{ $product->stock }}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label text-md-right">Status:</label>
                        <div class="col-md-6">
                            <p class="form-control-static">{{ $product->is_active ? 'Active' : 'Inactive' }}</p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
