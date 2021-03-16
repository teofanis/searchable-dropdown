<?php
/*
 * Searchable Dropdown props default values
 */
return [
    'name' => '',
    'entangle' => '',
    'data' => '',
    'value' => null,
    'alignListItems' => config('searchable-dropdown-config.settings.default-list-item-alignment'),
    'noResultsMessage' => config('searchable-dropdown-config.placeholders.default-no-results-message'),
    'placeholder' => config('searchable-dropdown-config.placeholders.default-placeholder'),
    'searchFieldPlaceholder' => config('searchable-dropdown-config.placeholders.default-search-placeholder'),
    'inLiveWire' => config('searchable-dropdown-config.settings.default-is-in-livewire'),
    'multiselect' => config('searchable-dropdown-config.settings.default-is-multiselect'),
    'label' => null,
    'required' => false,
    'context' => null,
    'disabled' => false,
    'xModel' => ''
];
