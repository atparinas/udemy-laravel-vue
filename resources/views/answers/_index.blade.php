{{-- directives will remain in the element until
associated view instance has finished compilation
need to put in the proper css rules for v-cloak --}}
<div class="row mt-5" v-cloak>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2> {{ $answers_count . " " . str_plural('Answer', $answers_count)}} </h2>
                </div>
                <hr>
                @foreach ($answers as $answer)
                    @include('answers._answer', ['answer' => $answer])
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>