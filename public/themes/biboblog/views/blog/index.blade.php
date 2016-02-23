<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif


        @if(isset($blogs))
                @foreach($blogs as $blog)
                    <div class="post-preview">
                        <a href="{{ url('blog/'.$blog->slug) }}">
                            <h2 class="post-title">
                                {{ $blog->title }}
                            </h2>
                            <h3 class="post-subtitle">
                                {{ strlen($blog->content) > 50 ? substr($blog->content,0,50)."..." : $blog->content }}
                            </h3>

                        </a>
                        <p class="post-meta">Posted by <a href="#">{{ $blog->author->fname }}</a> on {{ date('M d, Y', strtotime($blog->created_at)) }}</p>
                    </div>
                    <hr>

                @endforeach
                {!! $blogs->render() !!}
            @else
            @endif
        </div>
    </div>
</div>