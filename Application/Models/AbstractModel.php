<?php
namespace Application\Models;

abstract class AbstractModel
{
    public function __construct($array = null)
    {
        $currentVars = \array_keys(\get_class_vars(\get_class($this)));

        if ($array === null) {
            foreach ($currentVars as $key) {
                $this->{$key} = '';
            }
        }
        else {
            foreach ($currentVars as $key) {
                if (isset($array[$key])) {
                    $this->{$key} =  $array[$key];
                }
            }
        }
    }
}