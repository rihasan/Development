<?php

namespace Database\Factories\Helpers;

use Illuminate\Database\Eloquent\Factories\hasFactory;

class FactoryHelper
{
    /**
     * This function generate random model id for database.
     *
     * @param string | hasFactory traits
     */


    public static function getRandomModelId(string $model)
    {
        // Get Model Count
        $count = $model::count();

        if ($count === 0) {
        	// if Model count is 0 we create a new recor and retrive the id
            return $model::factory()->create()->id;
        }else{
	        // Generate random number between 1 and model count
            return rand(1, $count);
        }
    }
}
