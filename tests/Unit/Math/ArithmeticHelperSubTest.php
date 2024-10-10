<?php

namespace Tests\Unit\Math;

use PHPUnit\Framework\TestCase;
use App\Helpers\Math\ArithmeticHelper;

class ArithmeticHelperSubTest extends TestCase
{
    public function test_sub_can_substruct_numbers()
    {
        $num1 = 10;
        $num2 = 15;
        $sub  = $num1 - $num2;
        $result = ArithmeticHelper::minus($num1, $num2);
        $this->assertSame($sub, $result, 'Failed.');
    }

    public function test_sub_can_take_multiple_argument()
    {
        $num1 = 10;
        $num2 = 15;
        $num3 = 2;

        $sub  = $num1 - $num2 - $num3;
        
        $result = ArithmeticHelper::minus($num1, $num2, $num3);
        $this->assertSame($sub, $result, 'Failed.');
    }


    public function test_sub_can_not_take_array_argument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::minus([1,2,3]);

    }

    public function test_sub_can_not_take_string_argument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::minus('abs');
    }

    public function test_sub_can_not_take_null_argument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::minus(null);
    }

    public function test_sub_can_not_take_boolean_argument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::minus(true);
    }

    public function test_sub_can_not_take_function_argument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::minus(fn () => 1);
    }

}
