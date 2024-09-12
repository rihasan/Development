<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait TruncateTable
{
    /**
     * Create a new class instance.
     */
    public function truncate($table)
    {
        DB::table($table)->truncate();
    }
}
