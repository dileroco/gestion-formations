<x-mail::message>
# Rapport Hebdomadaire de l'Académie

Voici le résumé de l'activité de la semaine dernière :

- **Nouveaux Utilisateurs:** {{ $stats['new_users'] }}
- **Nouvelles Inscriptions:** {{ $stats['new_inscriptions'] }}
- **Inscriptions Confirmées:** {{ $stats['confirmed_inscriptions'] }}

@component('mail::button', ['url' => route('admin.dashboard')])
Voir le Tableau de Bord
@endcomponent

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
