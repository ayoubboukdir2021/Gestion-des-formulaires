<?php

namespace App\Http\Controllers;

use App\Exports\AnswerExport;
use App\Models\Answer;
use App\Models\Control;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','checkadmin']);
    }

    public function index() {
        $id = Auth::user()->id;
        $form = Form::where(["user_id"=>$id,"confirm"=>0])->get();
        if(count($form )>0){
            $id = $form->first()->id;
            Form::destroy($id);
        }

        $forms = Form::with(["questions"])->get();

        return view('pages.list_forms' , ['page' => 'gestion-formulaire' , "forms" => $forms]);

    }

    public function create ( ) {
        $id = Auth::user()->id;
        $form = Form::where(["user_id"=>$id,"confirm"=>0])->get();
        if(count($form )>0){
            $id = $form->first()->id;
            Form::destroy($id);
        }

        return view('pages.add_form' , ['page'=>'gestion-formulaire']);
    }

    public function store (Request $request) {
        $id = Auth::user()->id;
        $form = Form::where(["user_id"=>$id ,'confirm'=>0])->get();
        $form = $form->first();

        $form->status = 1;
        $form->confirm = 1;
        $form->save();

        return redirect()->route("index.forms")->with([
            'message' => 'Formulaire ajouté avec succès',
            'alert-type' => 'success',
        ]);
    }

    public function addfield(Request $request) {
        $id = Auth::user()->id;
        $form = Form::where(["user_id"=>$id,"confirm"=>0])->get();

        if(count($form) == 0)
        {
            if($request->controltype == "text") {
                $formulaire = new Form();
                $formulaire->title = $request->formulaire;
                $formulaire->description = $request->description;
                $formulaire->status = 0;
                $formulaire->user_id = $id;
                $formulaire->save();

                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $formulaire->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"if - text"
                ]);
            } else if($request->controltype == "textarea") {
                $formulaire = new Form();
                $formulaire->title = $request->formulaire;
                $formulaire->description = $request->description;
                $formulaire->status = 0;
                $formulaire->user_id = $id;
                $formulaire->save();

                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $formulaire->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"if - textarea"
                ]);
            } else if($request->controltype == "email") {
                $formulaire = new Form();
                $formulaire->title = $request->formulaire;
                $formulaire->description = $request->description;
                $formulaire->status = 0;
                $formulaire->user_id = $id;
                $formulaire->save();

                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $formulaire->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"if - email"
                ]);
            } else if($request->controltype == "date") {
                $formulaire = new Form();
                $formulaire->title = $request->formulaire;
                $formulaire->description = $request->description;
                $formulaire->status = 0;
                $formulaire->user_id = $id;
                $formulaire->save();

                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $formulaire->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"if - date"
                ]);
            } else if($request->controltype == "file") {
                $formulaire = new Form();
                $formulaire->title = $request->formulaire;
                $formulaire->description = $request->description;
                $formulaire->status = 0;
                $formulaire->user_id = $id;
                $formulaire->save();

                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $formulaire->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"if - file"
                ]);
            } else if($request->controltype == "time") {
                $formulaire = new Form();
                $formulaire->title = $request->formulaire;
                $formulaire->description = $request->description;
                $formulaire->status = 0;
                $formulaire->user_id = $id;
                $formulaire->save();

                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $formulaire->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"if - time"
                ]);
            } else if($request->controltype == "radio") {
                $formulaire = new Form();
                $formulaire->title = $request->formulaire;
                $formulaire->description = $request->description;
                $formulaire->status = 0;
                $formulaire->user_id = $id;
                $formulaire->save();

                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $formulaire->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                $nombre = $request->nombreoption;
                $data[] = $request->all();

                for ($i=1; $i <= $nombre; $i++) {
                    $nameoption = "option".$i;
                    $option = new Option();
                    $option->attr_name = "reponse_Q_R_".$question->id;
                    $option->value = $data[0][$nameoption];
                    $option->control_id = $control->id;
                    $option->save();
                };

                return response()->json([
                    'status'=>200,
                    'message'=>"if - radio",
                ]);
            } else if($request->controltype == "checkbox") {
                $formulaire = new Form();
                $formulaire->title = $request->formulaire;
                $formulaire->description = $request->description;
                $formulaire->status = 0;
                $formulaire->user_id = $id;
                $formulaire->save();

                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $formulaire->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                $nombre = $request->nombreoption;
                $data[] = $request->all();

                for ($i=1; $i <= $nombre; $i++) {
                    $nameoption = "option".$i;
                    $option = new Option();
                    $option->attr_name = "reponse_Q_".$question->id."_C_".$nameoption;
                    $option->value = $data[0][$nameoption];
                    $option->control_id = $control->id;
                    $option->save();
                };

                return response()->json([
                    'status'=>200,
                    'message'=>"if - checkbox",
                ]);
            } else if($request->controltype == "select") {
                $formulaire = new Form();
                $formulaire->title = $request->formulaire;
                $formulaire->description = $request->description;
                $formulaire->status = 0;
                $formulaire->user_id = $id;
                $formulaire->save();

                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $formulaire->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                $nombre = $request->nombreoption;
                $data[] = $request->all();

                for ($i=1; $i <= $nombre; $i++) {
                    $nameoption = "option".$i;
                    $option = new Option();
                    $option->attr_name = "reponse_Q_".$question->id."_C_".$nameoption;
                    $option->value = $data[0][$nameoption];
                    $option->control_id = $control->id;
                    $option->save();
                };

                return response()->json([
                    'status'=>200,
                    'message'=>"if - select",
                ]);
            }

        } else {
            if($request->controltype == "text") {
                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $form->first()->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"else - text"
                ]);
            }else if($request->controltype == "textarea") {
                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $form->first()->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"else - textarea"
                ]);
            }else if($request->controltype == "email") {
                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $form->first()->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"else - email"
                ]);
            }else if($request->controltype == "date") {
                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $form->first()->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"else - date"
                ]);
            }else if($request->controltype == "file") {
                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $form->first()->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"else - file"
                ]);
            }else if($request->controltype == "time") {
                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $form->first()->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                return response()->json([
                    'status'=>200,
                    'message'=>"else - time"
                ]);
            }else if($request->controltype == "radio") {
                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $form->first()->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                $nombre = $request->nombreoption;
                $data[] = $request->all();

                for ($i=1; $i <= $nombre; $i++) {
                    $nameoption = "option".$i;

                    $option = new Option();
                    $option->attr_name = "reponse_Q_R_".$question->id;
                    $option->value = $data[0][$nameoption];
                    $option->control_id = $control->id;
                    $option->save();
                };

                return response()->json([
                    'status'=>200,
                    'message'=>"else - radio",
                ]);


                return response()->json([
                    'status'=>200,
                    'message'=>"else - radio"
                ]);
            }else if($request->controltype == "checkbox") {
                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $form->first()->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                $nombre = $request->nombreoption;
                $data[] = $request->all();

                for ($i=1; $i <= $nombre; $i++) {
                    $nameoption = "option".$i;

                    $option = new Option();
                    $option->attr_name = "reponse_Q_".$question->id."_C_".$nameoption;
                    $option->value = $data[0][$nameoption];
                    $option->control_id = $control->id;
                    $option->save();
                };

                return response()->json([
                    'status'=>200,
                    'message'=>"else - checkbox",
                ]);

            }else if($request->controltype == "select") {
                $question = new Question();
                $question->title = $request->question;
                $question->obligatory = 1;
                $question->form_id = $form->first()->id;
                $question->save();

                $control = new Control();
                $control->name = $request->controlname;
                $control->type = $request->controltype;
                $control->placeholder = $request->attrplaceholder;
                $control->attr_name = "reponse_Q_".$question->id;
                $control->question_id = $question->id;
                $control->save();

                $nombre = $request->nombreoption;
                $data[] = $request->all();

                for ($i=1; $i <= $nombre; $i++) {
                    $nameoption = "option".$i;

                    $option = new Option();
                    $option->attr_name = "reponse_Q_".$question->id."_C_".$nameoption;
                    $option->value = $data[0][$nameoption];
                    $option->control_id = $control->id;
                    $option->save();
                };

                return response()->json([
                    'status'=>200,
                    'message'=>"else - checkbox",
                ]);

            }
        }
    }

    public function details(Request $request , $id) {
        $form = Form::whereId($id)->with(["questions"])->get();
        return view('pages.details' , ['page' => 'gestion-formulaire' , "form" => $form]);
    }

    public function delete($id) {
        Form::destroy($id);

        return redirect()->back()->with([
            'message' => 'La suppression a été avec succès',
            'alert-type' => 'success',
        ]);
    }

    public function editstatus($id , $type) {
        $user = Auth::user()->id;
        $form = Form::where(["id"=>$id,"user_id"=>$user])->get();

        $form = $form->first();
        $type == "actif" ? $form->status = 0 :  $form->status = 1;
        $form->save();

        return redirect()->back()->with([
            'message' => 'La modification a été avec succès',
            'alert-type' => 'success',
        ]);
    }

    public function edit($type , $id , Request $request) {
        if($type == "formulaire") {
            try{
                $form = Form::findOrfail($id)->get();

                $validator = Validator::make($request->all(), [

                    'title' => 'required|min:4|max:100',
                ]);

                if($validator->fails()) {
                    return redirect()->back()->with([
                        'message' => "Le titre du formulaire est obligatoire",
                        'alert-type' => 'danger',
                    ]);
                }

                $form = $form->first();
                $form->title = $request->title;
                $form->description = $request->description;
                $form->save();

                return redirect()->back()->with([
                    'message' => 'La modification a été avec succès',
                    'alert-type' => 'success',
                ]);

            }catch(\Exception $e){
                return redirect()->back()->with([
                    'message' => $e->getMessage(),
                    'alert-type' => 'danger',
                ]);
            }
        }
    }

    public function infoform( Request $request) {
        $idquestion = $request->id;
        $controls = Question::whereId($idquestion)->with(["controls"])->get();
        $controlId = $controls->first()->controls()->get()->first()->id;
        $options = Option::where("control_id",$controlId)->with(["control"])->get();

        $arrayInfo = [$controls->first() , $options];

        return response()->json([
            'status'  => 200,
            'message' => $arrayInfo,
        ]);
    }

    public function editquestion(Request $request) {
        if($request->control == "input"){
            if($request->type == "text"){
                $id = $request->id;
                $question = Question::whereId($id)->get();
                $control  = Control::where("question_id",$id)->get();

                $control  = $control->first();
                $question = $question->first();

                $question->title = $request->titrequestion;
                $question->obligatory = $request->obligatory;
                $question->save();

                $control->name = $request->control;
                $control->type = $request->type;
                $control->placeholder = "votre reponse";
                $control->attr_name = $request->attrname;
                $control->save();


                $arrayInfo = [$control , $question];

                return response()->json([
                    'status'  => 200,
                    'message' => $arrayInfo,
                ]);
            } else if($request->type == "email"){
                $id = $request->id;
                $question = Question::whereId($id)->get();
                $control  = Control::where("question_id",$id)->get();

                $control  = $control->first();
                $question = $question->first();

                $question->title = $request->titrequestion;
                $question->obligatory = $request->obligatory;
                $question->save();

                $control->name = $request->control;
                $control->type = $request->type;
                $control->placeholder = "E-mail";
                $control->attr_name = $request->attrname;
                $control->save();


                $arrayInfo = [$control , $question];

                return response()->json([
                    'status'  => 200,
                    'message' => $arrayInfo,
                ]);
            } else if($request->type == "date"){
                $id = $request->id;
                $question = Question::whereId($id)->get();
                $control  = Control::where("question_id",$id)->get();

                $control  = $control->first();
                $question = $question->first();

                $question->title = $request->titrequestion;
                $question->obligatory = $request->obligatory;
                $question->save();

                $control->name = $request->control;
                $control->type = $request->type;
                $control->placeholder = "Date";
                $control->attr_name = $request->attrname;
                $control->save();


                $arrayInfo = [$control , $question];

                return response()->json([
                    'status'  => 200,
                    'message' => $arrayInfo,
                ]);
            } else if($request->type == "file"){
                $id = $request->id;
                $question = Question::whereId($id)->get();
                $control  = Control::where("question_id",$id)->get();

                $control  = $control->first();
                $question = $question->first();

                $question->title = $request->titrequestion;
                $question->obligatory = $request->obligatory;
                $question->save();

                $control->name = $request->control;
                $control->type = $request->type;
                $control->placeholder = "File";
                $control->attr_name = $request->attrname;
                $control->save();


                $arrayInfo = [$control , $question];

                return response()->json([
                    'status'  => 200,
                    'message' => $arrayInfo,
                ]);
            } else if($request->type == "time"){
                $id = $request->id;
                $question = Question::whereId($id)->get();
                $control  = Control::where("question_id",$id)->get();

                $control  = $control->first();
                $question = $question->first();

                $question->title = $request->titrequestion;
                $question->obligatory = $request->obligatory;
                $question->save();

                $control->name = $request->control;
                $control->type = $request->type;
                $control->placeholder = "Time";
                $control->attr_name = $request->attrname;
                $control->save();


                $arrayInfo = [$control , $question];

                return response()->json([
                    'status'  => 200,
                    'message' => $arrayInfo,
                ]);
            } else if($request->type == "radio"){
                $id = $request->id;
                $question = Question::whereId($id)->get();
                $control  = Control::where("question_id",$id)->get();
                $controlId = $control->first()->id;

                $control  = $control->first();
                $question = $question->first();

                $question->title = $request->titrequestion;
                $question->obligatory = $request->obligatory;
                $question->save();

                $control->name = $request->control;
                $control->type = $request->type;
                $control->placeholder = "Radio";
                $control->attr_name = $request->attrname;
                $control->save();

                $options  = Option::where("control_id",$controlId)->get();

                foreach($options as $option){
                    Option::destroy($option->id);
                }

                for($i=1 ; $i <= $request->nombreoptions; $i++){
                    $op = new Option();
                    $attr = "reponse_Q_". $question->first()->id ."_R_option".$i;
                    $opval = "option".$i;
                    $op->attr_name = $attr;
                    $op->value = $request->$opval;
                    $op->control_id = $controlId;
                    $op->save();
                }

                $options1  = Option::where("control_id",$controlId)->get();
                $arrayInfo = [$control , $question , $options1];

                return response()->json([
                    'status'  => 200,
                    'message' => $arrayInfo,
                ]);

            } else if($request->type == "checkbox"){
                $id = $request->id;
                $question = Question::whereId($id)->get();

                $control  = Control::where("question_id",$id)->get();
                $controlId = $control->first()->id;

                $control  = $control->first();
                $question = $question->first();

                $question->title = $request->titrequestion;
                $question->obligatory = $request->obligatory;
                $question->save();

                $control->name = $request->control;
                $control->type = $request->type;
                $control->placeholder = "Checkbox";
                $control->attr_name = $request->attrname;
                $control->save();

                $options  = Option::where("control_id",$controlId)->get();

                foreach($options as $option){
                    Option::destroy($option->id);
                }

                for($i=1 ; $i <= $request->nombreoptions; $i++){
                    $op = new Option();
                    $attr = "reponse_Q_". $question->id ."_C_option".$i;
                    $opval = "modal_checkbox_Q_".$question->id."option_".$i;
                    $op->attr_name = $attr;
                    $op->value = $request->$opval;
                    $op->control_id = $controlId;
                    $op->save();
                }

                $options1  = Option::where("control_id",$controlId)->get();
                $arrayInfo = [$control , $question , $options1];

                return response()->json([
                    'status'  => 200,
                    'message' => $arrayInfo,
                ]);

            }
        } else if($request->control == "textarea") {
            $id = $request->id;
            $question = Question::whereId($id)->get();
            $control  = Control::where("question_id",$id)->get();

            $control  = $control->first();
            $question = $question->first();

            $question->title = $request->titrequestion;
            $question->obligatory = $request->obligatory;
            $question->save();

            $control->name = $request->control;
            $control->type = $request->type;
            $control->placeholder = "Textarea";
            $control->attr_name = $request->attrname;
            $control->save();


            $arrayInfo = [$control , $question];

            return response()->json([
                'status'  => 200,
                'message' => $arrayInfo,
            ]);
        } else if($request->type == "select"){
            $id = $request->id;
            $question = Question::whereId($id)->get();

            $control  = Control::where("question_id",$id)->get();
            $controlId = $control->first()->id;

            $control  = $control->first();
            $question = $question->first();

            $question->title = $request->titrequestion;
            $question->obligatory = $request->obligatory;
            $question->save();

            $control->name = $request->control;
            $control->type = $request->type;
            $control->placeholder = "Checkbox";
            $control->attr_name = $request->attrname;
            $control->save();

            $options  = Option::where("control_id",$controlId)->get();

            foreach($options as $option){
                Option::destroy($option->id);
            }

            for($i=1 ; $i <= $request->nombreoptions; $i++){
                $op = new Option();
                $attr = "reponse_Q_". $question->id ."_S_option".$i;

                $opval = "modal_select_Q_".$question->id."option_".$i;
                $op->attr_name = $attr;
                $op->value = $request->$opval;
                $op->control_id = $controlId;
                $op->save();
            }

            $options1  = Option::where("control_id",$controlId)->get();
            $arrayInfo = [$control , $question , $options1];

            return response()->json([
                'status'  => 200,
                'message' => $arrayInfo,
            ]);

        }
    }

    public function deletequestion($id){
        Question::destroy($id);

        return redirect()->back()->with([
            'message' => 'La suppression a été avec succès',
            'alert-type' => 'success',
        ]);
    }

    public function export($id){

        // $id = $id;
        // $answer =  Answer::with(["formuser"])->whereHas('formuser',function($query) {
            
           
        //     $query->where(["form_id"=>$id]);
        // })->get();
        
        
        
            
        return Excel::download(new AnswerExport($id), 'aswere'.date('Y-m-d').'.xlsx',\Maatwebsite\Excel\Excel::XLSX);
    }
}
