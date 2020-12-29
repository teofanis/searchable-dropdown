@props([
    'name' => '',
    'entangle' => '', //Livewire Property that will have access to the local x-model.
    'provider' => '',
    'value' => null,
    'noResultsMessage' => 'No Results Found',
    'placeholder' => 'Select an option',
    'inLiveWire' => false,
    'multiselect' => false,

])
@php
    $data = function_exists($provider)
        ? call_user_func($provider)
        : collect();
    if ($data instanceof Illuminate\Database\Eloquent\Collection){
        $data = $data->toJson();
    } else if(is_array($data)){
        $data = json_encode($data);
    }
    $uniqueID = Str::random(40);
    $dropdownData = 'searchableDropdownData_'.$uniqueID;

@endphp

<div class="max-w-xs">
    <script>
        function {{$dropdownData}}(config) {
            return {
                data: config.data,

                emptyOptionsMessage: config.emptyOptionsMessage ?? 'No results match your search.',

                focusedOptionIndex: null,

                name: config.name,

                open: false,

                selectAll: false,

                onlySelected: false,

                options: {},

                placeholder: config.placeholder ?? 'Select an option',

                search: '',
                multiselect: config.multiselect,
                @if($inLiveWire)
                value: @entangle($entangle).defer,
                @else
                value: this.multiselect ? (config.value ?? []) : config.value,
                @endif
                closeListbox: function () {
                    this.open = false

                    this.focusedOptionIndex = null

                    this.search = ''
                },
                focusNextOption: function () {
                    if (this.focusedObjectIndex === null) return this.focusedObjectIndex = Object.keys(this.options).length - 1

                    if (this.focusedOptionIndex + 1 >= Object.keys(this.options).length) return

                    this.focusedOptionIndex++

                    this.focusListOption('center');
                },

                focusPreviousOption: function () {
                    if (this.focusedObjectIndex === null) return this.focusedObjectIndex = 0

                    if (this.focusedOptionIndex <= 0) return

                    this.focusedOptionIndex--

                    this.focusListOption('center');
                },

                init: function () {
                    this.options = this.data;

                    if (this.multiselect) {
                        this.value = Object.keys(this.options).filter(entry => this.value.includes(entry));
                    } else {
                        if (!(this.value in this.options)) this.value = null;
                    }
                    this.$watch('search', ((value) => {
                        if (!this.open || !value) return this.options = this.data

                        this.options = Object.keys(this.data)
                            .filter((key) => this.data[key].toLowerCase().includes(value.toLowerCase()))
                            .reduce((options, key) => {
                                options[key] = this.data[key]
                                return options
                            }, {})
                    }))
                },
                selectOption: function () {
                    if (!this.open) return this.toggleListboxVisibility();

                    var selectedValue = Object.keys(this.options)[this.focusedOptionIndex];

                    if(!this.multiselect){
                        if (this.value && selectedValue === this.value) {
                            this.value = null;
                        } else {
                            this.value = selectedValue;
                        }
                        this.closeListbox();
                    } else {
                        if(this.value.includes(selectedValue)){
                            this.value.splice(this.value.indexOf(selectedValue), 1);
                        }else{
                            this.value.push(selectedValue);
                        }

                    }

                },
                showSelectedOptions: function() {
                    if (this.value.length === 0) return this.placeholder;
                   return this.value.map(value => this.options[value]).join(',');
                },
                showOnlySelectedOptionsInList: function () {
                    this.search='';
                    if (this.onlySelected){
                        this.options = Object.keys(this.data)
                        .filter(key => this.value.includes(key))
                        .reduce((options, key) => {
                            options[key] = this.data[key];
                            return options;
                        }, {});
                    } else {
                        this.options = this.data;
                    }

                },
                selectAllOptions: function () {

                //Object.keys(this.data) <-- Use to select all OR options for all when not filtered or only filtered
                 this.value = this.selectAll ? Object.keys(this.options): [];
                },

                toggleListboxVisibility: function () {
                    if (this.open) return this.closeListbox()

                    if( this.multiselect) {
                        if (this.value.length) {
                            this.focusListOptionIndex = Object.keys(this.options).indexOf(this.value[0]);
                        }
                    }else {
                     this.focusedOptionIndex = Object.keys(this.options).indexOf(this.value)
                    }
                    if (this.focusedOptionIndex < 0 || this.focusListOptionIndex === null) this.focusedOptionIndex = 0
                    this.open = true

                    this.$nextTick(() => {
                        this.$refs.search.focus()

                        this.focusListOption('start');
                    })
                },

                focusListOption(block = 'center'){
                        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                            block: block,
                        })

                },
            }
        }
    </script>
    <div
            x-data="{{$dropdownData}}({
                data: {{ $data }},
                emptyOptionsMessage: '{{$noResultsMessage}}',
                name: '{{$name}}',
                placeholder: '{{$placeholder}}',
                value: '{{$value}}',
                multiselect: '{{$multiselect}}' })"
            x-init="init()"
            @click.away="closeListbox()"
            @keydown.escape="closeListbox()"
            class="relative">

            <span class="inline-block w-full rounded-md shadow-sm">
                  <button
                          x-ref="dropdown-button"
                          @click.prevent="toggleListboxVisibility()"
                          :aria-expanded="open"
                          aria-haspopup="listbox"
                          type="button"
                          class="relative z-0 w-full py-2 pl-3 pr-10 text-left transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                  >
                        <span
                                x-show="! open && ! multiselect"
                                x-text="value in options ? options[value] : placeholder"
                                :class="{ 'text-gray-500': ! (value in options) }"
                                class="block truncate"
                        ></span>
                    <template x-if="multiselect">
                        <span
                            x-show="! open && multiselect"
                            class="block truncate"
                            :class=" { 'text-gray-500' : value.length === 0}"
                            x-text="showSelectedOptions()"
                            :title="showSelectedOptions()" >
                        </span>
                    </template>
                        <input
                                x-ref="search"
                                x-show="open"
                                x-model="search"
                                @keydown.enter.stop.prevent="selectOption()"
                                @keydown.arrow-up.prevent="focusPreviousOption()"
                                @keydown.arrow-down.prevent="focusNextOption()"
                                type="search"
                                placeholder="Search..."
                                class="w-full h-full form-control focus:outline-none"
                                {{$attributes}}
                        />

                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                            </svg>
                        </span>
                  </button>
            </span>

        <div
                x-show="open"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-cloak
                class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg"
        >
            @if(!$inLiveWire)
                <input type="hidden" name="{{$name}}" x-model="value" />
            @endif
            <ul
                    x-ref="listbox"
                    @keydown.enter.stop.prevent="selectOption()"
                    @keydown.arrow-up.prevent="focusPreviousOption()"
                    @keydown.arrow-down.prevent="focusNextOption()"
                    role="listbox"
                    :aria-activedescendant="focusedOptionIndex ? name + 'Option' + focusedOptionIndex : null"
                    tabindex="-1"
                    class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5"
            >

                    <li x-show="multiselect && Object.keys(options).length"  class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9">
                        <span class="w-full flex items-center justify-between">
                            <label :for="name + 'selectAll'" x-text="search != '' ? 'Select All Results' : 'Select All'"></label>
                            <input class="-mr-6 h-4 w-4 text-indigo-600" :id="name + 'selectAll'" x-model="selectAll" type="checkbox" x-on:change="selectAllOptions()" />
                        </span>
                    </li>
                    <li x-show="multiselect && value.length " class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9">
                        <span class="w-full flex items-center justify-between underline text-indigo-600">
                            <label :for="name + 'onlySelected'">Show only selected options ?</label>
                            <input class="-mr-6 h-4 w-4 text-indigo-600" :id="name + 'onlySelected'" x-model="onlySelected" type="checkbox" x-on:change="showOnlySelectedOptionsInList()" />
                        </span>
                    </li>
                <template x-for="(key, index) in Object.keys(options)" :key="index">
                    <li
                            :id="name + 'Option' + focusedOptionIndex"
                            @click="selectOption()"
                            @mouseenter="focusedOptionIndex = index"
                            @mouseleave="focusedOptionIndex = null"
                            role="option"
                            :aria-selected="focusedOptionIndex === index"
                            :class="{ 'text-white bg-indigo-600': index === focusedOptionIndex, 'text-gray-900': index !== focusedOptionIndex }"
                            class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9"
                    >
                            <span x-text="Object.values(options)[index]"
                                  :class="{ 'font-semibold': index === focusedOptionIndex, 'font-normal': index !== focusedOptionIndex }"
                                  class="block font-normal truncate"
                            ></span>

                        <span
                                x-show="multiselect ? value.includes(key) : (key === value) "
                                :class="{ 'text-white': index === focusedOptionIndex, 'text-indigo-600': index !== focusedOptionIndex }"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600"
                        >
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </span>
                    </li>
                </template>

                <div
                        x-show="! Object.keys(options).length"
                        x-text="emptyOptionsMessage"
                        class="px-3 py-2 text-gray-900 cursor-default select-none"></div>
            </ul>
        </div>
    </div>

</div>
