<button x-ref="dropdown-button" @click.prevent="toggleListboxVisibility()" :aria-expanded="open" aria-haspopup="listbox" type="button" class="{{config('searchable-dropdown-config.styles.classes.button')}}">
    <span x-show="! open && ! multiselect" x-text="value in options ? options[value] : placeholder" x-bind:class="{ 'searchable-dropdown-placeholder-color' : ! (value in options), 'block' : ! open && ! multiselect}" class="truncate"></span>
    <template x-if="multiselect">
        <span x-show="! open && multiselect" class="truncate" x-bind:class=" { 'searchable-dropdown-placeholder-color' : value.length === 0, 'block' : ! open && multiselect}" x-text="showSelectedOptions()" x-bind:title="showSelectedOptions()">
        </span>
    </template>
    <input x-ref="search" x-show="open" x-model.debounce.250ms="search" @keydown.enter.stop.prevent="selectOption()" type="search" placeholder="{{$searchFieldPlaceholder}}" class="w-full h-full form-control focus:outline-none pr-2" />
    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :class="{'rotate-180': open}" class="ml-1 transform inline-block fill-current text-{{$theme['default-primary-color']}} w-6 h-6">
            <path fill-rule="evenodd" d="M15.3 10.3a1 1 0 011.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4l3.3 3.29 3.3-3.3z" /></svg>
    </span>
</button>
