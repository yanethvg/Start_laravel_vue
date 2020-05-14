<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'pusher','middleware' => ['auth']], function()
{
	Route::post('posts/{id}', function($id, \Illuminate\Http\Request $request){
		$comment = new \App\Comment([
			'comment' => $request->input('comment'),
			'user_id' => auth()->user()->id,
			'post_id' => $id
		]);
        $comment->save();
        # para evitar duplicacion del comentario por eso evitamos a todos menos a nosotros
        #broadcast(new \App\Events\FireComment($comment))->toOthers();
        #broadcast(new \App\Events\FireComment($comment))->toOthers();
        App\Events\FireComment::dispatch($comment);

    })->name('comments.create');
    #retorna vista
	Route::get('posts/{id}', function($id)
	{
		$post = \App\Post::findOrFail($id);
		return view('chat', compact('post'));
    });
    #retorna json de los comentarios
	Route::get('comments/{id}', function($id)
	{
		$comments = \App\Comment::where('post_id', $id)->with('user')->get();
		return response()->json($comments);
    })->name('comments.list');
});


Route::get('vue/users', function()
{
    return view('users');
});

Route::resource('users', 'UserController', ['only' => [
    'index', 'store', 'update', 'destroy'
]]);

