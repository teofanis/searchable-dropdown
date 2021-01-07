<?php
/*
 * Searchable Dropdown props
 */
return [
    'name' => '',
    'entangle' => '', 
    'provider' => '',
    'value' => null,
    'noResultsMessage' => config('searchable-dropdown-config.placeholders.default-no-results-message'),
    'placeholder' => config('searchable-dropdown-config.placeholders.default-placeholder'),
    'searchFieldPlaceholder' => config('searchable-dropdown-config.placeholders.default-search-placeholder'),
    'inLiveWire' => config('searchable-dropdown-config.settings.default-is-in-livewire'),
    'multiselect' => config('searchable-dropdown-config.settings.default-is-multiselect'),
    'context' => null,
];