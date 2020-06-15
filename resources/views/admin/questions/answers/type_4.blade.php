<input type="hidden" name="question_id" value="{{$question->id}}"/>
<input type="hidden" name="new_value" value="{{$answers->isEmpty() ? 1 : 0}}"/>
    <table class="table table-striped">
    <thead>
    <tr>
        <th>Порядок следования</th>
        <th>Формулировка ответа</th>
    </tr>
    </thead>
    <tbody>
    @if (!$answers->isEmpty())
        @foreach($answers as $answer)
            <tr>
                <td class="d-flex">
                    <div class="form-check">
                        <input class="form-check-input position-static"
                               min="1"
                               max="4"
                               name='answer[{{$answer->id}}][is_right]'
                               value="{{old('answer.'.$answer->id.'.is_right', $answer->is_right)}}"
                               type="number"
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
                <td class="d-flex">
                    <div class="form-check">
                        <input
                            min="1"
                            max="4"
                            class="form-check-input position-static"
                            name='answer[{{$i}}][is_right]'
                            value="{{old('answer.'.$i.'.is_right')}}"
                            type="number"
                        />
                    </div>
                    @if ($errors->has('answer.'.$i.'.is_right'))
                        <div
                            class="text-center alert-danger mb-1 p-1">{{ $errors->first('answer.'.$i.'.is_right') }}</div>
                    @endif
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
