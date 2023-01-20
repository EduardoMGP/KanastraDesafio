$("#payment-form").submit(function (event) {
    event.preventDefault();

    let date = new Date($('#paidAt').val());
    let formattedDate = date.toISOString().slice(0, 19).replace('T', ' ');

    $.ajax({
        url: '/api/payment',
        type: 'POST',
        data: {
            'paidBy': $('#paidBy').val(),
            'debtId': $('#debtId').val(),
            'paidAt': formattedDate,
            'paidAmount': moneyToNumber($('#paidAmount').val()),
        },
        success: function (data) {
            iziToast.success({
                title: 'OK',
                message: data.message,
            });
            data = data.data;
            var dataTable = $('#dataTable2').DataTable();
            dataTable.row.add([
                data.debtId,
                data.paidBy,
                data.paidAtFormat,
                data.paidAmount,
                data.createdAtFormat,
            ]).order([4, 'desc']).draw();

        },
        error: function (data, textStatus, errorThrown) {
            error(data);
        }
    });
});

$("#invoice-form").submit(function (event) {
    event.preventDefault();
    var data = 'name,governmentId,email,debtAmount,debtDueDate,debtId\r\n';
    data +=
        $('#name').val() + ',' +
        cpfToNumber($('#governmentId').val()) + ',' +
        $('#email').val() + ',' +
        moneyToNumber($('#debtAmount').val()) + ',' +
        $('#debtDueDate').val() + ',' +
        $('#debtId').val();
    $.ajax({
        url: '/api/invoices',
        type: 'POST',
        data: data,
        headers: {
            'content-type': 'text/plain'
        },
        success: function (data) {
            iziToast.success({
                title: 'OK',
                message: data.message,
            });

            var dataTable = $('#dataTable2').DataTable();
            data = data.data.created;
            for (var i = 0; i < data.length; i++) {
                dataTable.row.add([
                    data[i].debtId,
                    data[i].name,
                    data[i].governmentId,
                    data[i].email,
                    data[i].debtAmountFormat,
                    data[i].debtDueDateFormat,
                    "<span class='badge badge-warning'>Pendente</span>",
                    data[i].valuePaidFormat,
                ]);
            }

            dataTable.draw();
        },
        error: function (data, textStatus, errorThrown) {
            error(data);
        }
    });
});

$("#invoice-upload-form").submit(function (event) {
    event.preventDefault();
    var fd = new FormData();
    var file = $('#csv')[0].files;
    fd.append('csv', file[0]);
    $.ajax({
        url: '/api/invoice/upload',
        type: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: function (data) {
            iziToast.success({
                title: 'OK',
                message: data.message,
            });

            var dataTable = $('#dataTable2').DataTable();
            data = data.data.created;
            for (var i = 0; i < data.length; i++) {
                dataTable.row.add([
                    data[i].debtId,
                    data[i].name,
                    data[i].governmentId,
                    data[i].email,
                    data[i].debtAmountFormat,
                    data[i].debtDueDateFormat,
                    "<span class='badge badge-warning'>Pendente</span>",
                    data[i].valuePaidFormat,
                ]);
            }

            dataTable.draw();
        },
        error: function (data, textStatus, errorThrown) {
            error(data);
        }
    });
});

function moneyToNumber(val) {
    return val.replaceAll('.', '').replaceAll(',', '.');
}

function cpfToNumber(val) {
    return val.replaceAll('.', '').replaceAll('-', '');
}

function error(data) {
    let message = data.responseJSON.message;
    data = data.responseJSON.data;
    Object.keys(data).forEach(key => {
        let error = '';
        for (let i = 0; i < data[key].length; i++) {
            error += data[key][i] + ' ';
        }
        message += '<br>' + error;
    });
    iziToast.error({
        title: 'Error',
        message: message,
    });
}


$('.money').mask('#.##0,00', {reverse: true});
$('.cpf').mask('000.000.000-00', {reverse: true});
