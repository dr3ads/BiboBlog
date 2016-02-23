<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @var string
     */
    private $table_name = 'blogs';

    public function testSignin()
    {
        $this->post('/auth/signin', [
            'user'     => '123456',
            'password' => '123456'
        ])->seeStatusCode(200);
        /*$response = $this->call('POST', '/auth/signin', ['user' => '123456', 'password' => '123456']);

        $this->assertEquals(200, $response->status());*/
    }

    /**
     * Test film category create.
     */
    public function testCreateBlog()
    {
        $loginData = $this->login();

        $data = json_decode($loginData);

        $this->json('POST','/api/create',
            [
                'title' => 'asdfsa dfsdf asdfsadfsfs;fkiors ',
                'content' => 'Your reception site sets the stage for the entire party.'
                     . 'Think about your wedding style, your guest list size and '
                     . 'the general mood you want to set as you tour venues.',
            ], [
                'Authorization' => 'Bearer ' . $data->text,
            ]
        )->seeJson([
            'code' => 200,
        ]);
    }

    /**
     *  Test film category show.
     */
    public function testEditBlog()
    {
        $loginData = $this->login();
        $data = json_decode($loginData);

        $this->json('POST','/api/edit/1',
            [
                'title' => 'asdfsa dfsdf asdfsadfsfs;fkiors ',
                'content' => 'Your reception site sets the stage for the entire party.'
                    . 'Think about your wedding style, your guest list size and '
                    . 'the general mood you want to set as you tour venues.',

            ], [
                'Authorization' => 'Bearer ' . $data->text,

            ])
            ->seeJson([
                'code' => 200,
            ]);
    }

    public function testDeleteBlog()
    {
        $loginData = $this->login();
        $data = json_decode($loginData);

        $this->json('POST','/api/delete/1',[],
             [
                'Authorization' => 'Bearer ' . $data->text,
             ])
            ->seeJson([
                'code' => 200,
            ]);
    }

    public function testListBlogs()
    {
        $loginData = $this->login();
        $data = json_decode($loginData);

        $this->json('GET','/api/get_all_blog',[],
            [
                'Authorization' => 'Bearer ' . $data->text,
            ])
            ->seeJson([
                'code' => 200,
            ]);
    }
}
