<?php

namespace PbbgIo\Titan\Http\Validators;

class MinIfNotEmpty {

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     * @throws \Exception
     */

    public function validate($attribute, $value, $parameters, $validator)
    {
        $min = null;
        $max = null;
        if($value == null)
        {
            return true;
        }

        switch (count($parameters))
        {
            case 1:
                $min = $parameters[0];
                return \Str::length($value) >= $min;
            case 2:
                $min = min($parameters);
                $max = max($parameters);
                return \Str::length($value) >= $min && \Str::length($value) <= $max;
            default:
                throw new \Exception("Incorrect validation parameters. Supports up to 2");
        }

    }

}
