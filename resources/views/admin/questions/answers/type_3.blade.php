<input type="hidden" name="question_id" value="{{$question->id}}"/>
<input type="hidden" name="new_value" value="{{$answers->isEmpty() ? 1 : 0}}"/>
<div class="form-group">
    <label class="col-form-label">Введите правильный ответ на вопрос</label>
    @if (!$answers->isEmpty())
        @foreach($answers as $answer)
            @if ($errors->has('answer.'.$answer->id.'.title]'))
                <div
                    class="text-center alert-danger p-1 mb-1">{{ $errors->first('answer.'.$answer->id.'.title') }}</div>
            @endif
            <input type="hidden" name='answer.is_right[]' value="{{ $answer->id }}"/>
            <input id='type_3_answer' class="form-control" type="text" name='answer[{{$answer->id}}][title]'
                   value='{{old('answer.'.$answer->id.'.title', $answer->text)}}'
            />
        @endforeach
    @else
        @if ($errors->has('answer.0.title'))
            <div class="text-center alert-danger p-1 mb-1">{{ $errors->first('answer.0.title') }}</div>
        @endif
        <input type="hidden" name='answer.is_right[]' value="0"/>
        <input id='type_3_answer' class="form-control" type="text" name='answer[0][title]'
               value='{{old('answer.0.title')}}'
        />
    @endif
</div>


