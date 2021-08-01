@extends('layouts.master')

@section('title')
    Tableau de bord
@stop

@section('content')
<div class="page-heading">
    <h3>Tableau de bord</h3>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-8 col-lg-4 col-md-8">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Nombre d'utilisateurs actifs</h6>
                                    <h6 class="font-extrabold mb-0">{{ count($users) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Nombre d'utilisateurs inactifs</h6>
                                    <h6 class="font-extrabold mb-0">{{ $inactif }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldPaper"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Nombre de formulaires actifs</h6>
                                    <h6 class="font-extrabold mb-0">{{ $actif }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                            <div class="card-header">
                                <h4>Statistiques de l'année {{ date('Y') }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-5">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            @if(Auth::user()->image != null && Auth::user()->image != "")
                                <img src="{{ asset('assets/users/'.Auth::user()->image) }}" alt="Face 1" />
                            @else
                                <img src="{{ asset("assets/images/faces/1.jpg") }}" />
                            @endif
                        </div>
                        <div class="ms-3 name">
                            <p class="font-bold">{{ Auth::user()->name }}</p>
                            <small class="text-muted mb-0">@.{{ Auth::user()->username }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6>Derniers nouveaux utilisateurs</h6>
                </div>
                <?php $i = 0 ?>
                @forelse ($users as $user)
                    <?php $i++ ?>
                    @if($i<=3)
                        <div class="card-content pb-4">
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    @if($user->image != null && $user->image != "")
                                        <img src="{{ asset('assets/users/'.$user->image) }}" />
                                    @else
                                    <img src="{{ asset('assets/images/faces/4.jpg') }}" />
                                    @endif
                                </div>
                                <div class="name ms-4">
                                    <p class="mb-1"><b>{{ $user->name }}</b></p>
                                    <small class="text-muted mb-0">@.{{ $user->username }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="card-content pb-4">
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <p>Il n'y a pas de nouvel utilisateur</p>
                            </div>
                        </div>
                    </div>
                @endforelse
                @if(count($users)>0)
                    <div class="px-4 mb-2">
                        <a href="/admin/users" class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>liste d'utilisateur</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
@endsection
