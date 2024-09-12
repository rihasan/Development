<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait EnableDisableForeignKey
{
    /**
     * Create a new class instance.
     */

    protected function disableforeignkey()
    {
        // Disable FOREIGN_KEY_CHECKS
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    protected function enableforeignkey()
    {
        // Enable Foreign Key
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
