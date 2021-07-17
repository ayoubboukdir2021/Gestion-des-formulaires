@extends('layouts.master')

@section('title')
    Créer un formulaire
@stop

@section('style')
<link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
@endsection

@section('content')
<div class="page-heading">
    <h3>Créer un formulaire</h3>
</div>
<div class="container-fluid">
    @include('partials.flash')
</div>

<div class="page-content">
        <form action="{{ route('add.forms') }}" method="POST"  id="formcontent" enctype="multipart/form-data">
            @csrf

            <div class="card border border-primary" id="component1" name="component">
                <div class="card-body">
                    <label for="formulaire">Title</label>
                    <input name="formulaire" id="title_formulaire" type="text" placeholder="Formulaire sans titre" class="form-control" onchange="changeformulaire()"/>
                    <label for="formulaire_description">Description</label>
                    <textarea name="formulaire_description" id="formulaire_description" cols="30" rows="2" class="form-control mt-1" placeholder="Description" onchange="changeformulaire()"></textarea>
                </div>
            </div>

            <div class="card" id="component2" name="component">
                <div class="card-body">

                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#add_question">
                        <i class="bi bi-plus-circle-fill"></i> Ajouter une question
                    </button>

                    <div class="modal fade text-left" id="add_question" tabindex="-1"
                        role="dialog" aria-labelledby="myModalLabel160"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="myModalLabel160">
                                        <i class="bi bi-file-earmark-spreadsheet-fill"></i>Ajouter une question
                                    </h5>
                                    <button type="button" class="close"
                                        data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <textarea id="title_question" cols="30" rows="2" class="form-control mt-1" placeholder="écrivez votre question"></textarea>
                                    </div>
                                    {{-- dropdown --}}
                                    <div class="btn-group mb-3">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle me-1" type="button"
                                                id="dropdownMenuButtonIcon" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-caret-down"></i> Sélectionnez un élément spécifique ...
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon">
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
                                        <input type="number" id="modal_numbers_radio" class="form-control" placeholder="nombre d'options"  onchange="createradiolabel()" hidden/>
                                    </div>

                                    <div class="form-group my-3">
                                        <input type="number" id="modal_numbers_checkbox" class="form-control" placeholder="nombre d'options"  onchange="createcheckboxlabel()" hidden/>
                                    </div>

                                    <div class="form-group my-3">
                                        <input type="number" id="modal_numbers_select" class="form-control" placeholder="nombre d'options"  onchange="createselectlabel()" hidden/>
                                    </div>

                                    <div id="modal_select_label">

                                    </div>

                                    <div id="modal_radio_label">

                                    </div>

                                    <div id="modal_checkbox_label">

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
                                    <button onclick="AddQestion()" class="btn btn-primary ml-1"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Accept</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        <button class="btn btn-primary btn-block my-3" id="submit" type="submit">Submit</button>
        </form>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/toastify.js') }}"></script>
    
    <script src="{{ asset('js/jquery-3.6.0.min') }}"></script>
    <script src="{{ asset('js/create_formulaire.js') }}"></script>
@endsection
