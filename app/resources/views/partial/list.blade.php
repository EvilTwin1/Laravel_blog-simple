@extends('layout', ['title' => 'Главная страница'])

@section('content')

    @forelse($posts as $post)

    <div class="col-lg-6">
        <div class="card" style="margin-bottom: 15px">
            <img src="{{ isset($post->img) ? asset('uploads').'/'.$post->img : 'http://placeimg.com/640/480/any'}}" class="card-img-top" alt="img">
            <div class="card-body">
                <h5 class="card-title">{{ $post->short_title }}</h5>
                <p class="card-text">{{ $post->descr }}</p>
                <p class="card-text">{{ $post->name }}</p>
                <a href="{{ route('post.show', ['post' => $post->post_id]) }}" class="btn btn-primary">Смотреть</a>
            </div>
        </div>
    </div>
    @empty
        <p>No posts</p>
    @endforelse
    @if(!isset($_GET['search']))
    {{ $posts->links() }}
    @endif
@endsection
