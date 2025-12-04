<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $user;
    protected $id;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->id = $this->user->id;
    }

    public function getAccountPage()
    {
        return view('account.dashboard')->withAccount($this->user);
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email|min:3|unique:users,email,'.$this->id,
            'fullname'  => 'required|min:3',
        ]);

        $values = $request->all();
        $this->user->fill($values)->save();

        return redirect()->back()->with('info', 'Your Profile has been updated successfully');
    }

    public function updateAvatar(Request $request)
    {
        $this->validate($request, [
            'file_name'     => 'required|mimes:jpeg,bmp,png|between:1,7000',
        ]);

        // Obtener el archivo subido
        $file = $request->file('file_name');
        
        // Generar un nombre único para el archivo
        $filename = time() . '_' . $this->user->id . '.' . $file->getClientOriginalExtension();
        
        // Mover el archivo a la carpeta public/uploads/avatars
        $file->move(public_path('uploads/avatars'), $filename);
        
        // Construir la URL del avatar
        $fileUrl = url('uploads/avatars/' . $filename);

        // Eliminar avatar anterior si existe y no es gravatar
        if ($this->user->avatar && strpos($this->user->avatar, 'uploads/avatars') !== false) {
            $oldFile = public_path(parse_url($this->user->avatar, PHP_URL_PATH));
            if (file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }

        $this->user->update(['avatar' => $fileUrl]);

        return redirect()->back()->with('info', 'Your Avatar has been updated Successfully');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $this->user->password = Hash::make($request->password);
        $this->user->save();

        return redirect()->back()->with('info', 'Password successfully updated');
    }

    public function redirectToConfirmDeletePage()
    {
        return view('account.confirm');
    }

    public function dontDeleteAccount()
    {
        return redirect('/account');
    }

    public function deleteAccount(Request $request)
    {
        $this->user->delete();

        $request->session()->flush();

        return redirect('/');
    }
}
