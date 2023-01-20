// Call the dataTables jQuery plugin
$(document).ready(function () {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json"
        }
    });
    $('#dataTable2').DataTable({
        "order": [[4, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json"
        }
    });
});
