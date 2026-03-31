@extends('layouts.admin')

@section('title', 'Formation')

@section('content')
    <h1>Formation</h1>
    <p><strong>Titre FR:</strong> {{ $formation->title_fr }}</p>
    <p><strong>Titre EN:</strong> {{ $formation->title_en }}</p>
    <p><strong>Categorie:</strong> {{ $formation->category?->name_fr }}</p>
    <p><strong>Status:</strong> {{ $formation->status_label }}</p>
    <p><strong>Prix:</strong> {{ format_price($formation->price) }}</p>
    <p><strong>Durée:</strong> {{ $formation->duration }} h</p>
    <p><strong>Niveau:</strong> {{ $formation->level }}</p>
    <p><strong>Description FR:</strong> {{ $formation->description_fr }}</p>
    <p><strong>Description EN:</strong> {{ $formation->description_en }}</p>
    <p><strong>Slug FR:</strong> {{ $formation->slug_fr }}</p>
    <p><strong>Slug EN:</strong> {{ $formation->slug_en }}</p>
    <p>
        <a href="{{ route('admin.formations.edit', $formation) }}">Modifier</a>
        <a href="{{ route('admin.formations.index') }}">Retour</a>
    </p>
@endsection
