<?php

namespace BiboBlog\Http\Controllers\Api;

use BiboBlog\Http\Requests\ApiCommentStoreRequest;
use BiboBlog\Http\Requests\ApiStoreBlogRequest;
use Illuminate\Http\Request;
use BiboBlog\Http\Requests;
use BiboBlog\Http\Controllers\Controller;
use BiboBlog\Repository\BlogRepository;
use BiboBlog\Repository\CommentRepository;
use BiboBlog\Http\Controllers\Api\ApiBaseController;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiBlogController extends ApiBaseController
{
    protected $blogRepository;
    protected $commentRepository;

    public function __construct(BlogRepository $blogRepository, CommentRepository $commentRepository)
    {

        $this->blogRepository = $blogRepository;
        $this->commentRepository = $commentRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try{
            $paginate = $request->has('page') ? true : false;
            if($paginate){
                $blogs = $this->blogRepository->paginate();
            }
            else{
                $blogs = $this->blogRepository->all();
            }

            return $this->xhr($blogs, $paginate);
        } catch (\PDOException $e) {
            return $this->xhr($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->xhr($e->getMessage(), 500);
        }
    }

    /**
     * @param StoreBlogRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(ApiStoreBlogRequest $request)
    {
        try{
            $user = JWTAuth::parseToken()->authenticate();
            $data = $request->except(['username', 'password']);
            $data['user_id'] = $user->id;
            $blog = $this->blogRepository->create($data);
            return $this->xhr($blog);
        } catch (\PDOException $e) {
            return $this->xhr($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->xhr($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApiStoreBlogRequest $request, $id)
    {
        try {
            $data['title'] = $request->get('title');
            $data['content'] = $request->get('content');

            $this->blogRepository->update($data, $id);

            $blog = $this->blogRepository->find($id);

            return $this->xhr($blog);
        } catch (\PDOException $e) {
            return $this->xhr($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->xhr($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if($this->blogRepository->delete($id) > 0){
                $response = 'deleted';
                $code = 200;
            }
            else {
                $response = 'Something went wrong!';
                $code  = 400;
            }
            return $this->xhr($response, $code);

        } catch (\PDOException $e) {
            return $this->xhr($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->xhr($e->getMessage(), 500);
        }

    }

}
