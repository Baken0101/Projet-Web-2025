@props([
    'label'         => false,
    'placeholder'   => false,
    'type'          => 'text',
    'name'          => 'input_name',
    'value'         => '',
    'resetLink'     => false,
    'disabled'      => false,
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-1']) }}>
    @if($type == 'password')
        @if($label)
            <div class="flex items-center justify-between gap-1">
                <label class="form-label font-normal text-gray-900">{{ $label }}</label>
                @if (Route::has('password.request') && $resetLink)
                    <a class="text-2sm link shrink-0" href="{{ route('password.request') }}">
                        {{ __('Forgot your password ?') }}
                    </a>
                @endif
            </div>
        @endif
        <div class="input" data-toggle-password="true">
            <input name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} placeholder="{{ $placeholder }}"
                   type="password" value="{{ old($name, $value) }}"/>
            <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"></i>
                <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"></i>
            </button>
        </div>
    @else
        @if($label)
            <label class="form-label font-normal text-gray-900">{{ $label }}</label>
        @endif
        <input class="input" {{ $disabled ? 'disabled' : '' }} name="{{ $name }}"
               placeholder="{{ $placeholder }}" type="{{ $type }}" value="{{ old($name, $value) }}"/>
    @endif

    @error($name)
    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>
