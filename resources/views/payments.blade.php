@extends('layouts.default', ['title' => 'Pagamentos'])
@section('content')


    <div class="row">

        <div class="col-lg-12">

            <form class="row" id="payment-form" method="POST">
                <h5 class="col-12">Insira um novo pagamento</h5>
                <div class="form-group col-6">
                    <label for="paidBy">PaidBy</label>
                    <input class="form-control" name="paidBy" id="paidBy" required>
                </div>
                <div class="form-group col-6">
                    <label for="debtId">DebtId</label>
                    <input class="form-control" name="debtId" id="debtId" type="number" required>
                </div>
                <div class="form-group col-6">
                    <label for="paidAt">PaidAt</label>
                    <input class="form-control" name="paidAt" id="paidAt" type="date" required>
                </div>
                <div class="form-group col-6">
                    <label for="paidAmount">PaidAmount</label>
                    <input class="form-control" name="paidAmount" id="paidAmount" type="number" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                        <span class="text">Pagar</span>
                    </button>
                </div>
            </form>

        </div>

        <div class="col-lg-12 mt-5">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ultimos Pagamentos</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>DebtId</th>
                                <th>PaidBy</th>
                                <th>PaidAt</th>
                                <th>PaidAmount</th>
                                <th>Created</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>DebtId</th>
                                <th>PaidBy</th>
                                <th>PaidAt</th>
                                <th>PaidAmount</th>
                                <th>Created</th>
                            </tr>
                            </tfoot>
                            <tbody id="payments">
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->debtId }}</td>
                                    <td>{{ $payment->paidBy }}</td>
                                    <td>{{ $payment->paidAtFormat }}</td>
                                    <td>{{ $payment->paidAmountFormat }}</td>
                                    <td>{{ $payment->createdAtFormat }}</td>
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
