<?php


namespace hala\Press\Repositories;


use hala\Press\Post;

class PostRepositories
{
    public function save($post)
    {
        Post::updateOrCreate([
            'identifier' => $post['identifier']],
            [
                'slug' => $post['title'],
                'title' => $post['title'],
                'body' => $post['body'],
                'extra' => $post['extra'] ?? null

            ]);
    }

}