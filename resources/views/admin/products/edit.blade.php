@extends('admin.layouts.app')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk: ' . $product->name)

@section('content')
<form method="POST" action="{{ route('panel.products.update', $product) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <x-admin.product-form :product="$product" :categories="$categories" />
</form>
@endsection
