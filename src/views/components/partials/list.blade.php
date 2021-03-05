@props(['theme' => getTheme(), 'settings'])
<ul x-ref="listbox" role="listbox" tabindex="-1" class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
    <li x-show="multiselect && options.length" class="relative py-2 pl-3 text-{{$theme['default-text-color']}} cursor-default select-none pr-9">
        <span class="w-full items-center justify-between" :class="{'flex' : multiselect && options.length }">
            <label :for="name + 'selectAll'" x-text="search != '' ? 'Select All Results' : 'Select All'"></label>
            <input class="-mr-6 h-4 w-4 text-{{$theme['default-primary-color']}}" :id="name + 'selectAll'" x-model="selectAll" type="checkbox" x-on:change="selectAllOptions()" />
        </span>
    </li>
    <li x-show="shouldShowDisplaySelectedOptions()" class="relative py-2 pl-3 text={{$theme['default-text-color']}} cursor-default select-none pr-9">
        <span class="w-full items-center justify-between underline text-{{$theme['default-primary-color']}}" :class="{'flex' : multiselect && value.length }">
            <label :for="name + 'onlySelected'">Show only selected options ?</label>
            <input class="-mr-6 h-4 w-4 text-{{$theme['default-primary-color']}}" :id="name + 'onlySelected'" x-model="onlySelected" type="checkbox" x-on:change="showOnlySelectedOptionsInList()" />
        </span>
    </li>
    <template x-for="item in options" :key="item.key">
        <x-searchable-dropdown-list-item :theme="$theme" :settings="$settings"/>
    </template>
    @include('searchableDropdown::partials.no-results-found')
</ul>
