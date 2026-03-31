<x-mail::message>
# Nouveau message de contact

**Nom:** {{ $message->name }}  
**Email:** {{ $message->email }}  
**Téléphone:** {{ $message->phone ?? 'N/A' }}  
**Sujet:** {{ $message->subject }}

**Message:**  
{{ $message->message }}

@component('mail::button', ['url' => route('admin.dashboard')])
Accéder à l'administration
@endcomponent

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
