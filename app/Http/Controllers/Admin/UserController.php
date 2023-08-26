<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(auth()->user());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //

        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $userdata = User::find($id);
        $userRole = Role::all();
        return view('admin.edit', compact('userdata', 'userRole'));
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
        // $table->string('name');
        // $table->string('image')->nullable();
        // $table->string('role_id')->default(4);
        // $table->string('phone')->nullable();
        // $table->string('email')->unique();
        // $table->timestamp('email_verified_at')->nullable();
        // $table->string('password');
        // $table->rememberToken();
        // $table->timestamps();
       $this->validate($request, [
            'name'   => ['required', 'string'],
            'email'        => 'email:rfc',
            'password' => 'confirmed',
            'old_password' => 'required',
        ]);
        $user             = User::find($id);
        $user->name = $request->name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->role_id    = $request->role_id;
        $user->creator    = Auth::user()->id;

        if (File::exists($user->image)) {
            File::delete($user->image);
        }

        if ($request->hasFile('image')) {
            $filename    = Storage::put('upload/user/', $request->file('image'));
            $user->image = $filename;
        }

        if (Hash::check($request->old_password, $user->password)) {
            if ($request->password != null) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'old password not matched');
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
    }
}