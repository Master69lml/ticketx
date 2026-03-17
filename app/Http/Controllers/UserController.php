<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Company;
use DB;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);

        return view('admin.users.index', compact('data'))
            ->with('i');
    }

    public function create()
    {
        $roles = Role::lists('display_name', 'id');
        $companies = Company::where('active', true)->lists('name', 'id');

        return view('admin.users.create', compact('roles', 'companies'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles'    => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
        
        // Asignar empresas al usuario
        if ($request->has('companies')) {
            $user->companies()->attach($request->input('companies'));
        }

        return redirect()->route('users.index')
                        ->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::lists('display_name', 'id');
        $userRole = $user->roles->lists('id', 'id')->toArray();
        $companies = Company::where('active', true)->lists('name', 'id');
        $userCompanies = $user->companies->lists('id', 'id')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'userRole', 'companies', 'userCompanies'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'email'    => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles'    => 'required',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, ['password']);
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('role_user')->where('user_id', $id)->delete();

        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
        
        // Actualizar empresas del usuario
        $user->companies()->sync($request->input('companies', []));

        return redirect()->route('users.index')
                        ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('users.index')
                        ->with('success', 'User deleted successfully');
    }
}
