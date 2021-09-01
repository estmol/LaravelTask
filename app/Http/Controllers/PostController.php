<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post; // 追記(Postモデルを使う)
use Illuminate\Support\Facades\Auth; // 追記(ログイン機能を使う)
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    // 投稿一覧画面表示
    public function index()
    {
        // モデルから投稿を全件取得して表示する
        $posts = Post::all();

        // 取得したデータをビューに変数として渡す
        return view('posts.index', ['posts' => $posts]);
    }

    // 登録（投稿）画面表示
    public function create()
    {
        // create.blade.phpを表示する(これから作成)
        //return view('posts.create');
        dd('投稿画面だよ‼︎');
    }

    // 登録（投稿）処理
    public function store(PostRequest $request)
    {
        // Postモデルのインスタンスを生成
        $post = new Post;

        // ユーザーが入力したリクエストの情報を格納していく
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::id(); // Auth::id()でログインユーザーのIDが取得できる

        $post->save(); // インスタンスをDBのレコードとして保存

        // 投稿一覧画面にリダイレクトさせる
        return redirect()->route('post.index');
    }

    public function show($id)
    {
    // 投稿データのIDでモデルから投稿を1件取得
    $post = Post::findOrFail($id);

    // show.blade.phpを表示する(これから作成)
    return view('posts.show', ['post' => $post]);

    }

    //編集内容受け取り、ビューにデータ送信？
    public function edit($id)
    {
    // 投稿データのIDでモデルから投稿を1件取得
    $post = Post::findOrFail($id);

    // 投稿者以外の編集を防ぐ
    if ($post->user_id !== Auth::id()) {
        return redirect('/');
    }

    // edit.blade.phpを表示する(これから作成)
    //return view('posts.edit', ['post' => $post]);
    dd('編集しようとした投稿データの情報');
    }
    //編集内容の反映？
    public function update(PostRequest $request, $id)
    {
    // 投稿データのIDでモデルから投稿を1件取得
    $post = Post::findOrFail($id);

    // 投稿者以外の更新を防ぐ
    if ($post->user_id !== Auth::id()) {
        return redirect('/');
    }

    // 編集画面から受け取ったデータをインスタンスに反映
    $post->title = $request->title;
    $post->body = $request->body;

    $post->save(); // DBのレコードを更新

    return redirect('/');
    }

    //削除機能
    public function delete($id)
    {
    // 投稿データのIDでモデルから投稿を1件取得
    $post = Post::findOrFail($id);

    // 投稿者以外の削除を防ぐ
    if ($post->user_id !== Auth::id()) {
        return redirect('/');
    }

    $post->delete(); // DBのレコードを削除

    return redirect('/');
    }
}

