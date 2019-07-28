@csrf
<div class="form-group">
    <label for="title">Question Title</label>
    <input type="text" value="{{ old('title', $question->title)}} "
        name="title" id="question-title" 
        class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }}" >

    @if ($errors->has('title'))
        <div class="invalid-feedback">
            <strong> {{ $errors->first('title') }} </strong>
        </div>
    @endif
</div>
<div class="form-group">
    <label for="body">Explain Your Question</label>
    <textarea name="body" id="question-body" rows="10" 
        class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}">{{ old('body', $question->body)}}</textarea>
    @if ($errors->has('body'))
        <div class="invalid-feedback">
            <strong> {{ $errors->first('body') }} </strong>
        </div>
    @endif
</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary bt-lg">{{ $button_text }}</button>
</div>