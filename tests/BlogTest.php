<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use BiboBlog\Eloquent\Blog;


class BlogTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHome()
    {
        $this->visit('/')
            ->see('Clean Blog');
    }

    public function testViewBlog()
    {
        $blog = Blog::find(1);
        $this->visit('blog/'.$blog->slug)
            ->assertResponseStatus(200);
    }

    public function testDeleteBlog()
    {
        $user = factory('BiboBlog\Eloquent\User')->create();
        $blog = Blog::find(1);
        $this->actingAs($user)
            ->visit('blog/delete/'.$blog->id)
            ->assertResponseStatus(200);
    }

    public function testEditBlog()
    {
        $user = factory('BiboBlog\Eloquent\User')->create();
        $blog = Blog::find(1);
        $this->actingAs($user)
            ->visit('blog/delete/'.$blog->id)
            ->assertResponseStatus(200);
    }
}
