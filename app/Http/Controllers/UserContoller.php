<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuario.index');
    }

    public function all()
    {
        // dd('holamundo');
        return response()->json( User::paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nmae'=>'required',
            'email'=>'required|email|unique|:users,email',
            'password'=>'required|same:confirm-password',
            'roles'=>'required'
        ]);

        $input = $request->all();
        $input['password']=Hash::make($input['password']);

        $user = User::create('$input');
        $user->assingRole($request->input('roles'));

        return redirect()->route('usuario.index');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole  = $user->roles->pluck('name','name')->all();

        return view('Usuarios.editar',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nmae'=>'required',
            'email'=>'required|email|unique|:users,email'.$id,
            'password'=>'required|same:confirm-password',
            'roles'=>'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])){
            $input['password']= hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('passwors'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assingRole($request->input('roles'));
        return redirect()->route('usuarios.index');
    }

    public function updateStatus (int $id,Request $request){
        user::where('id',$id)->update([
            'status'=> $request->get('status')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.destroy');
    }
}
