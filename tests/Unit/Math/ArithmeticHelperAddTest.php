<?php

namespace Tests\Unit\Math;

use Tests\TestCase;

use App\Helpers\Math\ArithmeticHelper;


class ArithmeticHelperAddTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_add_can_sum_numbers_up(): void
    {
        $num1 = 4;
        $num2 = 6;

        $sum = $num1 + $num2;

        $result = ArithmeticHelper::add($num1, $num2);

        $this->assertSame($sum, $result, 'Failed to add.');
        
    }

    public function test_add_can_take_multiple_argument()
    {
        $num1 = 4;
        $num2 = 6;
        $num3 = 16;

        $sum = $num1 + $num2 + $num3;

        $result = ArithmeticHelper::add($num1, $num2, $num3);

        $this->assertSame($sum, $result, 'Failed to add');

    }

    public function test_add_must_have_atleast_one_argument()    
    {
        $num1 = 100;
        $sum = $num1 + 0;
        $result = ArithmeticHelper::add($num1);
        $this->assertSame($sum, $result, 'Failed.');
    }

    public function test_test_add_cannot_take_in_string_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::add('abc');
    }

    public function test_test_add_cannot_take_in_array_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::add([1,2,3,5]);
    }

    public function test_test_add_cannot_take_in_null_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::add(null);
    }

    public function test_test_add_cannot_take_in_function_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::add(fn () => 2);
    }

    public function test_test_add_cannot_take_in_boolean_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = ArithmeticHelper::add(true);
    }

    public function test_test_add_can_take_in_negative_arguments()
    {
        $num1 = -4;
        $num2 = -40;
        $sum = $num1 + $num2;

        $result = ArithmeticHelper::add($num1, $num2);

        $this->assertSame($sum, $result, 'Failed.');
    }

    public function test_test_add_can_take_in_one_negative_arguments()
    {
        $num = -4;
        $sum = $num + 0;

        $result = ArithmeticHelper::add($num);

        $this->assertSame($sum, $result, 'Failed.');
    }

    // public function test_test_add_cannot_take_in_string_arguments(){}

    public function test_add_only_takes_neumerics_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);

        $result = ArithmeticHelper::add();
    }




}
