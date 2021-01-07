@props(['theme' => getTheme()])
<li x-bind:id="name + 'Option' + index" x-on:click="selectOption(key)" role="option" class="relative py-2 pl-3 text-{{$theme['default-text-color']}} cursor-default select-none pr-9 hover:text-white hover:bg-{{$theme['default-primary-color']}}">
    <span class="hover:text-white w-full">
        <span x-text="Object.values(options)[index]" class="block font-normal truncate font-normal hover:font-semibold"></span>
        <span x-show="multiselect ? value.includes(key) : (key === value) " :class="{'flex flex-row-reverse' : multiselect ? value.includes(key) : (key === value) }" class="absolute inset-y-0 right-0 w-full items-center pr-4 text-{{$theme['default-primary-color']}} hover:text-white">
            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        </span>
    </span>
</li>
