@extends('admin.layouts.app')
@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
<form method="POST" action="{{ route('panel.products.store') }}" enctype="multipart/form-data">
    @csrf
    <x-admin.product-form :categories="$categories" />
</form>
@endsection
