<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('isAdmin');
        return User::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6'
        ]);
        $request['password'] = Hash::make($request->password);
         $user = User::create($request->all());

        return [
            'status' => 200,
            'message' => 'User created successfully',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6'
        ]);
        $user->update($request->all());
        return [
            'status' => 200,
            'message' => 'User updated successfully',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('isAdmin');
        $user = User::findOrFail($id);
        $user->delete();
        return [
            'status' => 200,
            'message' => 'User deleted successfully',
        ];
    }

    public function profile()
    {
        $user = Auth::user();
        return $user;
    }
    public function updateProfile(Request $request, $id)
    {
        $user = Auth::user();
        if (!$request->password){
            $request['password'] = $user->password;
        }

        $this->validate($request, [
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:6'
        ]);

        $currentPhoto = $user->photo;
        if ($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);

            //$userPhoto = basename(public_path('/img/profile/').$currentPhoto);
            $filePath = public_path('img/profile/').$currentPhoto;
            if (file_exists($filePath)){
                unlink($filePath);
            }
        }

        if (!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        $user->update($request->all());
        return [
            'status' => 200,
            'message' => 'User profile updated successfully',
        ];
    }
    public function search(){
        if ($search = \Request::get('search')){
            $users = User::where(function ($query) use ($search){
                $query->where('email', 'LIKE', '%'.$search.'%')
                ->orWhere('first_name', 'LIKE', '%'.$search.'%');
            })->paginate(5);
            return $users;
        }
        return User::latest()->paginate(5);
    }
}
