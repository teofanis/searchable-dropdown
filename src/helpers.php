<?php

function getUniqueDropdownName($parent_id = null, $entagle = null)
{
    $randomNums = Str::random(15);
    $uniqueID = 'searchableDropdownData_'.$randomNums;
    if($parent_id){
        $sess_id = "{$parent_id}_{$entagle}";
        // TODO : somehow cleanup session at some point ????
        if(session()->has($sess_id)){
            $uniqueID = session()->get($sess_id);
        } else { 
            session()->put($sess_id, $uniqueID);       
        }
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

function getDropdownDataSet($data)
{
    if (!$data ) {
        return collect()->toJson();
    }
    $data=collect($data);
    if (is_scalar($data->first())) {
        $data=collect($data)->map(fn($value,$key)=>['key'=>$key, 'value'=>$value]);
    } 
    $data = json_encode($data->values()->toArray());
    return $data;
}
