@extends('layouts.default', ['title' => 'Faturas'])
@section('content')

    <div class="row">

        <div class="col-lg-12">
            <form class="row ml-1" id="invoice-upload-form" method="POST">

                <div class="col-8">

                    <div class="input-group custom-file-button">
                        <label class="input-group-text" for="csv">Selecione um arquivo CSV</label>
                        <input type="file" class="form-control" id="csv" accept=".csv">
                    </div>

                </div>

                <div class="col-4">
                    <button class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                        <span class="text">Upload</span>
                    </button>
                </div>
            </form>

            <form class="row mt-5" id="invoice-form" method="POST">
                <h5 class="col-12">Insira uma nova fatura</h5>
                <div class="form-group col-6">
                    <label for="debtId">DebtId</label>
                    <input class="form-control" name="debtId" id="debtId" type="number" required>
                </div>
                <div class="form-group col-6">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" id="name" required>
                </div>
                <div class="form-group col-6">
                    <label for="governmentId">GovernmentId</label>
                    <input class="form-control" name="governmentId" id="governmentId" type="number" required
                           maxlength="11" minlength="11">
                </div>
                <div class="form-group col-6">
                    <label for="email">Email</label>
                    <input class="form-control" name="email" id="email" type="email" required>
                </div>
                <div class="form-group col-6">
                    <label for="debtAmount">DebtAmount</label>
                    <input class="form-control" name="debtAmount" id="debtAmount" type="number" required>
                </div>
                <div class="form-group col-6">
                    <label for="debtDueDate">DebtDueDate</label>
                    <input class="form-control" name="debtDueDate" id="debtDueDate" type="date" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                        <span class="text">Criar Fatura</span>
                    </button>
                </div>
            </form>

        </div>

        <div class="col-lg-12 mt-5">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ultimas Faturas</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>DebtId</th>
                                <th>Nome</th>
                                <th>Documento</th>
                                <th>Email</th>
                                <th>Valor</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th>Valor Pago</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>DebtId</th>
                                <th>Nome</th>
                                <th>Documento</th>
                                <th>Email</th>
                                <th>Valor</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th>Valor Pago</th>
                            </tr>
                            </tfoot>
                            <tbody id="payments">
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->debtId }}</td>
                                    <td>{{ $invoice->name }}</td>
                                    <td>{{ $invoice->governmentId }}</td>
                                    <td>{{ $invoice->email }}</td>
                                    <td>{{ $invoice->debtAmountFormat }}</td>
                                    <td>{{ $invoice->debtDueDateFormat }}</td>
                                    <td><span
                                            class='badge badge-{{$invoice->paid ? "success" : "warning"}}'>{{$invoice->paid ? "Pago" : "Pendente"}}</span>
                                    </td>
                                    <td>{{ $invoice->valuePaidFormat }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
