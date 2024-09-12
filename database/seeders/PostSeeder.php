<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\EnableDisableForeignKey;
use App\Models\Post;

class PostSeeder extends Seeder
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
        $this->truncate('posts');

        // Seed the database table
        $posts = Post::factory(5)
                // ->untitled()
                ->create();

        // Enable FOREIGN_KEY_CHECKS
        $this->enableforeignkey();
    }
}
