<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2> {{ $answers_count . " " . str_plural('Answer', $answers_count)}} </h2>
                </div>
                <hr>
                @foreach ($answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a title="This answer is usefull"  class="vote-up {{Auth::guest() ? 'off' : ''}}"
                                onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{$answer->id}}').submit()" >
                                <i class="fas fa-caret-up fa-2x"></i>
                            </a>
                            <form action="/answers/{{ $answer->id }}/vote" 
                                id="up-vote-answer-{{$question->id}}" method="POST" style="display:none" >
                                @csrf
                                <input type="hidden" name="vote" value="1">
                            </form>
                            <span class="votes-count">{{ $answer->votes_count }}</span>
                            <a title="This answer is not usefull"  class="vote-up {{Auth::guest() ? 'off' : ''}}"
                            onclick="event.preventDefault(); document.getElementById('down-vote-question-{{$question->id}}').submit()">
                                <i class="fas fa-caret-down fa-2x"></i>
                            </a>
                            <form action="/answers/{{ $question->id }}/vote" 
                                id="down-vote-question-{{$answer->id}}" method="POST" style="display:none" >
                                @csrf
                                <input type="hidden" name="vote" value="-1">
                            </form>
                            @can('accept', $answer)
                                <a title="mark this answer as best" class="{{ $answer->status }} mt-2"
                                    onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit()" >
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <form action="{{route('answers.accept', $answer->id)}}" 
                                    id="accept-answer-{{$answer->id}}" method="POST" style="display:none" >
                                    @csrf
                                </form>
                            @else
                                @if ($answer->is_best)
                                    <a title="This answer the best" class="{{ $answer->status }} mt-2" >
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                @endif                
                            @endcan
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="ml-auto">
                                        @can('update', $answer)
                                            <a href="{{ route('questions.answers.edit',[$question->id, $answer->id])}}" 
                                                class="btn btn-sm btn-outline-info">Edit</a>                                            
                                        @endcan

                                        @can('delete', $answer)
                                            <form class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id])}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Are Your Sure?')">Delete</button>
                                            </form>                                           
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    {{-- Future Content --}}
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <span class="text-muted"> Answered {{ $answer->created_date }} </span>
                                        <div class="media mt-2">
                                            <a href=" {{ $answer->user->url}}" class="pr-2">
                                                <img src="{{ $answer->user->avatar }}" alt="user avatar">
                                            </a>
                                            <div class="media-body mt-1">
                                                <a href="{{$answer->user->url}}"> {{ $answer->user->name }} </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>