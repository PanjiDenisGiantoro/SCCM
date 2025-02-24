<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Chart</title>
    <script src="https://balkan.app/js/OrgChart.js"></script>
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>

</head>
<body>
<div id="tree">

</div>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ url('organitation/dataStructure') }}")
            .then(response => response.json())
            .then(data => {
                new OrgChart(document.getElementById("tree"), {
                    nodes: data,
                    nodeBinding: {
                        field_0: "name",
                        field_1: "title"
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>
</body>
</html>
