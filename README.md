# Searchable Dropdown

[![Latest Version on Packagist](https://img.shields.io/packagist/v/teofanis/searchable-dropdown.svg?style=flat-square)](https://packagist.org/packages/teofanis/searchable-dropdown)
[![Build Status](https://img.shields.io/travis/teofanis/searchable-dropdown/master.svg?style=flat-square)](https://travis-ci.org/teofanis/searchable-dropdown)
[![Quality Score](https://img.shields.io/scrutinizer/g/teofanis/searchable-dropdown.svg?style=flat-square)](https://scrutinizer-ci.com/g/teofanis/searchable-dropdown)
[![Total Downloads](https://img.shields.io/packagist/dt/teofanis/searchable-dropdown.svg?style=flat-square)](https://packagist.org/packages/teofanis/searchable-dropdown)

Searchable dropdown is a dropdown component built with Alpine JS, tailwind and Blade components. 
It can be used as a normal dropdown or a multiple selection dropdown.

## Installation

You can install the package via composer:

Please note if you use Livewire 2.x you should install the 1.x version of the package.


```bash
composer require teofanis/searchable-dropdown:^1.0
```
Livewire 3.x
```bash
composer require teofanis/searchable-dropdown // or composer require teofanis/searchable-dropdown:^2.0

```

Publish the dropdowns' config and asset files
```bash
php artisan vendor:publish --tag=searchable-dropdown-config
php artisan vendor:publish --tag=searchable-dropdown-assets
```
Finally add the dropdown styles and scripts in the head section of your layout file.  
```bash
@searchableDropdownStyles
@searchableDropdownScripts
```

## Usage

Here's an example of how you could use the dropdown inside your blade views.

#Simple select & Multiselect 

![dropdown](https://user-images.githubusercontent.com/47872542/111536873-b188a800-8762-11eb-806a-f45a4ed41440.gif)


-Select
```
<x-searchable-dropdown
    name="pizzas"
    entangle="pizzaType"
    :context="$this"
    :data="$pizzas"
    in_live_wire="true"
    no_results_message="No Pizzas found"
    placheholder="Choose your Pizza"
    search_placeholder="Search for pizzas..."
    />
```
-Multiselect
```
<x-searchable-dropdown
    name="toppings"
    entangle="chosenToppings"
    :context="$this"
    :data="$toppings"
    in_live_wire="true"
    :multiselect="true"
    no_results_message="No toppings found"
    placheholder="Select your toppings"
    search_placeholder="Search toppings..."
    />
```


#Customization & Props
| Props                  | Required                            | Context  | Description                                                                                                                         | Type         | Example                                                |
|------------------------|-------------------------------------|----------|-------------------------------------------------------------------------------------------------------------------------------------|--------------|--------------------------------------------------------|
| name                   | yes                      | any      | Used as "name" attribute on input fields and used to internally by the dropdown                                                                                          | string       | name="pizzaOptions"                                    |
| entangle               | Required within Livewire components | Livewire | The dropdown will share its state with the "entangled" property of the Livewire components its rendered in.                         | string       | entangle="pizzaToppings"                               |
| context                | Required within Livewire components | Livewire | The dropdown will use the context to setup the state-sharing with livewire component. (Won't be required in future release)         | LW           | :context="$this"                                       |
| inLivewire             | Required within Livewire components | Livewire | Similarly to the context prop, this  will be used in the initial setup of the component. (Won't be required in future release)      | boolean      | :in_live_wire="true"                                   |
| value                  | no                                  | any      | Used as any value attribute on input fields                                                                                         | string/array | value="old('name')" \|\| :value="[1,2,3]"              |
| data                   | yes                                 | any      | Populates the dropdown list, collection keys will be returned for selections and values will be displayed.                          | Collection   | :data="dataProvider()"                                 |
| xModel                 | no                                  | Alpine   | An option prop when you want to bind an apline js x-data field as a model of the dropdown.                                          | string       | x_model="modelName"                                    |
| multiselect            | multiselect                         | any      | Used to behave like a multiple option dropdown or a single option dropdown                                                          | boolean      | :multiselect="true"                                    |
| alignListItems         | no                                  | any      | Aligns the text on the dropdown list. You can pass a tailwind class for text-alignment e.g(text-left, text-right, text-center etc.) | string       | align_items="text-left"                                |
| disabled               | no                                  | any      | Disable the dropdown interaction                                                                                                    | boolean      | :disabled="true"                                       |
| label                  | no                                  | any      | Displays the prop value as as label of the dropdown                                                                                 | string       | label="My Dropdown Label"                              |
| placeholder            | no                                  | any      | Sets the placeholder text for the dropdown                                                                                          | string       | placeholder="My Placeholder Text"                      |
| searchFieldPlaceholder | no                                  | any      | Sets the placeholder for the search field                                                                                           | string       | search_field_placeholder="My Search field Placeholder" |
| noResultsMessage       | no                                  | any      | Sets the message of the no-results block when filtering                                                                             | string       | no_results_message="No options found"                  |

Most props have default values set in config/searchable-dropdown-config.php that serve as a base for most use-cases. 

<details>
<summary>Placeholder Defaults</summary>
    
 ```php
    
'placeholders' => [
        'default-no-results-message' => 'No Results Found',
        'default-placeholder' => 'Select an option',
        'default-search-placeholder' => 'Search...',
    ]
    
```
      
</details>
<details>
<summary>Setting Defaults</summary>
    
 ```php
      'settings' => [
        'default-is-multiselect' => false,
        'default-is-in-livewire' => false, 
        'default-list-item-alignment' => 'text-left'
    ],
    
```
        
    
</details>
<details>
<summary>Theme Styles</summary>
<p>With the theme styles, you can do some small adjustments on color pallete of the dropdown as well as style the wrapper, label or button all using tailwind classes</p>
 
 ```php
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
    
```
    
<p>To Fully customize the look & feel of the dropdown, publish the packages' views.</P>
</details>


### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email teos_97@hotmail.com instead of using the issue tracker.

## Credits

- [Teofanis Papadopulos](https://github.com/teofanis)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

