<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->search)
        {
            $posts = Post::join('users', 'author_id', '=', 'users.id')
                ->where('title', 'like', '%'.$request->search.'%')
                ->orderBy('posts.created_at', 'desc')
                ->get();
            return view('partial.list', compact('posts'));
        }
        $posts = Post::join('users', 'author_id', '=', 'users.id')->orderBy('posts.created_at', 'desc')->paginate(4);
        return view('partial.list', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('partial.createPost');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //
        $post = new Post();
        $post->title = $request->title;
        $post->short_title = $request->title;
        $post->descr = $request->descr;
        $post->author_id = \Auth::user()->id;
        if($request->hasFile('img')){
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/', $filename);
            $post->img =$filename;
        }
        $post->save();
        return redirect(route('post.index'))->with('success', 'Пост добавлен успешно');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::join('users', 'author_id', '=', 'users.id')->find($id);
        if (!$post){
            return redirect(route('post.index'))->with('error','Вы пытались куда-то не туда зайти');
        }
        return view('partial.showPost', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);

        if ($post->author_id != \Auth::user()->id){
            return redirect(route('post.index'))->with('error','Вы не можете редактировать данный пост');
        }

        return view('partial.editPost', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function update(PostRequest $request, $id)
    {
        //
        $post = Post::find($id);
        if ($post->author_id != \Auth::user()->id){
            return redirect(route('post.index'))->with('error','Вы не можете редактировать данный пост');
        }
        $post->title = $request->title;
        $post->short_title = $request->title;
        $post->descr = $request->descr;
        if($request->hasFile('img')){
            if ($post->img != null){
                unlink(public_path('uploads/' . $post->img));
                $file = $request->file('img');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/', $filename);
                $post->img =$filename;
            }else{
                $file = $request->file('img');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/', $filename);
                $post->img =$filename;
            }
        }

        $post->update();

        return redirect(route('post.show', ['post'=> $post->post_id] ))->with('success', 'Пост отредактирован успешно');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        if ($post->author_id != \Auth::user()->id){
            return redirect(route('post.index'))->with('error','Вы не можете редактировать данный пост');
        }
        if ($post->img != null) {
            unlink(public_path('uploads/' . $post->img));
        }
        $post->delete();
        return redirect(route('post.index'))->with('success', 'Пост успешно удален');
    }
}
