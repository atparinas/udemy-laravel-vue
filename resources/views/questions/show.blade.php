@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                    @include('layouts._messages')
                    
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1> {{ $question->title }} </h1>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index')}}" class="btn btn-outline-secondary">
                                    Back To All Questions
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="media">
                        @include('shared._vote', [
                            'model' => $question
                        ])
                        <div class="media-body">
                            {!! $question->body_html !!}
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <user-info :model="{{$question}}" 
                                        label="Asked" ></user-info>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('answers._index', [
        'answers_count' => $question->answers_count,
        'answers' => $question->answers
    ])

    @include('answers._create')

</div>
@endsection
