@extends('layouts.user-master')

@section('title')
    @if($forms != null)
        {{ $forms->title }}
    @else
        FORMULAIRE
    @endif
@stop

@section('content')
<div class="container-fluid">
    @include('partials.flash')
</div>
<div class="page-heading">
    @if($forms != null)
        <div class="mb-5 page-title">
            <div class="row container justify-content-center m-auto">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $forms->title }}</h3>
                    <p class="text-subtitle text-muted">{{ $forms->description }}</p>
                </div>
            </div>
        </div>
        <form action="{{ route('user.store.form',["id"=>$forms->id] ) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @foreach ($forms->questions()->get() as $question)
                <section class="section container justify-content-center rounded border border-primary mb-4">
                    <div class="card px-4">

                        <div class="card-header">
                            <h4 class="card-title">{{ $question->title }}</h4>
                        </div>

                        <div class="card-body">
                            @foreach ($question->controls()->get() as $control)
                                @if( $control->name == "input")
                                    @if($control->type == "text")
                                        <input type="text" class="form-control" name="input_text_q_{{ $question->id }}" placeholder="écris quelque chose" value="{{ old( $question->id ) }}" />
                                        @error('input_text_q_{{ $question->id }}')<span class="text-danger">{{ $message }}</span>@enderror
                                    @elseif($control->type == "date")
                                        <input type="date" class="form-control" name="input_date_q_{{ $question->id }}" placeholder="écris quelque chose" value="{{ old( $question->id ) }}"  />
                                        @error('input_date_q_{{ $question->id }}')<span class="text-danger">{{ $message }}</span>@enderror
                                    @elseif($control->type == "email")
                                        <input type="email" class="form-control" name="input_email_q_{{ $question->id }}" placeholder="écris quelque chose" value="{{ old( $question->id ) }}" />
                                        @error('input_email_q_{{ $question->id }}')<span class="text-danger">{{ $message }}</span>@enderror
                                    @elseif($control->type == "time")
                                        <input type="time" class="form-control" name="input_time_q_{{ $question->id }}" placeholder="écris quelque chose" value="{{ old( $question->id ) }}" />
                                        @error('input_time_q_{{ $question->id }}')<span class="text-danger">{{ $message }}</span>@enderror
                                    @elseif($control->type == "file")
                                        <input type="file" class="form-control" name="input_file_q_{{ $question->id }}" />
                                        @error('input_file_q_{{ $question->id }}')<span class="text-danger">{{ $message }}</span>@enderror
                                    @elseif($control->type == "radio")
                                        @foreach ($control->options()->get() as $option)
                                            <div class="form-check">
                                                <label>
                                                    <input type="radio" class="form-check-input" name="input_radio_q_{{ $question->id }}" value="{{ $option->value }}" checked/>
                                                    {{ $option->value }}
                                                </label>
                                            </div>
                                        @endforeach
                                        @error('input_radio_q_{{ $question->id }}')<span class="text-danger">{{ $message }}</span>@enderror
                                    @elseif($control->type == "checkbox")
                                        @foreach ($control->options()->get() as $option)
                                            <div class="form-check">
                                                <label>
                                                    <input type="checkbox" class="form-check-input" name="input_checkbox_q_{{ $question->id }}_option{{ $option->id }}" value="{{ $option->value }}"/>
                                                    {{ $option->value }}
                                                </label>
                                                @error('input_checkbox_q_{{ $question->id }}_option{{ $option->id }}')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        @endforeach
                                    @endif
                                @elseif($control->name == "textarea")
                                    <textarea class="form-control" name="textarea_q_{{ $question->id }}" cols="30" rows="2" placeholder="écris quelque chose" value="{{ old( $question->id ) }}" ></textarea>
                                    @error('textarea_q_{{ $question->id }}')<span class="text-danger">{{ $message }}</span>@enderror
                                @elseif($control->name == "select")
                                    <select name="select_q_{{ $question->id }}" class="form-control">
                                        @foreach ($control->options()->get() as $option)
                                                <option value="{{ $option->value }}">{{ $option->value }}</option>
                                        @endforeach
                                    </select>
                                    @error('select_q_{{ $question->id }}')<span class="text-danger">{{ $message }}</span>@enderror
                                @endif
                            @endforeach

                        </div>

                         
                        @if($question->obligatory == 1)
                            <p class="text-danger">*Obligatoire</p>
                        @endif
                        
                    </div>
                </section>
            @endforeach

            <section class="section container justify-content-center">
                <div class="card px-4 ">
                    <div class="card-body">
                        <button class="btn btn-primary btn-block">Envoyer</button>
                    </div>
                </div>
            </section>
        </form>
    @else
        <section class="section container justify-content-center">
            <div class="card px-4">

                <div class="card-header">
                    <h4 class="card-title">Information</h4>
                </div>

                <div class="card-body text-danger">
                    Il n'y a aucun formulaire à remplir pour le moment. Veuillez patienter jusqu'à ce que vous receviez un nouveau formulaire .
                </div>
            </div>
        </section>
    @endif
</div>


@endsection
