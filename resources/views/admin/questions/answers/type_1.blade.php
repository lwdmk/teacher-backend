<input type="hidden" name="question_id" value="{{$question->id}}"/>
<input type="hidden" name="new_value" value="{{$answers->isEmpty() ? 1 : 0}}"/>
@if ($errors->has('answer.is_right'))
    <div class="text-center alert-danger mb-1 p-1">{{ $errors->first('answer.is_right') }}</div>
@endif
<table class="table table-striped">
    <thead>
    <tr>
        <th>Верный ответ</th>
        <th>Формулировка ответа</th>
    </tr>
    </thead>
    <tbody>
    @if (!$answers->isEmpty())
        @foreach($answers as $answer)
            <tr>
                <td>
                    <div class="form-check">
                        <input
                            required
                            class="form-check-input position-static"
                            name='answer.is_right[]'
                            value="{{ $answer->id }}"
                            {{ $answer->is_right ? 'checked' : ''}}
                            type="radio"
                        />
                    </div>
                </td>
                <td>
                    <div class="form-group">
                            <textarea class="form-control"
                                      name='answer[{{$answer->id}}][title]'
                                      cols="6">{{old('answer.'.$answer->id.'.title.', $answer->text)}}</textarea>
                        @if ($errors->has('answer.'.$answer->id.'.title]'))
                            <div
                                class="text-center alert-danger p-1 mb-1">{{ $errors->first('answer.'.$answer->id.'.title') }}</div>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        @for($i = 0; $i < 4; $i++)
            <tr>
                <td>
                    <div class="form-check">
                        <input
                            required
                            class="form-check-input position-static"
                            name='answer.is_right[]'
                            {{ in_array($i, old('answer_is_right') ?? []) ? 'checked' : '' }}
                            value="{{$i}}"
                            type="radio"
                        />
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <textarea
                            class="form-control"
                            name='answer[{{$i }}][title]'
                            cols="6">{{old('answer.'.$i.'.title')}}</textarea>
                        @if ($errors->has('answer.'.$i.'.title'))
                            <div
                                class="text-center alert-danger mb-1 p-1">{{ $errors->first('answer.'.$i.'.title') }}</div>
                        @endif
                    </div>
                </td>
            </tr>
        @endfor
    @endif
    </tbody>
</table>
