@extends('layouts.master')

@section('title')
    Détails du formulaire
@stop

@section('content')
<div class="page-heading">
    <h3>Détails du formulaire</h3>
</div>

<div class="container-fluid">
    @include('partials.flash')
</div>

<div class="page-content">
        <div class="card border" id="component1" name="component">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <h2>{{ $form->first()->title }}</h2>
                        @if($form->first()->description != null)
                            <p>{{ $form->first()->description }}</p>
                        @endif
                    </div>
                    @if(Auth::user()->id == $form->first()->user_id)
                        <div class="col-md-2">
                            <button type="button" class="btn btn-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#form_edit"
                                    data-title="{{ $form->first()->title }}"
                                    data-description="{{ $form->first()->description }}">
                                    <i class="bi bi-brush"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @foreach ($form->first()->questions()->get() as $question)
            <div class="card border border-primary" id="component{{$question->id}}" name="component">
                <div class="card-body">
                    <div clas="row">
                        <div class="col-md-10">
                            <h5 id="{{ $question->controls()->get()->first()->attr_name }}">{{ $question->title }} </h5>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            @foreach ($question->controls()->get() as $control)
                                @if( $control->name == "input")
                                    @if($control->type == "text")
                                        @if(Auth::user()->id == $form->first()->user_id)
                                                <button type="button" class="btn btn-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#question_edit_{{ $question->id }}"
                                                        onclick="question({{ $question->id }})">
                                                        <i class="bi bi-brush"></i>
                                                </button>
                                                <button class="btn btn-danger my-2"
                                                        data-bs-target="#question_delete_{{ $question->id }}" onclick="showmodal({{ $question->id }})">
                                                        <i class="bi bi-trash"></i>
                                                </button>

                                                <!--Delete une question -->
                                                <div class="modal fade text-left" id="question_delete_{{ $question->id }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="myModalLabel17_{{ $question->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel17_{{ $question->id }}">Delete : {{ $question->title }}</h4>
                                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <i data-feather="x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group" >
                                                                        <form action="{{ route('delete.question',['id'=> $question->id]) }}" method="POST" id="deletemodalquestion_{{ $question->id }}">
                                                                            @csrf
                                                                            <h3 class="text-danger">Voulez-vous vraiment supprimer cette question ?</h3>
                                                                        </form>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer mt-5">
                                                                    <button type="button"
                                                                        class="btn btn-light-secondary"
                                                                        data-bs-dismiss="modal">
                                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Close</span>
                                                                    </button>
                                                                    <button class="btn btn-primary ml-1"
                                                                        data-bs-dismiss="modal" onclick="document.getElementById('deletemodalquestion_{{ $question->id }}').submit();">
                                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Accept</span>
                                                                    </button>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--modifier les question -->
                                                <div class="modal fade text-left" id="question_edit_{{ $question->id }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="myModalLabel17" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <i data-feather="x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <textarea id="title_question_{{ $question->id }}" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                                                    </div>
                                                                    {{-- dropdown --}}
                                                                    <div class="btn-group mb-3">
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                                                id="dropdownMenuButtonIcon_{{ $question->id }}" data-bs-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false">
                                                                                <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                                                            </button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon_{{ $question->id }}">
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('text')" >
                                                                                    <i class="bi bi-filter-left"></i> Réponse court
                                                                                </a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('textarea')">
                                                                                    <i class="bi bi-text-left"></i> Paragraphe
                                                                                </a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('radio')">
                                                                                    <i class="bi bi-record-circle"></i> Choix multiples
                                                                                </a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('checkbox')">
                                                                                    <i class="bi bi-check-square"></i> Cases à cocher
                                                                                </a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('select')">
                                                                                    <i class="bi bi-caret-down-square"></i> List déroulante
                                                                                </a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('fichier')">
                                                                                    <i class="bi bi-cloud-arrow-up-fill"></i> Importer un ficher
                                                                                </a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                    <i class="bi bi-calendar-date"></i> Date
                                                                                </a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('email')">
                                                                                    <i class="bi bi-envelope"></i> E-mail
                                                                                </a>
                                                                                 <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('heure')">
                                                                                    <i class="bi bi-clock"></i> Heure
                                                                                </a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                    <i class="bi bi-calendar-date"></i> Date
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group my-3">
                                                                        <input type="number" id="modal_numbers_radio_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                                                    </div>

                                                                    <div class="form-group my-3">
                                                                        <input type="number" id="modal_numbers_checkbox_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                                                    </div>

                                                                    <div class="form-group my-3">
                                                                        <input type="number" id="modal_numbers_select_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                                                    </div>

                                                                    <div id="modal_select_label_{{ $question->id }}">

                                                                    </div>

                                                                    <div id="modal_radio_label_{{ $question->id }}">

                                                                    </div>

                                                                    <div id="modal_checkbox_label_{{ $question->id }}">

                                                                    </div>
                                                                </div>

                                                                <div class="mt-3">

                                                                </div>

                                                                <div class="modal-footer mt-5">
                                                                    <button type="button"
                                                                        class="btn btn-light-secondary"
                                                                        data-bs-dismiss="modal">
                                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Close</span>
                                                                    </button>
                                                                    <button onclick="editquestion()" class="btn btn-primary ml-1"
                                                                        data-bs-dismiss="modal">
                                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Accept</span>
                                                                    </button>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        @endif
                                        <span id="change_{{ $question->id }}">
                                            <input type="text" class="form-control" placeholder="{{ $control->placeholder }}" />
                                        <span>
                                    @elseif($control->type == "email")
                                        <span id="change_{{ $question->id }}">
                                            <input type="email" class="form-control" placeholder="{{ $control->placeholder }}" />
                                        </span>
                                        @if(Auth::user()->id == $form->first()->user_id)
                                            <button type="button" class="btn btn-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#question_edit_{{ $question->id }}"
                                                    onclick="question({{ $question->id }})">
                                                    <i class="bi bi-brush"></i>
                                            </button>
                                            <button class="btn btn-danger my-2"
                                                    data-bs-target="#question_delete_{{ $question->id }}" onclick="showmodal({{ $question->id }})">
                                                    <i class="bi bi-trash"></i>
                                            </button>

                                            <!--Delete une question -->
                                            <div class="modal fade text-left" id="question_delete_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17_{{ $question->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17_{{ $question->id }}">Delete : {{ $question->title }}</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group" >
                                                                    <form action="{{ route('delete.question',['id'=> $question->id]) }}" method="POST" id="deletemodalquestion_{{ $question->id }}">
                                                                        @csrf
                                                                        <h3 class="text-danger">Voulez-vous vraiment supprimer cette question ?</h3>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal" onclick="document.getElementById('deletemodalquestion_{{ $question->id }}').submit();">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--modifier les question -->

                                            <div class="modal fade text-left" id="question_edit_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <textarea id="title_question_{{ $question->id }}" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                                                </div>
                                                                {{-- dropdown --}}
                                                                <div class="btn-group mb-3">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                                            id="dropdownMenuButtonIcon_{{ $question->id }}" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon_{{ $question->id }}">
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('text')" >
                                                                                <i class="bi bi-filter-left"></i> Réponse court
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('textarea')">
                                                                                <i class="bi bi-text-left"></i> Paragraphe
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('radio')">
                                                                                <i class="bi bi-record-circle"></i> Choix multiples
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('checkbox')">
                                                                                <i class="bi bi-check-square"></i> Cases à cocher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('select')">
                                                                                <i class="bi bi-caret-down-square"></i> List déroulante
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('fichier')">
                                                                                <i class="bi bi-cloud-arrow-up-fill"></i> Importer un ficher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('email')">
                                                                                <i class="bi bi-envelope"></i> E-mail
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('heure')">
                                                                                <i class="bi bi-clock"></i> Heure
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_radio_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_checkbox_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_select_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                                                </div>

                                                                <div id="modal_select_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_radio_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_checkbox_label_{{ $question->id }}">

                                                                </div>
                                                            </div>

                                                            <div class="mt-3">

                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button onclick="editquestion()" class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @elseif($control->type == "date")
                                        @if(Auth::user()->id == $form->first()->user_id)
                                            <button type="button" class="btn btn-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#question_edit_{{ $question->id }}"
                                                    onclick="question({{ $question->id }})">
                                                    <i class="bi bi-brush"></i>
                                            </button>
                                            <button class="btn btn-danger my-2"
                                                    data-bs-target="#question_delete_{{ $question->id }}" onclick="showmodal({{ $question->id }})">
                                                    <i class="bi bi-trash"></i>
                                            </button>

                                            <!--Delete une question -->
                                            <div class="modal fade text-left" id="question_delete_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17_{{ $question->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17_{{ $question->id }}">Delete : {{ $question->title }}</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group" >
                                                                    <form action="{{ route('delete.question',['id'=> $question->id]) }}" method="POST" id="deletemodalquestion_{{ $question->id }}">
                                                                        @csrf
                                                                        <h3 class="text-danger">Voulez-vous vraiment supprimer cette question ?</h3>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal" onclick="document.getElementById('deletemodalquestion_{{ $question->id }}').submit();">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--modifier les question -->

                                            <div class="modal fade text-left" id="question_edit_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <textarea id="title_question_{{ $question->id }}" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                                                </div>
                                                                {{-- dropdown --}}
                                                                <div class="btn-group mb-3">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                                            id="dropdownMenuButtonIcon_{{ $question->id }}" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon_{{ $question->id }}">
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('text')" >
                                                                                <i class="bi bi-filter-left"></i> Réponse court
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('textarea')">
                                                                                <i class="bi bi-text-left"></i> Paragraphe
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('radio')">
                                                                                <i class="bi bi-record-circle"></i> Choix multiples
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('checkbox')">
                                                                                <i class="bi bi-check-square"></i> Cases à cocher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('select')">
                                                                                <i class="bi bi-caret-down-square"></i> List déroulante
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('fichier')">
                                                                                <i class="bi bi-cloud-arrow-up-fill"></i> Importer un ficher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('email')">
                                                                                <i class="bi bi-envelope"></i> E-mail
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('heure')">
                                                                                <i class="bi bi-clock"></i> Heure
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_radio_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_checkbox_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_select_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                                                </div>

                                                                <div id="modal_select_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_radio_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_checkbox_label_{{ $question->id }}">

                                                                </div>
                                                            </div>

                                                            <div class="mt-3">

                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button onclick="editquestion()" class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <span id="change_{{ $question->id }}">
                                            <input type="date" class="form-control" placeholder="{{ $control->placeholder }}" />
                                        </span>
                                    @elseif($control->type == "time")
                                        @if(Auth::user()->id == $form->first()->user_id)
                                            <button type="button" class="btn btn-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#question_edit_{{ $question->id }}"
                                                    onclick="question({{ $question->id }})">
                                                    <i class="bi bi-brush"></i>
                                            </button>
                                            <button class="btn btn-danger my-2"
                                                    data-bs-target="#question_delete_{{ $question->id }}" onclick="showmodal({{ $question->id }})">
                                                    <i class="bi bi-trash"></i>
                                            </button>

                                            <!--Delete une question -->
                                            <div class="modal fade text-left" id="question_delete_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17_{{ $question->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17_{{ $question->id }}">Delete : {{ $question->title }}</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group" >
                                                                    <form action="{{ route('delete.question',['id'=> $question->id]) }}" method="POST" id="deletemodalquestion_{{ $question->id }}">
                                                                        @csrf
                                                                        <h3 class="text-danger">Voulez-vous vraiment supprimer cette question ?</h3>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal" onclick="document.getElementById('deletemodalquestion_{{ $question->id }}').submit();">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--modifier les question -->

                                            <div class="modal fade text-left" id="question_edit_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <textarea id="title_question_{{ $question->id }}" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                                                </div>
                                                                {{-- dropdown --}}
                                                                <div class="btn-group mb-3">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                                            id="dropdownMenuButtonIcon_{{ $question->id }}" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon_{{ $question->id }}">
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('text')" >
                                                                                <i class="bi bi-filter-left"></i> Réponse court
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('textarea')">
                                                                                <i class="bi bi-text-left"></i> Paragraphe
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('radio')">
                                                                                <i class="bi bi-record-circle"></i> Choix multiples
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('checkbox')">
                                                                                <i class="bi bi-check-square"></i> Cases à cocher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('select')">
                                                                                <i class="bi bi-caret-down-square"></i> List déroulante
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('fichier')">
                                                                                <i class="bi bi-cloud-arrow-up-fill"></i> Importer un ficher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('email')">
                                                                                <i class="bi bi-envelope"></i> E-mail
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('heure')">
                                                                                <i class="bi bi-clock"></i> Heure
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_radio_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_checkbox_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_select_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                                                </div>

                                                                <div id="modal_select_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_radio_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_checkbox_label_{{ $question->id }}">

                                                                </div>
                                                            </div>

                                                            <div class="mt-3">

                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button onclick="editquestion()" class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <span id="change_{{ $question->id }}">
                                            <input type="time" class="form-control" placeholder="{{ $control->placeholder }}" />
                                        </span>
                                    @elseif($control->type == "file")
                                        @if(Auth::user()->id == $form->first()->user_id)
                                            <button type="button" class="btn btn-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#question_edit_{{ $question->id }}"
                                                    onclick="question({{ $question->id }})">
                                                    <i class="bi bi-brush"></i>
                                            </button>
                                            <button class="btn btn-danger my-2"
                                                    data-bs-target="#question_delete_{{ $question->id }}" onclick="showmodal({{ $question->id }})">
                                                    <i class="bi bi-trash"></i>
                                            </button>

                                            <!--Delete une question -->
                                            <div class="modal fade text-left" id="question_delete_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17_{{ $question->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17_{{ $question->id }}">Delete : {{ $question->title }}</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group" >
                                                                    <form action="{{ route('delete.question',['id'=> $question->id]) }}" method="POST" id="deletemodalquestion_{{ $question->id }}">
                                                                        @csrf
                                                                        <h3 class="text-danger">Voulez-vous vraiment supprimer cette question ?</h3>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal" onclick="document.getElementById('deletemodalquestion_{{ $question->id }}').submit();">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--modifier les question -->

                                            <div class="modal fade text-left" id="question_edit_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <textarea id="title_question_{{ $question->id }}" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                                                </div>
                                                                {{-- dropdown --}}
                                                                <div class="btn-group mb-3">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                                            id="dropdownMenuButtonIcon_{{ $question->id }}" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon_{{ $question->id }}">
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('text')" >
                                                                                <i class="bi bi-filter-left"></i> Réponse court
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('textarea')">
                                                                                <i class="bi bi-text-left"></i> Paragraphe
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('radio')">
                                                                                <i class="bi bi-record-circle"></i> Choix multiples
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('checkbox')">
                                                                                <i class="bi bi-check-square"></i> Cases à cocher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('select')">
                                                                                <i class="bi bi-caret-down-square"></i> List déroulante
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('fichier')">
                                                                                <i class="bi bi-cloud-arrow-up-fill"></i> Importer un ficher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('email')">
                                                                                <i class="bi bi-envelope"></i> E-mail
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('heure')">
                                                                                <i class="bi bi-clock"></i> Heure
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_radio_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_checkbox_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_select_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                                                </div>

                                                                <div id="modal_select_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_radio_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_checkbox_label_{{ $question->id }}">

                                                                </div>
                                                            </div>

                                                            <div class="mt-3">

                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button onclick="editquestion()" class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <span id="change_{{ $question->id }}">
                                            <input type="file" class="form-control" placeholder="{{ $control->placeholder }}" />
                                        </span>
                                    @elseif($control->type == "radio")
                                        @if(Auth::user()->id == $form->first()->user_id)
                                            <button type="button" class="btn btn-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#question_edit_{{ $question->id }}"
                                                    onclick="question({{ $question->id }})">
                                                    <i class="bi bi-brush"></i>
                                            </button>
                                            <button class="btn btn-danger my-2"
                                                    data-bs-target="#question_delete_{{ $question->id }}" onclick="showmodal({{ $question->id }})">
                                                    <i class="bi bi-trash"></i>
                                            </button>

                                            <!--Delete une question -->
                                            <div class="modal fade text-left" id="question_delete_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17_{{ $question->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17_{{ $question->id }}">Delete : {{ $question->title }}</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group" >
                                                                    <form action="{{ route('delete.question',['id'=> $question->id]) }}" method="POST" id="deletemodalquestion_{{ $question->id }}">
                                                                        @csrf
                                                                        <h3 class="text-danger">Voulez-vous vraiment supprimer cette question ?</h3>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal" onclick="document.getElementById('deletemodalquestion_{{ $question->id }}').submit();">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--modifier les question -->

                                            <div class="modal fade text-left" id="question_edit_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <textarea id="title_question_{{ $question->id }}" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                                                </div>
                                                                {{-- dropdown --}}
                                                                <div class="btn-group mb-3">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                                            id="dropdownMenuButtonIcon_{{ $question->id }}" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon_{{ $question->id }}">
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('text')" >
                                                                                <i class="bi bi-filter-left"></i> Réponse court
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('textarea')">
                                                                                <i class="bi bi-text-left"></i> Paragraphe
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('radio')">
                                                                                <i class="bi bi-record-circle"></i> Choix multiples
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('checkbox')">
                                                                                <i class="bi bi-check-square"></i> Cases à cocher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('select')">
                                                                                <i class="bi bi-caret-down-square"></i> List déroulante
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('fichier')">
                                                                                <i class="bi bi-cloud-arrow-up-fill"></i> Importer un ficher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('email')">
                                                                                <i class="bi bi-envelope"></i> E-mail
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('heure')">
                                                                                <i class="bi bi-clock"></i> Heure
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_radio_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_checkbox_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_select_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                                                </div>

                                                                <div id="modal_select_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_radio_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_checkbox_label_{{ $question->id }}">

                                                                </div>
                                                            </div>

                                                            <div class="mt-3">

                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button onclick="editquestion()" class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div id="change_{{ $question->id }}">
                                            @foreach ($control->options()->get() as $option)
                                                <div class="form-check">
                                                    <label>
                                                        <input type="radio" class="form-check-input" name="{{ $question->id }}" value="{{ $option->value }}"/>
                                                        {{ $option->value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($control->type == "checkbox")
                                        @if(Auth::user()->id == $form->first()->user_id)
                                            <button type="button" class="btn btn-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#question_edit_{{ $question->id }}"
                                                    onclick="question({{ $question->id }})">
                                                    <i class="bi bi-brush"></i>
                                            </button>
                                            <button class="btn btn-danger my-2"
                                                    data-bs-target="#question_delete_{{ $question->id }}" onclick="showmodal({{ $question->id }})">
                                                    <i class="bi bi-trash"></i>
                                            </button>

                                            <!--Delete une question -->
                                            <div class="modal fade text-left" id="question_delete_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17_{{ $question->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17_{{ $question->id }}">Delete : {{ $question->title }}</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group" >
                                                                    <form action="{{ route('delete.question',['id'=> $question->id]) }}" method="POST" id="deletemodalquestion_{{ $question->id }}">
                                                                        @csrf
                                                                        <h3 class="text-danger">Voulez-vous vraiment supprimer cette question ?</h3>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal" onclick="document.getElementById('deletemodalquestion_{{ $question->id }}').submit();">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--modifier les question -->

                                            <div class="modal fade text-left" id="question_edit_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <textarea id="title_question_{{ $question->id }}" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                                                </div>
                                                                {{-- dropdown --}}
                                                                <div class="btn-group mb-3">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                                            id="dropdownMenuButtonIcon_{{ $question->id }}" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon_{{ $question->id }}">
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('text')" >
                                                                                <i class="bi bi-filter-left"></i> Réponse court
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('textarea')">
                                                                                <i class="bi bi-text-left"></i> Paragraphe
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('radio')">
                                                                                <i class="bi bi-record-circle"></i> Choix multiples
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('checkbox')">
                                                                                <i class="bi bi-check-square"></i> Cases à cocher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('select')">
                                                                                <i class="bi bi-caret-down-square"></i> List déroulante
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('fichier')">
                                                                                <i class="bi bi-cloud-arrow-up-fill"></i> Importer un ficher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('email')">
                                                                                <i class="bi bi-envelope"></i> E-mail
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('heure')">
                                                                                <i class="bi bi-clock"></i> Heure
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_radio_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_checkbox_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_select_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                                                </div>

                                                                <div id="modal_select_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_radio_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_checkbox_label_{{ $question->id }}">

                                                                </div>
                                                            </div>

                                                            <div class="mt-3">

                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button onclick="editquestion()" class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div id="change_{{ $question->id }}">
                                            @foreach ($control->options()->get() as $option)
                                                    <div class="form-check">
                                                        <label>
                                                            <input type="checkbox" class="form-check-input" name={{ $option->attr_name }} value="{{ $option->value }}"/>
                                                            {{ $option->value }}
                                                        </label>
                                                    </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @elseif( $control->name == "textarea")
                                    @if(Auth::user()->id == $form->first()->user_id)
                                        <button type="button" class="btn btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#question_edit_{{ $question->id }}"
                                                onclick="question({{ $question->id }})">
                                                <i class="bi bi-brush"></i>
                                        </button>
                                        <button class="btn btn-danger my-2"
                                                data-bs-target="#question_delete_{{ $question->id }}" onclick="showmodal({{ $question->id }})">
                                                <i class="bi bi-trash"></i>
                                        </button>

                                         <!--Delete une question -->
                                        <div class="modal fade text-left" id="question_delete_{{ $question->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel17_{{ $question->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                role="document">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel17_{{ $question->id }}">Delete : {{ $question->title }}</h4>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group" >
                                                                <form action="{{ route('delete.question',['id'=> $question->id]) }}" method="POST" id="deletemodalquestion_{{ $question->id }}">
                                                                    @csrf
                                                                    <h3 class="text-danger">Voulez-vous vraiment supprimer cette question ?</h3>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer mt-5">
                                                            <button type="button"
                                                                class="btn btn-light-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Close</span>
                                                            </button>
                                                            <button class="btn btn-primary ml-1"
                                                                data-bs-dismiss="modal" onclick="document.getElementById('deletemodalquestion_{{ $question->id }}').submit();">
                                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Accept</span>
                                                            </button>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--modifier les question -->

                                        <div class="modal fade text-left" id="question_edit_{{ $question->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel17" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                role="document">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <textarea id="title_question_{{ $question->id }}" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                                            </div>
                                                            {{-- dropdown --}}
                                                            <div class="btn-group mb-3">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                                        id="dropdownMenuButtonIcon_{{ $question->id }}" data-bs-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="false">
                                                                        <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon_{{ $question->id }}">
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('text')" >
                                                                            <i class="bi bi-filter-left"></i> Réponse court
                                                                        </a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('textarea')">
                                                                            <i class="bi bi-text-left"></i> Paragraphe
                                                                        </a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('radio')">
                                                                            <i class="bi bi-record-circle"></i> Choix multiples
                                                                        </a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('checkbox')">
                                                                            <i class="bi bi-check-square"></i> Cases à cocher
                                                                        </a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('select')">
                                                                            <i class="bi bi-caret-down-square"></i> List déroulante
                                                                        </a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('fichier')">
                                                                            <i class="bi bi-cloud-arrow-up-fill"></i> Importer un ficher
                                                                        </a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                            <i class="bi bi-calendar-date"></i> Date
                                                                        </a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('email')">
                                                                            <i class="bi bi-envelope"></i> E-mail
                                                                        </a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('heure')">
                                                                            <i class="bi bi-clock"></i> Heure
                                                                        </a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                            <i class="bi bi-calendar-date"></i> Date
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group my-3">
                                                                <input type="number" id="modal_numbers_radio_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                                            </div>

                                                            <div class="form-group my-3">
                                                                <input type="number" id="modal_numbers_checkbox_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                                            </div>

                                                            <div class="form-group my-3">
                                                                <input type="number" id="modal_numbers_select_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                                            </div>

                                                            <div id="modal_select_label_{{ $question->id }}">

                                                            </div>

                                                            <div id="modal_radio_label_{{ $question->id }}">

                                                            </div>

                                                            <div id="modal_checkbox_label_{{ $question->id }}">

                                                            </div>
                                                        </div>

                                                        <div class="mt-3">

                                                        </div>

                                                        <div class="modal-footer mt-5">
                                                            <button type="button"
                                                                class="btn btn-light-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Close</span>
                                                            </button>
                                                            <button onclick="editquestion()" class="btn btn-primary ml-1"
                                                                data-bs-dismiss="modal">
                                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Accept</span>
                                                            </button>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <span id="change_{{ $question->id }}">
                                        <textarea cols="30" rows="3" class="form-control" placeholder="{{ $control->placeholder }}"></textarea>
                                    </span>
                                    @elseif( $control->name == "select")
                                        @if(Auth::user()->id == $form->first()->user_id)
                                            <button type="button" class="btn btn-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#question_edit_{{ $question->id }}"
                                                    onclick="question({{ $question->id }})">
                                                    <i class="bi bi-brush"></i>
                                            </button>
                                            <button class="btn btn-danger my-2"
                                                    data-bs-target="#question_delete_{{ $question->id }}" onclick="showmodal({{ $question->id }})">
                                                    <i class="bi bi-trash"></i>
                                            </button>

                                            <!--Delete une question -->
                                            <div class="modal fade text-left" id="question_delete_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17_{{ $question->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17_{{ $question->id }}">Delete : {{ $question->title }}</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group" >
                                                                    <form action="{{ route('delete.question',['id'=> $question->id]) }}" method="POST" id="deletemodalquestion_{{ $question->id }}">
                                                                        @csrf
                                                                        <h3 class="text-danger">Voulez-vous vraiment supprimer cette question ?</h3>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal" onclick="document.getElementById('deletemodalquestion_{{ $question->id }}').submit();">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--modifier les question -->

                                            <div class="modal fade text-left" id="question_edit_{{ $question->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel17" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <textarea id="title_question_{{ $question->id }}" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                                                </div>
                                                                {{-- dropdown --}}
                                                                <div class="btn-group mb-3">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                                            id="dropdownMenuButtonIcon_{{ $question->id }}" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon_{{ $question->id }}">
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('text')" >
                                                                                <i class="bi bi-filter-left"></i> Réponse court
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('textarea')">
                                                                                <i class="bi bi-text-left"></i> Paragraphe
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('radio')">
                                                                                <i class="bi bi-record-circle"></i> Choix multiples
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('checkbox')">
                                                                                <i class="bi bi-check-square"></i> Cases à cocher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('select')">
                                                                                <i class="bi bi-caret-down-square"></i> List déroulante
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('fichier')">
                                                                                <i class="bi bi-cloud-arrow-up-fill"></i> Importer un ficher
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('email')">
                                                                                <i class="bi bi-envelope"></i> E-mail
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('heure')">
                                                                                <i class="bi bi-clock"></i> Heure
                                                                            </a>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="changeselect('date')">
                                                                                <i class="bi bi-calendar-date"></i> Date
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_radio_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_checkbox_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                                                </div>

                                                                <div class="form-group my-3">
                                                                    <input type="number" id="modal_numbers_select_{{ $question->id }}" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                                                </div>

                                                                <div id="modal_select_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_radio_label_{{ $question->id }}">

                                                                </div>

                                                                <div id="modal_checkbox_label_{{ $question->id }}">

                                                                </div>
                                                            </div>

                                                            <div class="mt-3">

                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button onclick="editquestion()" class="btn btn-primary ml-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Accept</span>
                                                                </button>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div id="change_{{ $question->id }}">
                                            <div class="form-group">
                                                <select name="{{ $control->attr_name }}" class="form-control">
                                                    @foreach ($control->options()->get() as $option)
                                                            <option value="{{ $option->value }}">{{ $option->value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                            @endforeach

                            @if($question->obligatory == 1)
                                <p><span class="text-danger">*Obligatoire </span></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!--modifier la description et le titre du formulaire -->

        <div class="modal fade text-left" id="form_edit" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                role="document">
                <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel17">Éditer</h4>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                    <form action="{{ route('edit.form',["type" => "formulaire" , 'id' => $form->first()->id]) }}" id="editform1" method="POST">
                        @csrf
                        <div class="modal-body">
                                <input type="text" id="title" name="title" placeholder="Titre du formulaire" class="form-control mb-3"/>
                                <textarea id="description" name="description" cols="30" rows="2" placeholder="description" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" onclick="document.getElementById('editform1').submit();"  class="btn btn-primary ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Accept</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>






</div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.min') }}"></script>


    <script>
        $('#form_edit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var title = button.data('title')
            var description = button.data('description')
            var modal = $(this)
            console.log(modal);
            modal.find('.modal-body #title').val(title);
            modal.find('.modal-body #description').val(description);
        })
    </script>

<script src="{{ asset('js/edit_formulaire.js') }}"></script>

<script>
    function showmodal(name) {
        console.log(name);
        $('#question_delete_'+name).modal('show');

    }
</script>

@endsection
