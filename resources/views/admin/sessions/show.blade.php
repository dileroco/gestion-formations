@extends('layouts.admin')

@section('title', 'Session')

@section('content')
    <h1>Session</h1>
    <p><strong>Formation:</strong> {{ $session->formation?->title_fr }}</p>
    <p><strong>Formateur:</strong> {{ $session->trainer?->name }}</p>
    <p><strong>Debut:</strong> {{ $session->start_date?->format('Y-m-d H:i') }}</p>
    <p><strong>Fin:</strong> {{ $session->end_date?->format('Y-m-d H:i') }}</p>
    <p><strong>Capacite:</strong> {{ $session->capacity }}</p>
    <p><strong>Mode:</strong> {{ $session->mode }}</p>
    <p><strong>Ville:</strong> {{ $session->city }}</p>
    <p><strong>Lien:</strong> {{ $session->meeting_link }}</p>
    <p><strong>Statut:</strong> {{ $session->status_label }}</p>
    <p>
        <a href="{{ route('admin.sessions.edit', $session) }}">Modifier</a>
        <a href="{{ route('admin.sessions.index') }}">Retour</a>
    </p>
@endsection
