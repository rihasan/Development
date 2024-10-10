<?php

namespace App\Helpers\Math;

class ArithmeticHelper
{
    
    public static function add(...$nums)
    {
        if (sizeof($nums) < 1) {
            throw new \InvalidArgumentException("Must have at least one argument.");
        }
            
        $sum = 0;

        foreach ($nums as $num) {
            if (is_int($num) || is_float($num)) {
                $sum += $num;
                }else{
                throw new \InvalidArgumentException('Only Neumeric arguments allowed.');
                }
            }

        return $sum;
    }

    public static function minus(...$nums)
    {
        if (sizeof($nums) < 1) {
            throw new \InvalidArgumentException("must have least arguments");
        }

        $sub = $nums[0];

        throw_if(!(is_int($sub) || is_float($sub)), \InvalidArgumentException::class);

        foreach (array_slice($nums, 1) as $num) {
            if (!(is_int($num) || is_float($num))) {
                throw new \InvalidArgumentException('Only Neumeric arguments allowed.');
            }else{
                $sub -= $num;
            }
        }

        return $sub;
    }



}

