@extends('layouts.master')

@section('title')
    Profile
@stop

@section('content')
<div class="page-heading">
    <h3>Profile</h3>
</div>
<div class="container-fluid">
    @include('partials.flash')
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.profile') }}" method="POST" id="adduser" enctype="multipart/form-data" >
                                @csrf
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nom et Prénom <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="nom & prénom" value="{{ Auth::user()->name }}">
                                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">E-mail <span class="text-danger">*</span></label>
                                            <input type="text" name="email" id="email" class="form-control" placeholder="E-mail" value="{{ Auth::user()->email }}">
                                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <code>jpeg,jpg,png</code>
                                                    </p>
                                                    <!-- File uploader with file upload -->
                                                    <input type="file" class="multiple-files-filepond" name="image">
                                                </div>
                                            </div>
                                            @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="helperText">address<span class="text-danger">*</span></label>
                                            <input type="text" name="address" id="address" class="form-control" placeholder="address" value="{{ Auth::user()->address }}">
                                            @error('address')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="helperText">phone<span class="text-danger">*</span></label>
                                            <input type="number" name="phone" id="phone" class="form-control" placeholder="phone" value="{{ Auth::user()->phone }}">
                                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-outline-primary" onclick="event.preventDefault();document.getElementById('adduser').submit()">Enregistrer</a>
                            </div></form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
@endsection
