@extends('layouts.default', ['title' => 'Fila de E-mails'])
@section('content')


    <div class="row">

        <div class="col-lg-12 mt-5">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Fila de emails</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Email</th>
                                <th>Boleto</th>
                                <th>DebtID</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Email</th>
                                <th>Boleto</th>
                                <th>DebtID</th>
                                <th>Status</th>
                            </tr>
                            </tfoot>
                            <tbody id="payments">
                            @foreach($emails as $email)
                                <tr>
                                    <td>{{ $email->email }}</td>
                                    <td>{{ $email->ticket_barcode }}</td>
                                    <td>{{ $email->debtId }}</td>
                                    <td>
                                        <span class='badge badge-{{
                                        $email->status == 'sent' ? "success" :
                                        ($email->status == 'pending' ? "warning" : "danger")}}'>
                                            {{
                                        $email->status == 'sent' ? "Enviado" :
                                        ($email->status == 'pending' ? "Pendente" : "Falha")}}
                                        </span>
                                    </td>
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
