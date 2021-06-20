<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function getAll()
    {
        $users = User::latest()->get();
        if (auth()->user()->hasRole("Super admin")) {
            $idRole = 1;
        } elseif (auth()->user()->hasRole("BPH")) {
            $idRole = 2;
        } else {
            $idRole = 3;
        }

        $users->transform(function ($user) {
            $user->role = $user->getRoleNames()->first();
            $user->userPermissions = $user->getPermissionNames();
            return $user;
        });

        return response()->json([
            'users' => $users,
            'idRole' => $idRole,
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'required',
            'password' => 'required|min:6',
            'role' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);

        $user->assignRole($request->role);

        if ($request->has('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        $user->save();

        return response()->json("User Created", 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'required',
            'password' => 'nullable|alpha_num|min:6',
            'role' => 'required',
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }


        if ($request->has('role')) {
            $userRole = $user->getRoleNames();
            foreach ($userRole as $role) {
                $user->removeRole($role);
            }

            $user->assignRole($request->role);
        }

        if ($request->has('permissions')) {
            $userPermissions = $user->getPermissionNames();
            foreach ($userPermissions as $permssion) {
                $user->revokePermissionTo($permssion);
            }

            $user->givePermissionTo($request->permissions);
        }


        $user->save();

        return response()->json('ok', 200);
    }


    /////////////////////// User defined Method


    public function profile()
    {
        return view("profile.index");
    }

    public function postProfile(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'no_kamar' => 'required',
            'status' => 'required',
            'instansi' => 'required',
            'alamat' => 'required',
            'tahun_masuk' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);
        $user->update($request->all());
        return redirect()->back()->with('success', 'Profile Successfully Updated');
    }

    public function getPassword()
    {
        return view('profile.password');
    }

    public function postPassword(Request $request)
    {

        $this->validate($request, [
            'newpassword' => 'required|min:6|max:30|confirmed'
        ]);

        $user = auth()->user();

        $user->update([
            'password' => bcrypt($request->newpassword)
        ]);

        return redirect()->back()->with('success', 'Password has been Changed Successfully');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json('ok', 200);
    }

    public function search(Request $request)
    {
        $searchWord = $request->get('s');
        $users = User::where(function ($query) use ($searchWord) {
            $query->where('name', 'LIKE', "%$searchWord%")
                ->orWhere('email', 'LIKE', "%$searchWord%");
        })->latest()->get();

        $users->transform(function ($user) {
            $user->role = $user->getRoleNames()->first();
            $user->userPermissions = $user->getPermissionNames();
            return $user;
        });

        return response()->json([
            'users' => $users
        ], 200);
    }
}
