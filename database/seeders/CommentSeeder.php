<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\EnableDisableForeignKey;
use App\Models\Comment;

class CommentSeeder extends Seeder
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
        $this->truncate('comments');

        // Seed the database table
        Comment::factory(60)->create();

        // Enable FOREIGN_KEY_CHECKS
        $this->enableforeignkey();
    }
}
