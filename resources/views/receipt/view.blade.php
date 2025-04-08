@extends('layout.layout2')

@php
    $title = 'Receipt';
    $subTitle = 'Receipt Detail';
@endphp

@section('content')

    <div class="card small-card mt-3">
        <div class="card-header d-flex justify-content-between p-2">
            <h5 class="m-0">Receipt Detail</h5>
            <a href="{{ route('receipt.list') }}" class="btn btn-dark btn-sm">Back</a>
        </div>
        <div class="card-body p-2 ">
            <div class="row">
                <div class="col-md-4">
                    <strong>Receipt Code:</strong> {{ $receipt->receipt_number ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>PO Number:</strong> {{ $receipt->pos->po_number ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Status:</strong> {{ ucfirst($receipt->status ?? 'draft') }}
                </div>
                <div class="col-md-4 mt-2">
                    <strong>Supplier:</strong> {{ $receipt->business->business_name ?? '-' }}
                </div>
                <div class="col-md-4 mt-2">
                    <strong>Packing Slip:</strong> {{ $receipt->packing_slip ?? '-' }}
                </div>
                <div class="col-md-4 mt-2">
                    <strong>No. Surat Jalan:</strong> {{ $receipt->no_jalan ?? '-' }}
                </div>
                <div class="col-md-4 mt-2">
                    <strong>Date Ordered:</strong> {{ $receipt->receipt_date ?? '-' }}
                </div>

            </div>
        </div>
    </div>

    <div class="card small-card mt-4">
        <div class="card-header p-2">
            <h6 class="small-text">Lines</h6>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-sm basic-table mb-0">
                    <thead>
                    <tr>
                        <th>Asset Type</th>
                        <th>Asset Name</th>
                        <th>Qty Received</th>
                        <th>Unit Price</th>
                        <th>Received To</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($receipt->receipt_body as $item)
                        <tr>
                            <td>
                                @if($item->part)
                                    Part
                                @elseif($item->equipment)
                                    Equipment
                                @elseif($item->tools)
                                    Tools
                                @elseif($item->facility)
                                    Facility
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{ $item->part->nameParts ?? $item->equipment->name ?? $item->tools->name ?? $item->facility->name ?? '-' }}
                            </td>
                            <td>{{ $item->qty_received ?? '-' }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ $item->received_to ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No line items available</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
