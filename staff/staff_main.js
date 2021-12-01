//$(document).ready(function() {
//    $('#example').DataTable();
//} );

// Function to create DataTable with Ajax PHP file as JSON data source.
$(document).ready(function() {
    var table = $('#logTable').DataTable( {
		"order": [[ 0, "desc" ]],
        "processing": true,
        "ajax":{
            // PHP File.
            "url":"staff_logDatatable.php",
            "dataSrc":"",
            "method":"post"
        },
        // Keyname for array to identify and put data in DataTables.
        "columns": [
            { "data": "timestamp" },
            { "data": "category" },
            { "data": "type" },
            { "data": "description" },
            { "data": "user_performed" }
        ]
    } );
} );