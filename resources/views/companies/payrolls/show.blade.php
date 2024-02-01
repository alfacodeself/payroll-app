@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Payroll Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Note</th>
                                        <th>Base Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payroll->payrollDetails as $payroll_detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $payroll_detail->note }}
                                            </td>
                                            <td>{{ 'Rp. ' . number_format($payroll_detail->base_price) }}</td>
                                            <td>{{ $payroll_detail->qty }}</td>
                                            <td>
                                                {{ 'Rp. ' . number_format($payroll_detail->total) }}
                                                @if ($payroll_detail->payroll_type->name == 'ADDITIONAL')
                                                    <strong class="text-success">( + )</strong>
                                                @else
                                                    <strong class="text-danger">( - )</strong>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">There's no payroll_detail detail</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Sub Total</strong></td>
                                        <td>
                                            <strong>{{ 'Rp. ' . number_format($payroll->total_amount) }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
