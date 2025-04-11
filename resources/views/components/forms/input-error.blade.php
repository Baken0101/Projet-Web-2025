{{-- Composant d'affichage des messages d'erreur pour les champs de formulaire --}}

@props(['messages']) {{-- On déclare la prop "messages" qui est attendue --}}

@if ($messages) {{-- Si le tableau de messages n'est pas vide --}}
<ul {{ $attributes->merge(['class' => 'text-xs text-red-500 space-y-1']) }}>
    @foreach ((array) $messages as $message) {{-- On boucle sur les erreurs (array casting de sécurité) --}}
    <li>{{ $message }}</li>
    @endforeach
</ul>
@endif
