<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\EnableDisableForeignKey;


class UserSeeder extends Seeder
{

    use TruncateTable, EnableDisableForeignKey;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FOREIGN_KEY_CHECKS
        $this->disableforeignkey();

        // Truncate the table 
        $this->truncate('users');

        // Seed the database table
        User::factory(5)->create();

        // Enable FOREIGN_KEY_CHECKS
        $this->enableforeignkey();
    }
}

