import "./vendor.min.js";
import "../libs/dataTables/jquery.dataTables.min.js";
import "../libs/dataTables/dataTables.bootstrap4.min.js";
import "../libs/dataTables/dataTables.responsive.min.js";
import "../libs/dataTables/responsive.bootstrap4.min.js";
import "../libs/dataTables/dataTables.buttons.min.js";
import "../libs/dataTables/buttons.bootstrap4.min.js";
import "../libs/dataTables/buttons.html5.min.js";
import "../libs/dataTables/buttons.flash.min.js";
import "../libs/dataTables/buttons.print.min.js";
import "../libs/dataTables/dataTables.keyTable.min.js";
import "../libs/dataTables/dataTables.select.min.js";
import "../libs/sweetalert/sweetalert.min.js";
import "../libs/select2/select2.min.js";
import "../libs/smartwizard/jquery.smartWizard.min.js";
import "../libs/flatpickr/flatpickr.min.js";
import "../libs/apexcharts/apexcharts.min.js";
import "./pages/form-wizard.init.js";

// Custom javascript files
import "./hobbies.js";
import "./forms.js";
import "./blends.js";
import "./draws.js";
import "./purchases.js";
import "./products.js";
import "./users.js";
import "./results.js";
import "./reports.js";
import "./app.min.js";

jQuery(document).ready(function() {
    jQuery('.custom-select2').select2();
    jQuery(".flatpickr-input").flatpickr();
});