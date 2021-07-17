<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','checkadmin']);
    }

    public function index() {
        $users = User::with('role')->where('id','!=',1)->orWhere('id','!=',2);
        return view('pages.index' , ['page'=>'dashboard']);
    }

    public function create() {
        return view('pages.addUser',['page'=>'gestion-utilisateurs']);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [

            'name'          => 'required|min:4|max:20',
            'username'      => 'required|unique:users',
            'email'         => 'required|email',
            'image'         => 'nullable|image|max:20000,mimes:jpeg,jpg,png',
            'password'      => 'required|confirmed',
            'phone'         => 'required|numeric',
            'address'       => 'nullable|min:10|max:120',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($image = $request->file('image')) {

            try{

                $user = new User();

                $user->name     = $request->name;
                $user->username = $request->username;
                $user->email    = $request->email;
                $user->password = Hash::make($request->password);
                $user->image    = '';
                $user->address  = $request->address;
                $user->phone    = $request->phone;
                $user->role_id  = $request->role;
                $user->status  = 1;
                $user->save();

                $filename = Str::slug($request->username).'.'.$image->getClientOriginalExtension();

                $image->move("assets/users",$filename);


                // $path = public_path('assets/users/'.$user->id . '/'. $filename);

                // Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($path, 100);

                $user->image = $filename;
                User::updated($user);

                if($request->role == "1"){
                    return redirect()->back()->with([
                        'message' => 'Administrateur ajouté avec succès',
                        'alert-type' => 'success',
                    ]);
                } else if($request->role == "2") {
                    return redirect()->back()->with([
                        'message' => 'Superviseur ajouté avec succès',
                        'alert-type' => 'success',
                    ]);
                }

            }catch(\Exception $e){
                return redirect()->back()->with([
                    'message' => $e->getMessage(),
                    'alert-type' => 'danger',
                ]);
            }
        }else {
            try{

                $user = new User();

                $user->name     = $request->name;
                $user->username = $request->username;
                $user->email    = $request->email;
                $user->password = Hash::make($request->password);
                $user->address  = $request->address;
                $user->phone    = $request->phone;
                $user->role_id  = $request->role;
                $user->status  = 1;

                $user->save();

                if($request->role == "1"){
                    return redirect()->back()->with([
                        'message' => 'Administrateur ajouté avec succès',
                        'alert-type' => 'success',
                    ]);
                } else if($request->role == "2") {
                    return redirect()->back()->with([
                        'message' => 'Superviseur ajouté avec succès',
                        'alert-type' => 'success',
                    ]);
                }

            }catch(\Exception $e){
                return redirect()->back()->with([
                    'message' => 'Vérifiez les informations que vous avez saisies',
                    'alert-type' => 'danger',
                ]);
            }
        }

    }

    public function profile () {
        return view('pages.profile',['page'=>'profile']);
    }

    public function update_profile (Request $request) {
        $validator = Validator::make($request->all(), [

            'name'          => 'required|min:4|max:20',
            'email'         => 'required|email|unique:users,email,'. Auth::user()->id,
            'image'         => 'nullable|image|max:20000,mimes:jpeg,jpg,png',
            'phone'         => 'required|numeric',
            'address'       => 'nullable|min:10|max:120',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($image = $request->file('image')) {

            try{

                $id = Auth::user()->id;

                $user = User::findOrFail($id);

                $filename = Str::slug(Auth::user()->username).'.'.$image->getClientOriginalExtension();

                $path = public_path('assets/users/'. $filename);
                Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $user->name     = $request->name;
                $user->email    = $request->email;
                $user->address  = $request->address;
                $user->image    = $filename;
                $user->phone    = $request->phone;

                $user->save();

                return redirect()->back()->with([
                    'message' => 'Modifié avec succès',
                    'alert-type' => 'success',
                ]);

            }catch(\Exception $e){
                return redirect()->back()->with([
                    'message' => $e->getMessage(),
                    'alert-type' => 'danger',
                ]);
            }
        }else {
            try{

                $id = Auth::user()->id;

                $user = User::findOrFail($id);

                $user->name     = $request->name;
                $user->email    = $request->email;
                $user->address  = $request->address;
                $user->phone    = $request->phone;

                $user->save();

                return redirect()->back()->with([
                    'message' => 'Modifié avec succès',
                    'alert-type' => 'success',
                ]);

            }catch(\Exception $e){
                return redirect()->back()->with([
                    'message' => 'Vérifiez les informations que vous avez saisies',
                    'alert-type' => 'danger',
                ]);
            }
        }
    }

    public function change_password (Request $request) {

    }
}