@extends('layout.layout2')

@section('content')
    <div class="container">
        <h2>Facility Details</h2>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title" id="facility_name"></h4>

                <p><strong>Category:</strong> <span id="facility_category"></span></p>
                <p><strong>Account:</strong> <span id="facility_account"></span></p>
                <p><strong>Description:</strong> <span id="facility_description"></span></p>
                <p><strong>Status:</strong> <span id="facility_status"></span></p>
                <p><strong>Location:</strong> <span id="facility_location"></span></p>

                <h5>Attached Files</h5>
                <ul id="facility_files"></ul>

                <a href="" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('facilities.show', $id) }}")
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("facility_name").textContent = data.data.name;
                        document.getElementById("facility_category").textContent = data.data.category;
                        document.getElementById("facility_account").textContent = data.data.account_id;
                        document.getElementById("facility_description").textContent = data.data.description;
                        document.getElementById("facility_status").textContent = data.data.status;
                        document.getElementById("facility_location").textContent = data.data.location ? data.data.location.address : "N/A";

                        let fileList = document.getElementById("facility_files");
                        fileList.innerHTML = "";

                        data.data.files.forEach(file => {
                            let li = document.createElement("li");
                            li.innerHTML = `<a href="/file/${file.file}" target="_blank">${file.file}</a>`;
                            fileList.appendChild(li);
                        });
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => console.log("Error:", error));
        });
    </script>
@endsection
