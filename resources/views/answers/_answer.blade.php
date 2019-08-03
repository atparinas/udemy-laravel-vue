<div class="media">
    @include('shared._vote', [
        'model' => $answer
    ])
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
                {{-- @include('shared._author', ['model' => $answer, 'label' => 'answered']) --}}
                <user-info :model="{{$answer}}" label="Answered" ></user-info>
            </div>
        </div>
    </div>
</div>