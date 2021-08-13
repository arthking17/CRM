<table id="datatable-contacts" class="table table-bordered toggle-circle mb-0" data-simplebar style="width: 100%">
    <thead>
        <tr>
            <th></th>
            @if ($headings)
                @for ($i = 0; $i < $columnCount; $i++)
                    <th class="truncate" title="{{ $headings[0][0][$i] }}">
                        {{ $headings[0][0][$i] }}</th>
                @endfor
            @endif
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            @foreach ($contacts[0] as $i => $value)
                <td>
                    <div class="col-8 col-xl-9">
                        <select class="selectize-drop-header @error('column-' . $i) parsley-error @enderror"
                            name="column-{{ $i }}" id="mapping-column-column-{{ $i }}">
                            <option value="">Select an column</option>
                            <option value="source" @if ($i === 0) selected @endif>source</option>
                            <option value="source_id" @if ($i === 1) selected @endif>source_id</option>
                            <option value="status" @if ($i === 2) selected @endif>status</option>
                            @if ($class == 1)
                                <option value="profile" @if ($i === 3) selected @endif>profile</option>
                                <option value="gender" @if ($i === 4) selected @endif>gender</option>
                                <option value="first_name" @if ($i === 5) selected @endif>first_name</option>
                                <option value="last_name" @if ($i === 6) selected @endif>last_name</option>
                                <option value="nickname" @if ($i === 7) selected @endif>nickname</option>
                                <option value="birthdate" @if ($i === 8) selected @endif>birthdate</option>
                                <option value="country" @if ($i === 9) selected @endif>country</option>
                                <option value="language" @if ($i === 10) selected @endif>language</option>
                            @elseif($class == 2)
                                <option value="class" @if ($i === 3) selected @endif>class</option>
                                <option value="name" @if ($i === 4) selected @endif>name</option>
                                <option value="registered_number" @if ($i === 5) selected @endif>registered_number</option>
                                <option value="logo" @if ($i === 6) selected @endif>logo</option>
                                <option value="activity" @if ($i === 7) selected @endif>activity</option>
                                <option value="country" @if ($i === 8) selected @endif>country</option>
                                <option value="language" @if ($i === 9) selected @endif>language</option>
                            @endif
                        </select>
                        @error('column-' . $i)
                            <ul class="parsley-errors-list filled" aria-hidden="false">
                                <li class="parsley-required">
                                    {{ $errors->first('column-' . $i) }}</li>
                            </ul>
                        @else
                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                        @enderror
                    </div>
                </td>
            @endforeach
        </tr>
        @foreach ($contacts as $key => $contact)
            <tr>
                <td></td>
                @if ($headings)
                    @if ($headings[0][0][0] != $contact[0])
                        @for ($i = 0; $i < $columnCount; $i++)
                            <td class="truncate" title="{{ $contact[$i] }}">
                                {{ $contact[$i] }}</td>
                        @endfor
                    @endif
                @else
                    @for ($i = 0; $i < $columnCount; $i++)
                        <td class="truncate" title="{{ $contact[$i] }}">
                            {{ $contact[$i] }}</td>
                    @endfor
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
<input type="hidden" name="class" value="{{ $class }}">
<input type="hidden" name="columnCount" id="columnCount" value="{{ $columnCount }}">
<input type="hidden" name="rowCount" id="rowCount" value="{{ $rowCount }}">
<input type="hidden" name="heading" value="@if($headings) 1 @else 0 @endif">

<div class="text-center">
    <div class="alert alert-warning d-none fade show" id="import-errors">
        <h4 class="mt-0 text-warning">Oh snap!</h4>
        <p class="mb-0">Some rows data seems to be invalid :(</p>
        <p class="mb-0">Go back and check your data</p>
    </div>

    <div class="alert alert-info d-none fade show" id="import-success">
        <h4 class="mt-0 text-info">Yay!</h4>
        <p class="mb-0">Everything seems to be ok :)</p>
    </div>
</div>
