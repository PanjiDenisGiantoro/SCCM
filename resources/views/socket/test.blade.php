@extends('layout.layout2')

@php
    $title = "API Test Result";
    $subTitle = 'IoT API Response Monitoring';
    $isEdit = isset($existingData); // Cek apakah ini edit atau tambah
@endphp

@section('content')

    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h4>API Test Result</h4>
            <a href="{{ route('socket.list') }}" class="btn btn-primary mt-3">Back</a>
        </div>
        <p><strong>Host:</strong> {{ $api->host }}</p>
        <p><strong>Port:</strong> {{ $api->port }}</p>
        <p><strong>Endpoint:</strong> {{ $api->endpoint }}</p>

        <div class="card">
            <div class="card-header">Response</div>
            <div class="card-body">
                <pre class="p-2 bg-light border rounded">
                    <code class="json">
                        {!! json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
                    </code>
                </pre>
            </div>
        </div>

        <h5 class="mt-4">{{ $isEdit ? 'Edit' : 'Select' }} Data</h5>
        <form method="POST" action="{{ $isEdit ? url('socket/update_alarm/'.$api->id) : url('socket/store_alarm') }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Edit List
                        </div>
                        <div class="card-body">
                            @php
                                // Jika edit, gunakan existingData, jika tidak, gunakan hasil API
                                $readResults = $isEdit ? ($existingData ?? []) : ($data['readResults'] ?? []);
                                     if (!is_array(reset($readResults))) {
                $readResults = [$readResults]; // Ubah menjadi array multidimensi jika perlu
            }
                            @endphp
                            @if(is_array($readResults))
                                @foreach($readResults as $index => $result)
                                    <div class="border p-3 mb-3 data-box" id="box_{{ $index }}">
                                        @foreach($result as $key => $value)
                                            @php $checked = $isEdit && isset($existingData[$index][$key]); @endphp
                                            <div class="form-check mt-2">
                                                <input class="form-check-input checkbox-item" type="checkbox"
                                                       id="select_{{ $index }}_{{ $key }}"
                                                       onchange="toggleInput(this, '{{ $index }}', '{{ $key }}')" {{ $checked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="select_{{ $index }}_{{ $key }}">
                                                    <strong>{{ ucfirst($key) }}:</strong> {{ $value }}
                                                </label>
                                            </div>
                                            <input type="text" name="readResults[{{ $index }}][{{ $key }}]"
                                                   class="form-control mt-1 input-item"
                                                   id="input_{{ $index }}_{{ $key }}"
                                                   value="{{ $value }}" {{ $checked ? '' : 'style=display:none;' }} {{ $checked ? '' : 'disabled' }}>
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                <p>No data available</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                Add List
                            </div>
                            @if(isset($data['readResults']) && is_array($data['readResults']))
                                @foreach($data['readResults'] as $index => $result)
                                    @php
                                        // Cek apakah data ini sudah ada di existingData (hanya untuk form add)
                                        $isExisting = false;
                                        if (isset($existingData)) {
                                            foreach ($existingData as $existingIndex => $existingResult) {
                                                if ($existingResult == $result) {
                                                    $isExisting = true;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp

                                    @if(!$isExisting)
                                        <div class="border p-3 mb-3 data-box" id="box_{{ $index }}">
                                            <strong>Data {{ $index + 1 }}</strong>
                                            @foreach($result as $key => $value)
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input checkbox-item" type="checkbox" id="select_{{ $index }}_{{ $key }}"
                                                           onchange="toggleInput(this, '{{ $index }}', '{{ $key }}')">
                                                    <label class="form-check-label" for="select_{{ $index }}_{{ $key }}">
                                                        <strong>{{ ucfirst($key) }}:</strong> {{ $value }}
                                                    </label>
                                                </div>
                                                <input type="text" name="readResults[{{ $index }}][{{ $key }}]" class="form-control mt-1 input-item"
                                                       id="input_{{ $index }}_{{ $key }}" style="display: none;" value="{{ $value }}" disabled>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p>No data available</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="api_id" value="{{ $api->id  ?? ''}} ">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success mt-3">{{ $isEdit ? 'Update' : 'Save' }} Selection</button>
            </div>
        </form>
    </div>

    <script>
        function toggleInput(checkbox, index, key) {
            let inputField = document.getElementById(`input_${index}_${key}`);
            let dataBox = document.getElementById(`box_${index}`);

            if (checkbox.checked) {
                inputField.style.display = 'block';
                inputField.disabled = false;
                dataBox.classList.add('selected-box');
            } else {
                inputField.style.display = 'none';
                inputField.disabled = true;
                let checkboxes = dataBox.querySelectorAll('.checkbox-item');
                let isChecked = Array.from(checkboxes).some(cb => cb.checked);
                if (!isChecked) {
                    dataBox.classList.remove('selected-box');
                }
            }
        }
    </script>

@endsection
