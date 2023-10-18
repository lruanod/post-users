<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Post;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;






class PostController1 extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   // vista a todos los registros
        return Inertia::render('Posts/Index',[
            'posts'=>Post::all(),
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $posts = Post::where('title', 'LIKE', "%$search%")->get();
        return Inertia::render('Posts/Index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // vista para crear

        return Inertia::render('Posts/Create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // guardar en base de datos
        $request->validate([
            'title'=> 'required',

            'gallery' => 'required',
            'gallery.*' => [
                'required']
        ]);

        $post = new Post;
        $post->title =$request->title;



     //   $image_path = '';

     //   if ($request->hasFile('urls')) {
       //     $image_path = $request->file('urls')->store('urls', 'public');
        //$image = new Imagen;
        //$image->url = $image_path;
        //$image->post_id = $post->id;
        //$image->save();;
     //   }

        //   $image_path = '';
        $imagenes=[];
        $imagenes=$request->file('urls');

     // if ($request->hasFile('urls')) {
    //    foreach ($imagenes as $key => $file) {
    //    $file = $imagenes[$key]->store('urls', 'public');
    //    $image_path = $file;
    //       $image = new Imagen;
    //    $image->url = $image_path;
    //    $image->post_id = $post->id;
    //    $image->save();;
    //  }



        foreach ($imagenes as $image) {
            // Subir la imagen al disco public_upload con un nombre único
            $path = Storage::disk('public')->putFile('images', $image);

            $imagem = new Imagen;
            $imagem->url = $path;
            $imagem->post_id = $post->id;
            $imagem->save();;
            // Opcionalmente, puedes renombrar la imagen con el método move()
            // $filename = time() . '.' . $image->extension();
            // $image->move(public_path('images'), $filename);
            // $path = 'images/' . $filename;

            // Agregar el path al array de paths
            $paths[] = $path;
        }




        $post->save();




        return redirect()->route('posts.index');

    }



    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // mostrar formulario para editar

        return Inertia::render('Posts/Show',[
            'post'=> $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // editar y registrar formulario en la bd
        $post =Post::find($request->id);
        $post->title =$request->title;
        $post->save();
        return redirect()->route('posts.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}
