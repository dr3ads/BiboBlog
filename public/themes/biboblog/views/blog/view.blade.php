@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(Auth::user() && Auth::user()->id == $blog->user_id)
    <div class="row">
        <div class="form-group col-xs-12">
            <a href="{{ url('blog/edit/'.$blog->id) }}" class="btn btn-default">Edit</a>
            <a href="{{ url('blog/delete/'.$blog->id) }}" class="btn btn-default">Delete</a>
        </div>
    </div>
    @endif
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                {{ $blog->content }}
            </div>
        </div>
    </div>
</article>

<hr>

<div class="comment-form">
    <h3>New Comment</h3>
    <form name="blog_create" id="blog_create" method="POST" action="{{ url('blog/comment') }}">
        {!! csrf_field() !!}
        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
        <div class="row control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
                <label>Comment</label>
                <textarea rows="5" class="form-control" name="content" placeholder="content" id="content" required data-validation-required-message="Comment is Required."></textarea>
                <p class="help-block text-danger"></p>
            </div>
        </div>
        <br>
        <div id="success"></div>
        <div class="row">
            <div class="form-group col-xs-12">
                <button type="submit" class="btn btn-default">Comment!</button>
            </div>
        </div>
    </form>
</div>
<hr>
<div class="comments">
    <h3>Comments </h3>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="comments">
                    @if(count($blog->comments) > 0)
                        @foreach($blog->comments as $comment)
                            <div class="comment">
                                {{ $comment->content }}
                            </div>
                            <p class="comment-meta">Comment by <a href="#">{{ $comment->author->full_name }}</a> on {{ date('M d, Y', strtotime($comment->created_at)) }}</p>
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<hr>