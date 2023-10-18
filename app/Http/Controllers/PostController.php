<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Post;
use App\Models\TemporaryImage;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;






class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   // vista a todos los registros

        $Busqueda = $request->input('Busqueda');
        $posts = Post::with('imagens')->where('title', 'LIKE', "%$Busqueda%")->paginate(10);
        return Inertia::render('Posts/Index', compact('posts'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        $temporaryImages = TemporaryImage::all();

        if ($validator->fails()) {
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return to_route('posts.create')->withErrors($validator)->withInput();
        }

        $post = Post::create($validator->validated());

        foreach ($temporaryImages as $temporaryImage) {
            Storage::copy('images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, 'images/' . $temporaryImage->folder . '/' . $temporaryImage->file);
            Imagen::create([
                'url' => $temporaryImage->file,
                'post_id' => $post->id,
                'carpeta' => $temporaryImage->folder
            ]);
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }


        return Inertia::render('Posts/Create',[
            'successMessage' => '¡El "post" se ha registrado exitosamente!'
         ]);

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

        $request->validate([
            'title'=> 'required|string|min:4|max:5000'
        ]);
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
        $imagenes= Imagen::where('post_id','=',$post->id)->get();
        foreach ($imagenes as $img){
            Storage::delete("images/".$img->carpeta."/".$img->url);
            Storage::deleteDirectory("images/".$img->url);

            Imagen::find($img->id)->delete();
        }


        $post->delete();
        return redirect()->route('posts.index');
    }


    public function destroyimg(Imagen $imagen)
    {
            Storage::delete("images/".$imagen->carpeta."/".$imagen->url);
            Storage::deleteDirectory("images/".$imagen->url);

            Imagen::find($imagen->id)->delete();

        return redirect()->route('posts.index');
    }
}
