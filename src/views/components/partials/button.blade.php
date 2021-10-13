<button x-ref="dropdown-button" @click.prevent="toggleListboxVisibility()" :aria-expanded="open" aria-haspopup="listbox"
    type="button" {!! $disabled ? 'disabled' : ''!!} class="{{config('searchable-dropdown-config.styles.classes.button')}}">
    <span x-show="! open && ! multiselect" x-text="getButtonText()"
        x-bind:class="{ 'searchable-dropdown-placeholder-color' : ! hasValidValue() , 'block' : ! open && ! multiselect}"
        class="truncate"></span>
    <template x-if="multiselect">
        <span x-show="! open && multiselect" class="truncate" x-bind:class=" { 'searchable-dropdown-placeholder-color' : value.length === 0, 'block' : ! open && multiselect}"
        x-text="showSelectedOptions()" x-bind:title="showSelectedOptions()">
        </span>
    </template>
    <input id="{{$dropdownFunctionName}}_button" x-ref="search" x-show="open" x-model.debounce.250ms="search" @keyup.space.stop.prevent="" @keydown.enter.stop.prevent="selectOption()" type="search" placeholder="{{$searchFieldPlaceholder}}" class="w-full h-full focus:outline-none pr-2" />
    <span class="absolute top-0 bottom-0 right-0 flex items-center pr-2 pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :class="{'rotate-180': open}" class="ml-1 transform inline-block fill-current text-{{$theme['default-primary-color']}} w-6 h-6">
            <path fill-rule="evenodd" d="M15.3 10.3a1 1 0 011.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4l3.3 3.29 3.3-3.3z" /></svg>
    </span>
</button>
