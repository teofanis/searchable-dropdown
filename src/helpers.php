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