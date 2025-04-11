{{-- Déclaration des props du composant --}}
@props([
    'label'         => false, // Label à afficher au-dessus du champ
    'placeholder'   => false, // Texte d'exemple dans le champ
    'type'          => 'text', // Type d'input (par défaut text)
    'name'          => 'input_name', // Nom de l’input (attribut HTML name)
    'value'         => '', // Valeur par défaut ou récupérée avec old()
    'resetLink'     => false, // Affiche un lien "mot de passe oublié"
    'disabled'      => false, // Désactive le champ si true
    'messages'      => [], // Messages d’erreur
])

@php
    // Si label ou placeholder sont des tableaux (ce qui provoquerait une erreur), on les remplace par null
    $label = is_array($label) ? null : $label;
    $placeholder = is_array($placeholder) ? null : $placeholder;
@endphp

{{-- Conteneur principal de l'input --}}
<div {{ $attributes->merge(['class' => 'flex flex-col gap-1']) }}>
    {{-- Si le champ est de type mot de passe --}}
    @if($type == 'password')
        @if($label)
            <div class="flex items-center justify-between gap-1">
                <label class="form-label font-normal text-gray-900">{{ $label }}</label>

                {{-- Lien "mot de passe oublié" --}}
                @if (Route::has('password.request') && $resetLink)
                    <a class="text-2sm link shrink-0" href="{{ route('password.request') }}">
                        {{ __('Forgot your password ?') }}
                    </a>
                @endif
            </div>
        @endif

        {{-- Champ mot de passe avec bouton d’affichage --}}
        <div class="input" data-toggle-password="true">
            <input
                name="{{ $name }}"
                {{ $disabled ? 'disabled' : '' }}
                placeholder="{{ $placeholder }}"
                type="password"
                value="{{ is_array(old($name, $value)) ? '' : old($name, $value) }}"
            />
            <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"></i>
                <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"></i>
            </button>
        </div>
    @else
        @if($label)
            <label class="form-label font-normal text-gray-900">{{ $label }}</label>
        @endif

        {{-- Champ standard : text, email, date, etc. --}}
        <input
            class="input"
            {{ $disabled ? 'disabled' : '' }}
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            type="{{ $type }}"
            value="{{ is_array(old($name, $value)) ? '' : old($name, $value) }}"
        />
    @endif

    {{-- Message d’erreur Laravel --}}
    @error($name)
    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>
