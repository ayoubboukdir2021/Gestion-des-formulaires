@extends('layouts.master')

@section('title')
    liste des utilisateurs
@stop

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
@endsection

@section('content')
<div class="page-heading">
    <h3>La list des formulaires</h3>
</div>

<div class="container-fluid">
    @include('partials.flash')
</div>

<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('users.export') }}" class="badge bg-primary" onclick="event.preventDefault();exportdata();">Export</a>
                <a href="{{ route('users.status') }}" class="badge bg-primary" onclick="event.preventDefault();desactiver();">Désactiver les utilisateurs</a>
                <a href="{{ route('users.delete') }}" class="badge bg-danger"  onclick="event.preventDefault();deletedata();">Supprimer tous les utilisateurs sauf les superviseurs</a>


                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">Nom & Prénom</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Détails</th>
                            <th class="text-center">Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->username }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">
                                    @if(1 == $user->status)
                                        <a href="{{ route('user.status',['id'=>$user->id,'status'=>'1']) }}"><span class="badge bg-success">Actif</span></a>
                                    @else
                                        <a href="{{ route('user.status',['id'=>$user->id,'status'=>'0']) }}"><span class="badge bg-danger">Inactif</span></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#inlineForm_{{$user->id}}">
                                        <span class="badge bg-info">Détails</span>
                                    </a>

                                    <div class="modal fade text-left" id="inlineForm_{{$user->id}}" tabindex="-1"
                                                role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel33">{{ $user->name }} </h4>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="#">
                                                    <div class="modal-body">
                                                        @if($user->image != null && $user->image != "")
                                                            <img class="img-thumbnail" src="{{ asset("assets/users/".$user->image) }}" alt="{{ $user->username }}"/>
                                                        @else
                                                            <img class="img-thumbnail" src="{{ asset('assets/users/default.png') }}" alt="{{ $user->username }}"/>
                                                        @endif
                                                        <p><small>@.{{ $user->username }}</small></p>
                                                        <p>{{ $user->email }}</p>
                                                        <p>{{ $user->phone }}</p>
                                                        <p>{{ $user->address }}</p>
                                                        <p>{{ $user->created_at }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if(2 == $user->role()->get()->first()->id)
                                        <span class="badge badge-secondary text-dark">Superviseur</span>
                                    @elseif(3 == $user->role()->get()->first()->id)
                                        <span class="badge badge-secondary text-dark">Utilisateur</span>
                                    @endif
                                </td>
                                @if(Auth::user()->role()->get()->first()->id == 1)
                                    <td><a href="{{ route('user.delete',['id'=>$user->id]) }}"><span class="badge bg-warning">Suppression</span></a></td>
                                @else
                                    <td class="text-center"> - </td>
                                @endif

                            </tr>

                        @empty
                            <tr><td class="text-danger text-center" colspan="7">No data</td></tr>
                        @endforelse

                    </tbody>
                </table>
                <div id="export_delete_desactiver">

                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }} "></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    <script>
        function exportdata() {
            let div = document.getElementById("export_delete_desactiver");
            div.innerHTML = "";
            div.innerHTML = `
                <form action="/admin/users/export" method="POST" id="formdata">
                    @csrf
                </form>`
            document.getElementById('formdata').submit();
        }

        function desactiver() {
            let div = document.getElementById("export_delete_desactiver");
            div.innerHTML = "";
            div.innerHTML = `
                <form action="/admin/users/status" method="POST" id="formdata">
                    @csrf
                </form>`
            document.getElementById('formdata').submit();
        }

        function deletedata() {
            let div = document.getElementById("export_delete_desactiver");
            div.innerHTML = "";
            div.innerHTML = `
                <form action="/admin/users/delete" method="POST" id="formdata">
                    @csrf
                </form>`
            document.getElementById('formdata').submit();
        }
    </script>
@endsection
