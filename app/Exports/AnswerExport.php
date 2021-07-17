<?php

namespace App\Exports;

use App\Models\Answer;
use App\Models\Form;
use App\Models\FormUser;
use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class AnswerExport implements FromCollection , WithMapping
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $id = $this->id;

        $id = $this->id;
        $user = "";
        $question = "";
        $email = "";
        $reponse = "";
        $tableau = [];

        $answers =  Answer::with(["formuser"])->whereHas('formuser',function($query) {
            $id = $this->id;
            $query->where(["form_id"=>$id]);
        })->get();

        $form = Form::whereId($id)->get();
        $formulaire = $form->first()->title;

        foreach ($answers  as $answer) {
            $reponse = $answer->reponse;
            $question = $answer->question()->get();
            $question = $question->first()->title;

            $user = $answer->formuser()->get();
            $user = $user->first()->users()->get();
            $user = $user->first()->name;

            $email = $answer->formuser()->get();
            $email = $email->first()->users()->get();
            $email = $email->first()->email;

            $MyObject = new myObject; 
            $MyObject->property1 = $formulaire;
            $MyObject->property2 = $user;  
            $MyObject->property3 = $email ;
            $MyObject->property4 = $question  ;
            $MyObject->property5 = $reponse  ;

            $tableau[] = $MyObject;

        }
        return collect($tableau);

    }

    public function headings(): array
    {
        return [
            'Formulaire',
            'Name',
            'Email',
            "Question",
            "Reponse"
        ];
    }

    public function map($answer): array
    {
        return [
            $answer->property1,
            $answer->property2,
            $answer->property3,
            $answer->property4,
            $answer->property5,
        ];
    }
}

class myobject{
    public $property1;
    public $property2;
    public $property3;
    public $property4;
    public $property5;
}
