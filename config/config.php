<?php

/*
 * Searchable Dropdown configurations
 */
return [
    'placeholders' => [
        'default-no-results-message' => 'No Results Found',
        'default-placeholder' => 'Select an option',
        'default-search-placeholder' => 'Search...',
    ],
    'styles' => [
        'theme' => [
            'default-text-color' => 'text-gray-900',
            'default-primary-color' => 'indigo-600',
            'default-secondary-color' => 'white',
        ],
        'classes' => [ 
            'wrapper' => 'inline-block w-full rounded-md shadow-sm',
            'label' => 'block tracking-wide text-xs font-bold mb-4 char-style-medium cursor-pointer leading-none text-mbr_blue font-hairline',
            'button' => 'relative z-0 w-full py-2 pl-3 pr-10 text-left transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5',
        ]
    ],
    'settings' => [
        'default-is-multiselect' => false,
        'default-is-in-livewire' => false, 
        'default-list-item-alignment' => 'text-center',
    ],
     
];