<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $Busqueda = $request->input('Busqueda');
        $users = User::where('name', 'LIKE', "%$Busqueda%")->paginate(3);
        return Inertia::render('Users/Index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // guardar en base de datos
        $request->validate([
            'name'=> 'required|string|min:4|max:5000',
            'email'=> 'required|email|max:45|unique:users',
            'password'=> 'required|string|min:4|max:200',
        ]);


        $user = new User();
        $user->name =$request->name;
        $user->email =$request->email;
        $user->password =bcrypt($request->password);
        $user->save();
        return Inertia::render('User/Create');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // mostrar formulario para editar

        $user2 =User::find($user->id);

        return Inertia::render('Users/Show',[
            'user'=> $user2
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=> 'required|string|min:4|max:100',
            'password'=> 'required|string|min:8|max:15',
        ]);
        // editar y registrar formulario en la bd
        $user =User::find($request->id);
        $user->name =$request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
