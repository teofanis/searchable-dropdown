@props(searchableDropdownProps())
@php
$context = $context ? $context->id : null;
if($inLiveWire && !$context){
throw new \Exception('Did you forget to pass `this` as context to the component');
}
$data = getDropdownDataset($provider);
$dropdownFunctionName = getUniqueDropdownName($context);
$theme = getTheme();
@endphp
<div class="w-full">
    @bindJSInstance
    <div x-data="{{ $dropdownFunctionName }}({
            data: {{ $data }},
            emptyOptionsMessage: '{{$noResultsMessage}}',
            name: '{{$name}}',
            placeholder: '{{$placeholder}}',
            value: '{{$value}}',
            multiselect: '{{$multiselect}}',
            context: '{{$context}}',
            })" x-init="init()" @click.away="closeListbox()" @keydown.escape="closeListbox()" class="relative">
        <span class="{{config('searchable-dropdown-config.styles.classes.wrapper')}}">
            @include('searchableDropdown::partials.button')
        </span>
        <div x-show="open" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg searchable-no-scrollbars">
            @if(!$inLiveWire)
            <input type="hidden" name="{{$name}}" x-model="value" />
            @endif
            <x-searchable-dropdown-list :theme="$theme" />
        </div>
    </div>

</div>
