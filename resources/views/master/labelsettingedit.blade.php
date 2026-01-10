@extends('layouts.blank')

@section('pagecontent')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Labels</h5>
        </div>

        <div class="card-body">
            <form action="{{ url('/update_lable') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3 d-flex gap-2 flex-wrap" id="presetButtons">
    {{-- <button type="button" class="btn btn-outline-primary" id="presetSpare">Spare Parts</button>
    <button type="button" class="btn btn-outline-success" id="presetMedical">Medical</button> --}}

    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#presetModal">
        + Add Preset
    </button>
</div>



                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Field Name</th>
                                <th>Replaced Field Name</th>
                               <th class="text-center">
    Visible
    <div class="mt-1">
        <button type="button" class="btn btn-sm btn-success" id="markAllYes">
            Yes
        </button>
        <button type="button" class="btn btn-sm btn-danger" id="markAllNo">
            No
        </button>
    </div>
</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $label)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <input type="hidden" name="labels[{{ $index }}][id]" value="{{ $label->id }}">

                                <td>
                                    <input type="text"
                                           name="labels[{{ $index }}][field_name]"
                                           class="form-control"
                                           value="{{ $label->field_name }}">
                                </td>

                                <td>
                                    <input type="text"
       name="labels[{{ $index }}][replaced_field_name]"
       class="form-control replaced-field"
       value="{{ $label->replaced_field_name }}">

                                </td>

                                <td class="text-center">
                                   <select name="labels[{{ $index }}][is_visible]"
        class="form-select is-visible-select">
    <option value="1" {{ $label->is_visible == 1 ? 'selected' : '' }}>Yes</option>
    <option value="0" {{ $label->is_visible == 0 ? 'selected' : '' }}>No</option>
</select>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">
                        Update Labels
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<div class="modal fade" id="presetModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Preset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Preset Name</label>
                    <input type="text" id="presetName" class="form-control" placeholder="Eg: Electrical">
                </div>

                <div id="presetFields">
                    @foreach ($data as $label)
                        <div class="row mb-2">
                            <div class="col-md-5">
                                <input type="text" class="form-control" value="{{ $label->field_name }}" readonly>
                            </div>
                            <div class="col-md-7">
                                <input type="text"
                                       class="form-control preset-input"
                                       data-field="{{ $label->field_name }}"
                                       placeholder="Rename to...">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="savePreset">Save Preset</button>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('markAllYes').addEventListener('click', function () {
        document.querySelectorAll('.is-visible-select').forEach(select => {
            select.value = '1';
        });
    });

    document.getElementById('markAllNo').addEventListener('click', function () {
        document.querySelectorAll('.is-visible-select').forEach(select => {
            select.value = '0';
        });
    });
</script>
<script>
/* =========================
   CONFIG
========================= */
const STORAGE_KEY = 'label_presets';

/* =========================
   LOAD PRESETS
========================= */
let presets = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};

/* =========================
   APPLY PRESET
========================= */
function applyPreset(map) {
    document.querySelectorAll('tbody tr').forEach(row => {
        const field = row.querySelector('input[name*="[field_name]"]').value.trim();
        const replace = row.querySelector('.replaced-field');

        if (map[field] !== undefined) {
            replace.value = map[field];
        }
    });
}

/* =========================
   RENDER PRESET BUTTONS
========================= */
function renderPresetButtons() {
    const container = document.getElementById('presetButtons');

    container.querySelectorAll('.dynamic-preset').forEach(el => el.remove());

    Object.keys(presets).forEach(name => {
        const group = document.createElement('div');
        group.className = 'btn-group me-2 dynamic-preset';

        // APPLY
        const applyBtn = document.createElement('button');
        applyBtn.type = 'button';
        applyBtn.className = 'btn btn-outline-warning';
        applyBtn.innerText = name;
        applyBtn.onclick = () => applyPreset(presets[name]);

        // EDIT
        const editBtn = document.createElement('button');
        editBtn.type = 'button';
        editBtn.className = 'btn btn-outline-primary';
        editBtn.innerHTML = '<i class="fa fa-edit"></i>';
        editBtn.onclick = () => editPreset(name);

        // DELETE
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn btn-outline-danger';
        deleteBtn.innerHTML = '<i class="fa fa-trash"></i>';
        deleteBtn.onclick = () => deletePreset(name);

        group.append(applyBtn, editBtn, deleteBtn);
        container.prepend(group);
    });
}

/* =========================
   SAVE / UPDATE PRESET
========================= */
document.getElementById('savePreset').addEventListener('click', function () {
    const name = document.getElementById('presetName').value.trim();

    if (!name) {
        alert('Preset name is required');
        return;
    }

    const map = {};
    document.querySelectorAll('.preset-input').forEach(input => {
        if (input.value.trim()) {
            map[input.dataset.field] = input.value.trim();
        }
    });

    presets[name] = map;
    localStorage.setItem(STORAGE_KEY, JSON.stringify(presets));

    renderPresetButtons();

    // Reset modal
    document.getElementById('presetName').value = '';
    document.querySelectorAll('.preset-input').forEach(i => i.value = '');

    bootstrap.Modal.getInstance(document.getElementById('presetModal')).hide();
});

/* =========================
   EDIT PRESET
========================= */
function editPreset(name) {
    document.getElementById('presetName').value = name;

    const map = presets[name];
    document.querySelectorAll('.preset-input').forEach(input => {
        input.value = map[input.dataset.field] ?? '';
    });

    new bootstrap.Modal(document.getElementById('presetModal')).show();
}

/* =========================
   DELETE PRESET
========================= */
function deletePreset(name) {
    if (!confirm(`Delete preset "${name}"?`)) return;

    delete presets[name];
    localStorage.setItem(STORAGE_KEY, JSON.stringify(presets));
    renderPresetButtons();
}

/* =========================
   INIT
========================= */
renderPresetButtons();
</script>


@endsection
