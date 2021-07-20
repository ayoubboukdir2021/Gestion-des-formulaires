<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Form;
use App\Models\FormUser;
use App\Models\User;
use App\Models\Question;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','checkuser']);
    }

    public function index() {
        $forms = Form::whereStatus(1)->with("questions")->get();
        // $form = $form->first();
        $userId = Auth::user()->id;

        foreach ($forms as $form) {
            $formUser = FormUser::where(["user_id"=> $userId , "form_id" =>$form->id])->get();
            if(count($formUser) == 0)
                return view('pages.users.home' , ["forms"=>$form]);
        }

        return view('pages.users.home' , ["forms"=>null]);
    }

    public function profile() {
        return view('pages.users.profile');
    }

    public function store(Request $request , $id){


        $names = $request->keys();


        $formUser = new FormUser();
        $formUser->form_id = $id;
        $formUser->user_id = Auth::user()->id;
        $formUser->save();


        // 'username'      => 'required|unique:users',
        // 'email'         => 'required|email',
        // 'image'         => 'nullable|image|max:20000,mimes:jpeg,jpg,png',
        // 'password'      => 'required|confirmed',
        // 'phone'         => 'required|numeric',
        // 'address'       => 'nullable|min:10|max:120',

        for ($i=0; $i < count($names); $i++) {
            $arrayname =  explode('_',$names[$i]);


            if($arrayname[0] == "input") {
                if($arrayname[1] == "email") {
                    $idquestion = $arrayname[3];
                    $key = $arrayname[0]."_".$arrayname[1]."_q_".$idquestion;

                    $obligatory = Question::find($idquestion)->get();
                    $obligatory = $obligatory->first()->obligatory;

                    if($obligatory == 1){
                        $validator = Validator::make($request->all(), [
                            $key => 'required|email',
                        ]);

                        if($validator->fails()) {
                            Formuser::destroy( $formUser->id);
                            return redirect()->back()->with([
                                'message' => "Il y a une question sans réponse",
                                'alert-type' => 'danger',
                            ]);
                        }
                    }

                    if($request->$key != ""){
                        $answer = new Answer();
                        $answer->reponse = $request->$key;
                        $answer->question_id = $idquestion;
                        $answer->form_user_id = $formUser->id;
                        $answer->save();
                    }

                }else if($arrayname[1] == "text"){
                    $idquestion = $arrayname[3];
                    $key = $arrayname[0]."_".$arrayname[1]."_q_".$idquestion;

                    $obligatory = Question::find($idquestion)->get();
                    $obligatory = $obligatory->first()->obligatory;

                    if($obligatory == 1){

                        $validator = Validator::make($request->all(), [
                        $key => 'required',
                        ]);

                        if($validator->fails()) {
                            Formuser::destroy( $formUser->id);
                            return redirect()->back()->with([
                                'message' => "Il y a une question sans réponse",
                                'alert-type' => 'danger',
                            ]);
                        }

                    }

                    if($request->$key != ""){
                        $answer = new Answer();
                        $answer->reponse = $request->$key;
                        $answer->question_id = $idquestion;
                        $answer->form_user_id = $formUser->id;
                        $answer->save();
                    }
                    

                }else if($arrayname[1] == "date"){
                    $idquestion = $arrayname[3];
                    $key = $arrayname[0]."_".$arrayname[1]."_q_".$idquestion;

                    $obligatory = Question::find($idquestion)->get();
                    $obligatory = $obligatory->first()->obligatory;

                    if($obligatory == 1){

                        $validator = Validator::make($request->all(), [
                            $key => 'required',
                        ]);

                        if($validator->fails()) {
                            Formuser::destroy( $formUser->id);
                            return redirect()->back()->with([
                                'message' => "Il y a une question sans réponse",
                                'alert-type' => 'danger',
                            ]);
                        }
                    }

                    if($request->$key != ""){
                        $answer = new Answer();
                        $answer->reponse = $request->$key;
                        $answer->question_id = $idquestion;
                        $answer->form_user_id = $formUser->id;
                        $answer->save();
                    }

                }else if($arrayname[1] == "file"){
                    $idquestion = $arrayname[3];
                    $key = $arrayname[0]."_".$arrayname[1]."_q_".$idquestion;
                    $file = $request->file($key);

                    $obligatory = Question::find($idquestion)->get();
                    $obligatory = $obligatory->first()->obligatory;

                    if($obligatory == 1){
                        $validator = Validator::make($request->all(), [
                            $key => 'required|mimes:pdf,xlx,csv,jpeg,jpg,png|max:2048',
                        ]);


                        if($validator->fails()) {
                            Formuser::destroy( $formUser->id);

                            return redirect()->back()->with([
                                'message' => "Fichier : pdf,xlx,csv,jpeg,jpg,png",
                                'alert-type' => 'danger',
                            ]);
                        }
                    }

                    $filename = $idquestion.'.'.$file->getClientOriginalExtension();


                    $formuser1 = $id."-".$formUser->id;

                    $path = public_path().'/assets/users/forms/'. $formuser1."/";

                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path , 0777, true, true);
                        $file->move($path, $filename);
                    } else {
                        $file->move($path, $filename);
                    }


                    if($filename != ""){
                        $answer = new Answer();
                        $answer->reponse =  $filename;
                        $answer->question_id = $idquestion;
                        $answer->form_user_id = $formUser->id;
                        $answer->save();
                    }

                }else if($arrayname[1] == "time"){
                    $idquestion = $arrayname[3];
                    $key = $arrayname[0]."_".$arrayname[1]."_q_".$idquestion;

                    $obligatory = Question::find($idquestion)->get();
                    $obligatory = $obligatory->first()->obligatory;

                    if($obligatory == 1){

                        $validator = Validator::make($request->all(), [
                            $key => 'required',
                        ]);

                        if($validator->fails()) {
                            Formuser::destroy( $formUser->id);
                            return redirect()->back()->with([
                                'message' => "Il y a une question sans réponse",
                                'alert-type' => 'danger',
                            ]);
                        }
                    }

                    if($request->$key != ""){
                        $answer = new Answer();
                        $answer->reponse = $request->$key;
                        $answer->question_id = $idquestion;
                        $answer->form_user_id = $formUser->id;
                        $answer->save();
                    }

                }else if($arrayname[1] == "radio"){
                    $idquestion = $arrayname[3];

                    $key = $arrayname[0]."_".$arrayname[1]."_q_".$idquestion;

                    $obligatory = Question::find($idquestion)->get();
                    $obligatory = $obligatory->first()->obligatory;

                    if($obligatory == 1){

                        $validator = Validator::make($request->all(), [
                            $key => 'required',
                        ]);

                        if($validator->fails()) {
                            Formuser::destroy( $formUser->id);
                            return redirect()->back()->with([
                                'message' => "Il y a une question sans réponse",
                                'alert-type' => 'danger',
                            ]);
                        }
                    }

                    if($request->$key != ""){
                        $answer = new Answer();
                        $answer->reponse = $request->$key;
                        $answer->question_id = $idquestion;
                        $answer->form_user_id = $formUser->id;
                        $answer->save();
                    }


                }else if($arrayname[1] == "checkbox"){
                    $idquestion = $arrayname[3];
                    $option = $arrayname[4];

                    $key = $arrayname[0]."_".$arrayname[1]."_q_".$idquestion."_".$option;

                    if($request->$key != null) {
                        $answer = new Answer();
                        $answer->reponse = $request->$key;
                        $answer->question_id = $idquestion;
                        $answer->form_user_id = $formUser->id;
                        $answer->save();
                    }else{
                        $answer = new Answer();
                        $answer->reponse = "no reponse";
                        $answer->question_id = $idquestion;
                        $answer->form_user_id = $formUser->id;
                        $answer->save();
                    }
                }
            } else if($arrayname[0] == "select") {
                $idquestion = $arrayname[2];
                $key = $arrayname[0]."_q_".$idquestion;

                if($request->$key != ""){
                    $answer = new Answer();
                    $answer->reponse = $request->$key;
                    $answer->question_id = $idquestion;
                    $answer->form_user_id = $formUser->id;
                    $answer->save();
                }
            }else if($arrayname[0] == "textarea") {
                $idquestion = $arrayname[2];
                $key = $arrayname[0]."_q_".$idquestion;

                $obligatory = Question::find($idquestion)->get();
                $obligatory = $obligatory->first()->obligatory;

                if($obligatory == 1){

                    $validator = Validator::make($request->all(), [
                        $key => 'required',
                    ]);

                    if($validator->fails()) {
                        Formuser::destroy( $formUser->id);
                        return redirect()->back()->with([
                            'message' => "Il y a une question sans réponse",
                            'alert-type' => 'danger',
                        ]);
                    }
                }

                if($request->$key != ""){
                    $answer = new Answer();
                    $answer->reponse = $request->$key;
                    $answer->question_id = $idquestion;
                    $answer->form_user_id = $formUser->id;
                    $answer->save();
                }
            }

        };



        return redirect()->route("user.index")->with([
            'message' => 'Données enregistrées avec succès',
            'alert-type' => 'success',
        ]);
    }

}
