<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
        // filter tidak dapat menampilkan super admin
        // $users = User::with('roles')->get();
        
        if (auth()->user()->hasRole("Super admin")) {
            $hanyaSantri = User::latest()->get();
            $idRole = 1;
        } elseif (auth()->user()->hasRole("BPH")) {
            $hanyaSantri = User::whereHas("roles", function($q){ $q->where("name", "Santri"); })->get();
            $idRole = 2;
        } else {
            $hanyaSantri = User::whereHas("roles", function($q){ $q->where("name", "Santri"); })->get();
            $idRole = 3;
        }

        $hanyaSantri->transform(function ($user) {
            $user->role = $user->getRoleNames()->first();
            $user->userPermissions = $user->getPermissionNames();
            return $user;
        });

        return response()->json([
            'users' => $hanyaSantri,
            'idRole' => $idRole,
            // 'kamar' => $kamar_ukniq,
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            // 'phone' => 'required',
            'password' => 'required|min:6',
            'role' => 'required',
            'email' => 'required|email|unique:users'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->phone = $request->phone;
        $user->password = bcrypt($request->password);

        if ($request->role != null) {
            $user->assignRole($request->role);
        } else {
            $user->assignRole('Santri');
        }

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
            // 'phone' => 'required',
            'password' => 'nullable|alpha_num|min:6',
            'role' => 'required',
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        // $user->phone = $request->phone;
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

    public function profile()
    {
        $photo = auth()->user()->photo;
        return view("profile.index", compact("photo"));
    }

    public function postProfile(Request $request)
    {
        // dd($request->file('photo'));
        $user = auth()->user()->id;
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'email' => 'required|email|unique:users,email,' . $user
            // 'phone' => 'required',
            // 'no_kamar' => 'required',
            // 'instansi' => 'required',
            // 'alamat' => 'required',
            // 'tahun_masuk' => 'required',
        ]);

        $updateProfile = User::findOrFail($user);
        $date = date('H-i-s');
        $random = \Str::random(5);

        if ($request->file('photo')) {
            $request->file('photo')->move('upload/profil', $date . $random . $request->file('photo')->getClientOriginalName());
            $updateProfile->photo = $date . $random . $request->file('photo')->getClientOriginalName();
        }

        $updateProfile->name = $request->name;
        $updateProfile->email = $request->email;
        $updateProfile->status = $request->status;
        // $updateProfile->phone = $request->phone;
        // $updateProfile->no_kamar = $request->no_kamar;
        // $updateProfile->instansi = $request->instansi;
        // $updateProfile->alamat = $request->alamat;
        // $updateProfile->tahun_masuk = $request->tahun_masuk;


        $updateProfile->save();
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

    public function searchKamar(Request $request)
    {
        $searchWord = $request->get('s');
        $users = User::where(function ($query) use ($searchWord) {
            $query->where('no_kamar', '=', $searchWord);
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
