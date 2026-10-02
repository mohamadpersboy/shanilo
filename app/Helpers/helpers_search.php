<?php
function anyStrInSearch($input)
{
    $input = trim($input);
    $input = str_replace(' ', '%', $input);
    $input = '%' . $input . '%';
    return $input;
}

