@extends('layouts.admin')

@section('title', 'Categorie')

@section('content')
    <h1>Categorie</h1>
    <p><strong>Nom FR:</strong> {{ $category->name_fr }}</p>
    <p><strong>Nom EN:</strong> {{ $category->name_en }}</p>
    <p><strong>Slug FR:</strong> {{ $category->slug_fr }}</p>
    <p><strong>Slug EN:</strong> {{ $category->slug_en }}</p>
    <p>
        <a href="{{ route('admin.categories.edit', $category) }}">Modifier</a>
        <a href="{{ route('admin.categories.index') }}">Retour</a>
    </p>
@endsection
