@props(['theme' => getTheme(), 'settings'])
<li x-bind:id="name + 'Option' + item.key" x-on:click="if(!isGrouped(item)) { selectOption(item.key)}" role="option" class="relative py-2 pl-3 text-{{$theme['default-text-color']}} cursor-default select-none pr-9 {{ $settings['alignment'] }} hover:text-white hover:bg-{{$theme['default-primary-color']}}">
    <span class="hover:text-white w-full" :class="isGrouped(item) ? 'cursor-default' : 'cursor-pointer'">
    <template x-if="isGrouped(item)">
         <span x-text="item.value" class="block font-bold uppercase truncate"></span>
        </template>
        <template x-if="!isGrouped(item)">
            <span x-text="item.value" class="block font-normal truncate"></span>
            <span x-show="multiselect ? value.includes(item.key) : (item.key === value) " :class="{'flex flex-row-reverse' : multiselect ? value.includes(item.key) : (item.key === value) }" class="absolute top-0 bottom-0 right-0 w-full items-center pr-4 ">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </span>
        </template>
    </span>
</li>
