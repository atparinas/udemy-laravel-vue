@if ($model instanceof App\Question)
    @php
        $name = 'question';
        $firstURISegment = 'questions';
    @endphp
@elseif($model instanceof App\Answer)
    @php
        $name = 'answer';
        $firstURISegment = 'answers';
    @endphp
@endif

@php
    $form_id = $name . "-" . $model->id;
    $form_action = "/" . $firstURISegment . "/" . $model->id . "/vote";
@endphp


<div class="d-flex flex-column vote-controls">
    <a title="This {{$name}} is usefull" 
        class="vote-up {{Auth::guest() ? 'off' : ''}}"
        onclick="event.preventDefault(); document.getElementById('up-vote-{{$form_id}}').submit()" >
        <i class="fas fa-caret-up fa-2x"></i>
    </a>
    <form action="{{$form_action}}" 
        id="up-vote-{{$form_id}}" method="POST" style="display:none" >
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>
    <span class="votes-count">{{ $model->votes_count }}</span>
    <a title="This {{$name}} is not usefull"  class="vote-up {{Auth::guest() ? 'off' : ''}}"
        onclick="event.preventDefault(); document.getElementById('down-vote-{{$form_id}}').submit()" >
        <i class="fas fa-caret-down fa-2x"></i>
    </a>
    <form action="{{$form_action}}" 
        id="down-vote-{{$form_id}}" method="POST" style="display:none" >
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>
    @if ($model instanceof App\Question )
        @include('shared._favorite', [
            'model' => $model
        ])

    @elseif($model)
        @include('shared._accept', [
            'model' => $model
        ])
    @endif
</div>