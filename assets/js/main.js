import "./vendor.min.js";
import "./app.min.js";
import "../libs/datatables/jquery.dataTables.min.js";
import "../libs/datatables/dataTables.bootstrap4.min.js";
import "../libs/datatables/dataTables.responsive.min.js";
import "../libs/datatables/responsive.bootstrap4.min.js";

import "../libs/datatables/dataTables.buttons.min.js";
import "../libs/datatables/buttons.bootstrap4.min.js";
import "../libs/datatables/buttons.html5.min.js";
import "../libs/datatables/buttons.flash.min.js";
import "../libs/datatables/buttons.print.min.js";
import "../libs/datatables/dataTables.keyTable.min.js";
import "../libs/datatables/dataTables.select.min.js";


// Add datatable options to custom tables
$(".custom-datatable").DataTable({
    "language": {
        "url": "assets/json/datatable_spanish.json"
    }
});