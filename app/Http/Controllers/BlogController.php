<?php

namespace BiboBlog\Http\Controllers;

use BiboBlog\Http\Requests\CommentStoreRequest;
use BiboBlog\Http\Requests\StoreBlogRequest;
use Illuminate\Http\Request;

use BiboBlog\Http\Requests;
use BiboBlog\Http\Controllers\BaseController;
use BiboBlog\Http\Controllers\Controller;
use BiboBlog\Repository\BlogRepository;
use BiboBlog\Repository\CommentRepository;
use Theme;
use Auth;

class BlogController extends BaseController
{
    protected $blogRepository;
    protected $commentRepository;

    public function __construct(BlogRepository $blogRepository, CommentRepository $commentRepository)
    {


        $this->blogRepository = $blogRepository;
        $this->commentRepository = $commentRepository;
        $this->theme_name = 'biboblog'; //value can be save in the .env file

        $this->theme = Theme::uses($this->theme_name)->layout($this->layout);

        $this->theme->set('title','Blogs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $data = array();
        $data['blogs'] = $this->blogRepository->paginate();

        return $this->theme->scope('blog.index', $data)->render();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $data = array();

        return $this->theme->scope('blog.create', $data)->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBlogRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $blog = $this->blogRepository->create($data);

        return redirect('blogs')->with('status', 'Blog Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data = array();
        $data['blog'] = $this->blogRepository->findBy('slug', $slug);

        $this->theme = Theme::uses($this->theme_name)->layout('blog');
        $this->theme->set('title', $data['blog']->title);
        $this->theme->set('author', $data['blog']->author->full_name);
        $this->theme->set('created_at', $data['blog']->created_at);

        return $this->theme->scope('blog.view', $data)->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['blog'] = $this->blogRepository->findBy('id', $id);

        return $this->theme->scope('blog.edit', $data)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBlogRequest $request, $id)
    {
        $data['title'] = $request->get('title');
        $data['content'] = $request->get('content');

        $this->blogRepository->update($data, $id);
        $blog = $this->blogRepository->find($id);
        return redirect('blog/'.$blog->slug)->with('status', 'Blog Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = $this->blogRepository->delete($id);

        return redirect('blogs')->with('status', 'Blog Deleted');

    }

    public function commentStore(CommentStoreRequest $request)
    {
        $data = array();
        $data['content'] = $request->get('content');
        $data['blog_id'] = $request->get('blog_id');
        $data['user_id'] = Auth::user()->id;

        $blog = $this->blogRepository->find($data['blog_id']);

        $blog->comments()->create($data);

        return redirect('blog/'.$blog->slug)->with('status', 'Comment Created');
    }
}
