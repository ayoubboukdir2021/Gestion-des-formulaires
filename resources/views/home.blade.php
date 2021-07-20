@extends('layouts.master')

@section('title')
    Tableau de bord
@stop

@section('content')
<div class="page-heading">
    <h3>Tableau de bord</h3>
</div>

<div class="page-content">
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.
        Nemo aperiam dolore tenetur quod placeat veniam iusto voluptas velit.
         Nam aspernatur neque delectus molestiae
        dolores distinctio error voluptates illo natus blanditiis.</p>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
@endsection
