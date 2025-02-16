@props(searchableDropdownProps())
@php
$context = $context ? $context->getId() : null;
if($inLiveWire && !$context){
throw new \Exception('Did you forget to pass `this` as context to the component');
}
$data = getDropdownDataset($data);
$dropdownFunctionName = getUniqueDropdownName($context, $entangle);
$theme = getTheme();
$placeholder = $required ? $placeholder . ' *' : $placeholder;
$label = $required ? $label . ' *' : $label;
@endphp
<div class="w-full">
    @bindJSInstance
    @if($label)
        @include('searchableDropdown::partials.label')
    @endif
    @if($xModel)
    <input id="{{$dropdownFunctionName}}_input" type="hidden" x-model="{{$xModel}}" x-on:change="{{$xModel}} = $event.target.value" />
    @endif
    <div x-data="{{ $dropdownFunctionName }}({
            data: {{ $data }},
            emptyOptionsMessage: '{{$noResultsMessage}}',
            name: '{{$name}}',
            placeholder: '{{$placeholder}}',
            value: '{{$value}}',
            entangle: '{{$entangle}}',
            multiselect: '{{$multiselect}}',
            context: '{{$context}}',
            whoami: '{{$dropdownFunctionName}}'
            })" x-ref="{{$dropdownFunctionName}}" x-init="init()" @click.away="closeListbox()" @keydown.escape="closeListbox()" class="relative">
        <span class="{{config('searchable-dropdown-config.styles.classes.wrapper')}}">
            @include('searchableDropdown::partials.button')
        </span>
       @error($name) <div class="mt-1 text-red-500 text-sm">{{$message}}</div>  @enderror
        <div x-show="open" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg searchable-no-scrollbars">
            @if(!$inLiveWire)
            <input type="hidden" name="{{$name}}" x-model="value" />
            @endif
            <x-searchable-dropdown-list :theme="$theme" :settings="['alignment' => $alignListItems]" />
        </div>
    </div>

</div>
