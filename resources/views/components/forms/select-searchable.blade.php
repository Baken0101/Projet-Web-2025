@props([
    'name',
    'label' => null,
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'placeholder' => 'Rechercher...',
    'selected' => old($name),
])

<div
    x-data="{
        search: '',
        show: false,
        selected: '{{ $selected }}',
        options: @js($options),
        get selectedLabel() {
            const found = this.options.find(opt => opt['{{ $optionValue }}'] == this.selected);
            return found ? found['{{ $optionLabel }}'] : '';
        },
        get filteredOptions() {
            return this.options.filter(opt =>
                opt['{{ $optionLabel }}'].toLowerCase().includes(this.search.toLowerCase())
            );
        },
        select(option) {
            this.selected = option['{{ $optionValue }}'];
            this.search = option['{{ $optionLabel }}'];
            this.show = false;
            $refs.hidden.value = this.selected;
        },
        init() {
            this.search = this.selectedLabel;
        }
    }"
    @click.outside="show = false"
    x-init="init"
    class="flex flex-col gap-1 relative"
>
    @if($label)
        <label for="{{ $name }}" class="form-label text-gray-900">{{ $label }}</label>
    @endif

    <input
        type="text"
        x-model="search"
        @focus="show = true"
        @input="show = true"
        :placeholder="placeholder"
        class="input"
        autocomplete="off"
    />

    {{-- Champ réel caché (transmis au formulaire) --}}
    <select x-ref="hidden" name="{{ $name }}" class="hidden">
        @foreach ($options as $option)
            <option value="{{ $option[$optionValue] }}"
                    @if ($selected == $option[$optionValue]) selected @endif>
                {{ $option[$optionLabel] }}
            </option>
        @endforeach
    </select>

    {{-- Liste des résultats dynamiques --}}
    <ul
        x-show="show && filteredOptions.length > 0"
        class="absolute z-10 bg-white text-gray-800 shadow rounded w-full mt-1 max-h-48 overflow-auto border"
    >
        <template x-for="option in filteredOptions" :key="option['{{ $optionValue }}']">
            <li
                class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                @click="select(option)"
                x-text="option['{{ $optionLabel }}']"
            ></li>
        </template>
    </ul>

    <x-forms.input-error :messages="$errors->get($name)" class="mt-1" />
</div>
