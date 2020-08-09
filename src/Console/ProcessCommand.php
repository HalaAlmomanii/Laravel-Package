<?php


namespace hala\Press\Console;


use hala\Press\Facades\Press;
use hala\Press\Post;
use hala\Press\Repositories\PostRepositories;
use Illuminate\Console\Command;


class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'command for press';

    public function handle(PostRepositories $postRepositories)
    {
        if (Press::configuredNotPublish()) {
            return $this->warn('please publish files by running php artisan vendor:publish --tag=press-config');
        }

        $posts = Press::driver()->fetchPost();

        foreach ($posts as $post) {
            $postRepositories->save($post);

        }
    }
}