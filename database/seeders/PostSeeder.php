<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\EnableDisableForeignKey;
use App\Models\Post;
use App\Models\User;
// use App\Models\Comment;
use Database\Factories\Helpers\FactoryHelper;

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
        $posts = Post::factory(150)
                // ->has(Comment::factory(3), 'comments')
                // ->untitled()
                ->create();

        $posts->each(function(Post $post){
            $post->users()->sync([FactoryHelper::getRandomModelId(User::class)]);
        });

        // Enable FOREIGN_KEY_CHECKS
        $this->enableforeignkey();
    }
}
