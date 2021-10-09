<div class="row row-cols-2">
    @foreach ($custom_fields as $custom_field)
    <div class="col">
        <div class="row mb-3">
            <label for="form_edit-{{ $custom_field->tag }}" class="col-4 col-xl-3 col-form-label">
                @if ($custom_field->field_type !== 'checkbox')
                {{ $custom_field->name }}
                @endif
            </label>
            <div class="col-8 col-xl-9">
                @if ($custom_field->field_type === 'text' || $custom_field->field_type === 'number' || $custom_field->field_type === 'url' || $custom_field->field_type === 'datetime')
                <input type="{{ $custom_field->field_type }}" class="form-control @if ($custom_field->field_type === 'datetime') datetimepicker @endif
                                                        @error($custom_field->tag) parsley-error @enderror" name="{{ $custom_field->tag }}" id="form_edit-{{ $custom_field->tag }}" placeholder="@if ($custom_field->field_type === 'datetime') yyyy-mm-dd hh:mm @elseif($custom_field->field_type === 'date') yyyy-mm-dd @else {{ $custom_field->name }} @endif">
                @elseif($custom_field->field_type === 'month')
                <input type="text" class="form-control" data-provide="datepicker" data-date-format="MM yyyy" placeholder="MM yyyy" data-date-min-view-mode="1" name="{{ $custom_field->tag }}" id="form_edit-{{ $custom_field->tag }}">
                @elseif($custom_field->field_type === 'date')
                <input type="text" class="form-control" data-provide="datepicker" placeholder="MM yyyy DD" name="{{ $custom_field->tag }}" id="form_edit-{{ $custom_field->tag }}">
                @elseif($custom_field->field_type === 'color')
                <input type="text" class="form-control colorpicker" name="{{ $custom_field->tag }}" id="form_edit-{{ $custom_field->tag }}">
                @elseif($custom_field->field_type === 'select')
                <select class="form-select @error($custom_field->tag) parsley-error @enderror" name="{{ $custom_field->tag }}" id="form_edit-{{ $custom_field->tag }}">
                    <option value="">Select ...</option>
                    @foreach ($select_options->where('field_id', $custom_field->id) as $key => $opt)
                    <option value="{{ $opt->id }}">
                        {{ $opt->title }}
                    </option>
                    @endforeach
                </select>
                @elseif($custom_field->field_type === 'checkbox')
                <div class="form-check">
                    <label for="form_edit-{{ $custom_field->tag }}" class="form-check-label">{{ $custom_field->name }}</label>
                    <input type="checkbox" class="form-check-input" name="{{ $custom_field->tag }}" id="form_edit-{{ $custom_field->tag }}">
                </div>
                @elseif($custom_field->field_type === 'file')
                <a id="form_edit-{{ $custom_field->tag }}-preview" class="d-none" href="#" target="_blank">view
                    existing
                    {{ $custom_field->tag }}</a><a id="form_edit-{{ $custom_field->tag }}-delete" href="javascript:void(0);" class="action-icon d-none" onclick="#"> <i class="mdi mdi-delete"></i></a>
                <input type="file" name="{{ $custom_field->tag }}" id="form_edit-{{ $custom_field->tag }}" class="form-control @error($custom_field->tag) parsley-error @enderror">
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div> <!-- end row -->