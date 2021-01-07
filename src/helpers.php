<?php

function getUniqueDropdownName($parent_id = null)
{
    $randomNums = Str::random(15);
    $uniqueID = 'searchableDropdownData_'.$randomNums;
    if($parent_id){
        if(session()->has($parent_id)){
            return session()->get($parent_id);
        }  
        session()->put($parent_id, $uniqueID);       
    }
    return $uniqueID;
}

function searchableDropdownProps() {
    return config('searchable-dropdown-props');
}
function getTheme() {
    return [
        'default-text-color' => config('searchable-dropdown-config.styles.theme.default-text-color'),
        'default-primary-color' => config('searchable-dropdown-config.styles.theme.default-primary-color'),
        'default-secondary-color' => config('searchalbe-dropdown-config.styles.theme.default-secondary-color')
    ];
}

function getDropdownDataSet($provider)
{
    $data = function_exists($provider)
        ? call_user_func($provider)
        : $provider;
    if ($data instanceof Illuminate\Database\Eloquent\Collection){
        $data = $data->toJson();
    } else if(is_array($data)){
        $data = json_encode($data);
    }
    return $data;
}
