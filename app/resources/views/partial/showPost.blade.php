@extends('layout', ['title' => "Пост № $post->post_id | $post->title"])

@section('content')
    <div class="col-lg-12">
        <div class="card" style="margin-bottom: 15px">
            <img src="{{ isset($post->img) ? asset('uploads').'/'.$post->img : 'http://placeimg.com/640/480/any'}}" class="card-img-top" alt="img">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->descr }}</p>
                <p class="card-text">Автор: {{ $post->name }}</p>
                <a href="{{ route('post.index') }}" class="btn btn-primary">На главную</a>
                @auth
                    @if(Auth::user()->id == $post->author_id)
                        <a href="{{ route('post.edit', ['post'=>$post->post_id]) }}" class="btn btn-warning">Редактировать</a>
                        <form action="{{ route('post.destroy', ['post'=>$post->post_id]) }}" method="post" style="display: inline-block;">
                    @csrf
                    @method('delete')
                            <input type="submit" class="btn btn-danger" value="Удалить">
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endsection
