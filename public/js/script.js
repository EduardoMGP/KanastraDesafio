$("#payment-form").submit(function (event) {
    event.preventDefault();
    $.ajax({
        url: '/api/payment',
        type: 'POST',
        data: {
            'paidBy': $('#paidBy').val(),
            'debtId': $('#debtId').val(),
            'paidAt': $('#paidAt').val(),
            'paidAmount': $('#paidAmount').val()
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
                    data.paidAt,
                    data.paidAmount,
                    data.created_at,
            ]).order([4, 'desc']).draw();

        },
        error: function (data, textStatus, errorThrown) {
            let message = data.responseJSON.message;
            iziToast.error({
                title: 'Error',
                message: message,
            });
        }
    });
});

$("#invoice-form").submit(function (event) {
    event.preventDefault();
    var data = 'name,governmentId,email,debtAmount,debtDueDate,debtId\r\n';
    data +=
        $('#name').val() + ',' +
        $('#governmentId').val() + ',' +
        $('#email').val() + ',' +
        $('#debtAmount').val() + ',' +
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
        },
        error: function (data, textStatus, errorThrown) {
            console.log(data);
            let message = data.responseJSON.message;
            iziToast.error({
                title: 'Error',
                message: message,
            });
        }
    });
});

$("#invoice-upload-form").submit(function (event) {
    event.preventDefault();
    var fd = new FormData();
    var file = $('#csv')[0].files;
    fd.append('csv', file[0]);
    console.log(fd);
    $.ajax({
        url : '/api/invoice/upload',
        type : "POST",
        data : fd,
        contentType : false,
        processData : false,
        success: function (data) {
            iziToast.success({
                title: 'OK',
                message: data.message,
            });
        },
        error: function (data, textStatus, errorThrown) {
            console.log(data);
            let message = data.responseJSON.message;
            iziToast.error({
                title: 'Error',
                message: message,
            });
        }
    });
});
