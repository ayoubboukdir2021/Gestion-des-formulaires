@extends('layouts.master')

@section('title')
    La list des formulaires
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
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nom du formulaire</th>
                            <th>Description</th>
                            <th>Nombre de questions</th>
                            <th>Status</th>
                            <th>Détails</th>
                            <th>Export</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($forms as $form)
                            <tr>
                                <td>{!! \Illuminate\Support\Str::limit($form->title, 50, '...') !!}</td>
                                <td>{!! \Illuminate\Support\Str::limit($form->description, 50, '...') !!}</td>
                                <td class="text-center">{{ $form->questions()->count() }}</td>
                                <td>
                                    @if ($form->status == 1)
                                        @if(Auth::user()->id == $form->user_id)
                                            <a href="{{ route('edit.status.forms',['id'=>$form->id,"type"=>"actif"]) }}"><span class="badge bg-success">Actif</span></a>
                                        @else
                                            <span class="badge bg-success">Actif</span>
                                        @endif
                                    @else
                                        @if(Auth::user()->id == $form->user_id)
                                            <a href="{{ route('edit.status.forms',['id'=>$form->id,"type"=>"inactif"]) }}"><span class="badge bg-danger">Inactif</span></a>
                                        @else
                                            <span class="badge bg-danger">Inactif</span>
                                        @endif
                                    @endif
                                </td>
                                <td><a href="{{ route('details.forms',["id" => $form->id]) }}"><span class="badge bg-info">Détails</span></a></td>
                                <td><a href="{{ route('export',["id" => $form->id]) }}" onclick="event.preventDefault();exportdata({{ $form->id }});"><span class="badge bg-primary">Export</span></a></td>

                                @if(Auth::user()->id == $form->user_id)
                                    <td><a href="{{ route('delete.forms',["id" => $form->id]) }}"><span class="badge bg-warning">Suppression</span></a></td>
                                @else
                                    <td class="text-center"> - </td>
                                @endif

                            </tr>

                        @empty
                            <tr><td class="text-danger text-center" colspan="7">No data</td></tr>
                        @endforelse

                    </tbody>
                </table>
                <div id="divexport">

                </div>
                <form action="" method="POST" id="formdata">@csrf</form>
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
        function exportdata(id) {
            let div = document.getElementById("divexport");
            div.innerHTML = "";
            div.innerHTML = `
                <form action="/admin/form/export/${id}" method="POST" id="formdata">
                    @csrf    
                </form>`
            document.getElementById('formdata').submit();
        }
    </script>
@endsection
