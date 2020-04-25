@extends('layout',['title' => 'Создание поста'])

@section('content')
    <div class="col-lg-12">
        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>Создать пост</h3>
            <div class="form-group">
                <label for="exampleFormControlInput1">Введите заголовок</label>
                <input type="text" class="form-control" name="title" id="exampleFormControlInput1" value="{{ old('title') }}">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Введите содержимое</label>
                <textarea class="form-control" name="descr" id="exampleFormControlTextarea1" rows="5">{{ old('descr') }}</textarea>
                @error('descr')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Выберите картинку</label>
                <input type="file" class="form-control-file" name="img" id="exampleFormControlFile1">
                @error('img')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-outline-success">
            </div>
        </form>
    </div>

@endsection
