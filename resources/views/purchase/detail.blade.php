@extends('layout.layout2')

@php
    $title = 'Detail Purchase Request';
    $subTitle = 'Detail Purchase Request';
@endphp

@section('content')
    <style>
        .signatures-container {
            display: flex;
            margin-top: 100px;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: end;
            max-height: 200px; /* Batasi tinggi maksimal */
            gap: 16px; /* Beri jarak antar item */
        }

        .signature-box {
            text-align: center;
            padding: 8px 12px;
            border-top: 1px solid black;
            min-width: 120px; /* Atur lebar minimal agar rapi */
            min-height: 100px; /* Atur tinggi minimal agar rapi */
        }

    </style>
    <div class="dashboard-main-body">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                    {{--                <a href="javascript:void(0)" class="btn btn-sm btn-primary-600 radius-8 d-inline-flex align-items-center gap-1">--}}
                    {{--                    <iconify-icon icon="pepicons-pencil:paper-plane" class="text-xl"></iconify-icon>--}}
                    {{--                    Generate PO--}}
                    {{--                </a>--}}
                    @if($purchase->user_id != Auth::user()->id)
                        @if(in_array(Auth::user()->id, $approve))
                            <a href="javascript:void(0)"
                               class="btn btn-sm @if($approveuser->approval_required == 'PENDING')
                                    btn-outline-warning
                                @elseif($approveuser->approval_required == 'APPROVE')
                                    btn-outline-success
                                @elseif($approveuser->approval_required == 'REJECT')
                                    btn-outline-danger
                                @endif radius-8 d-inline-flex align-items-center gap-1"
                               data-bs-toggle="modal" data-bs-target="#approveModal">
                                <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                @if($approveuser->approval_required == 'PENDING')
                                    Approve
                                @elseif($approveuser->approval_required == 'APPROVE')
                                    Approved
                                @elseif($approveuser->approval_required == 'REJECT')
                                    Rejected
                                @endif
                            </a>
                        @endif
                    @endif
                    <a href="{{ url('purchase/download/' . $purchase->id ) }}" target="_blank"
                       class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1"
                       onclick="printInvoice()">
                        <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                        Print
                    </a>
                    @if($purchase->user_id == Auth::user()->id && $purchase->status == 1 && $purchase->sync == 0)
                    <a href="javascript:void(0)"
                       class="btn btn-sm btn-outline-info radius-8 d-inline-flex align-items-center gap-1"
                       data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <iconify-icon icon="pepicons-pencil:paper-plane" class="text-xl"></iconify-icon>
                        Generate PO
                    </a>
                    @endif

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Generate Purchase Order</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="generatePoForm" action="{{ url('purchase/generate-po') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="poNumber" class="form-label">Nomor PO</label>
                                            @php
                                            $randvalue = \App\Models\PurchaseOrder::where('id', '>', 0)->max('id') + 1;
                                            $randvalue = str_pad($randvalue, 5, '0', STR_PAD_LEFT);
                                            $randvalue = 'PO-' .date('YmdHi') . '-' . $randvalue;
                                                @endphp
                                            <input type="hidden" name="id" value="{{ $purchase->id ?? '' }}">
                                            <input type="text" class="form-control" id="poNumber" name="po_number" placeholder="Masukkan Nomor PO" readonly required value="{{ $randvalue }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-outline-info">Generate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <a href="{{ url('purchase/list') }}" class="btn btn-sm btn-primary radius-8 d-inline-flex align-items-center gap-1">
                        <iconify-icon icon="ic:baseline-arrow-back" class="text-xl"></iconify-icon>
                        Back
                    </a>
                </div>
            </div>
            <div class="card-body py-40">

                <div class="row justify-content-center" id="invoice">
                    <div class="col-lg-8">
                        <div class="shadow-4 border radius-8">
                            <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                <div>
                                    <h3 class="text-xl"> {{ $purchase->no_pr }} ( @if($purchase->status == 0) Pending @elseif($purchase->status == 1) Approved @elseif($purchase->status == 2) Rejected @endif )</h3>
                                    <p class="mb-1 text-sm">Date Issued: {{ $purchase->request_date }}</p>
                                    <p class="mb-0 text-sm">Date Due: {{ $purchase->required_date }}</p>
                                </div>
                                <div>

                                    <img
                                        src="{{ !empty($clients->logo) ? asset('storage/' . ltrim($clients->logo, '/')) : asset('assets/images/avatar/avatar1.png') }}"
                                        alt="image" class="mb-8">
                                    <p class="mb-1 text-sm">{{ $clients->nameClient }}</p>
                                    <p class="mb-0 text-sm">{{ $clients->addressClient  }}</p>
                                </div>
                            </div>
                            <div class="py-28 px-20">
                                <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                                    <div>
                                        <h6 class="text-md">Issus For:</h6>
                                        <table class="text-sm text-secondary-light">
                                            <tbody>
                                            <tr>
                                                <td>Name</td>
                                                <td class="ps-8">:{{ $business->business_name ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td class="ps-8">:{{ $business->address ?? '' }}
                                                    , {{ $business->city ?? '' }}, {{ $business->country ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone number</td>
                                                <td class="ps-8">:{{ $business->phone ?? ''  }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <table class="text-sm text-secondary-light">
                                            <tbody>
                                            <tr>
                                                <td></td>
                                                <td class="ps-8"></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="ps-8"></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="ps-8"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-24">
                                    <div class="table-responsive scroll-sm">
                                        <table class="table bordered-table text-sm">
                                            <thead>
                                            <tr>
                                                <th scope="col" class="text-sm">SL.</th>
                                                <th scope="col" class="text-sm">Items</th>
                                                <th scope="col" class="text-sm">Type</th>
                                                <th scope="col" class="text-sm">Qty</th>
                                                <th scope="col" class="text-sm">Unit Price</th>
                                                <th scope="col" class="text-end text-sm">Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($purchase->purchaseBodies as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if($item->model === 'part')
                                                            {{ $item->part->nameParts ?? '' }}
                                                        @elseif($item->model === 'facility')
                                                            {{ $item->facility->name ?? '' }}
                                                        @elseif($item->model === 'equipment')
                                                            {{ $item->equipment->name ?? '' }}
                                                        @elseif($item->model === 'tools')
                                                            {{ $item->tools->name ?? '' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->model }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td >{{ isset($item->unit_price) ? number_format($item->unit_price, 0, ',', '.') : '-' }}</td>
                                                    <td class="text-end">{{ isset($item->total_price) ? number_format($item->total_price, 0, ',', '.') : '-' }}</td>

                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between gap-3">
                                        <div>
                                            <p class="text-sm mb-0"><span class="text-primary-light fw-semibold">Sales By:</span> {{ $purchase->users->name ?? '' }}
                                            </p>
                                            <p class="text-sm mb-0">Thanks for your business</p>
                                        </div>
                                        <div>
                                            <table class="text-sm">
                                                <tbody>
                                                <tr>
                                                    <td class="pe-64">Subtotal:</td>
                                                    <td class="pe-16">
                                                        <span
                                                            class="text-primary-light fw-semibold">  {{ isset($purchase->total) ? number_format($purchase->total, 0, ',', '.') : '-' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-64">Discount:</td>
                                                    <td class="pe-16">
                                                        <span class="text-primary-light fw-semibold">0.00</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-64 border-bottom pb-4">Tax:</td>
                                                    <td class="pe-16 border-bottom pb-4">
                                                        <span class="text-primary-light fw-semibold">0.00</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-64 pt-4">
                                                        <span class="text-primary-light fw-semibold">Total:</span>
                                                    </td>
                                                    <td class="pe-16 pt-4">
                                                        <span


                                                            class="text-primary-light fw-semibold">  {{ isset($purchase->total) ? number_format($purchase->total, 0, ',', '.') : '-' }}</span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-64">
                                    <p class="text-center text-secondary-light text-sm fw-semibold">Thank you for your
                                        purchase!</p>
                                </div>

                                <div class="signatures-container">
                                    @foreach($approve_user as $user)
                                        <div class="signature-box">
                                            {{ $user->user->name ?? '' }} ({{ $user->user->roles[0]->name ?? '' }})

                                            @if($user->approval_required == 'APPROVE')
                                                <iconify-icon icon="ic:baseline-check-circle" class="text-success" style="font-size: 18px;"></iconify-icon>
                                            @else
                                                <iconify-icon icon="ic:baseline-cancel" class="text-danger" style="font-size: 18px;"></iconify-icon>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h7 class="modal-title" id="approveModalLabel">Purchase Request <b>{{ $purchase->no_pr ?? '' }}</b>
                    </h7>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('purchase/approve/' . $purchase->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_user" value="{{ $purchase->user_id ?? '' }}">
                    <input type="hidden" name="id" value="PR">
                    <input type="hidden" name="id_pr" value="{{ $purchase->id ?? '' }}">
                    <input type="hidden" name="action" id="actionInput"> <!-- Input hidden untuk action -->
                    <div class="modal-body d-flex flex-column gap-3">
                        <button type="submit" name="actionBtn" value="reject" class="btn btn-danger">Reject</button>
                        <button type="submit" name="actionBtn" value="approve" class="btn btn-success">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
<script>
    function printInvoice() {
        var printContents = document.getElementById('invoice').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const approveForm = document.querySelector("#approveForm");
        const actionInput = document.querySelector("#actionInput");

        approveForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Mencegah submit langsung

            const action = event.submitter.value; // Menentukan tombol yang diklik
            actionInput.value = action; // Set input hidden dengan nilai yang sesuai

            let confirmText = action === "approve" ? "Are you sure to approve this request?" : "Are you sure to reject this request?";
            let buttonColor = action === "approve" ? "#28a745" : "#dc3545";

            Swal.fire({
                title: "Confirmation",
                text: confirmText,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: buttonColor,
                cancelButtonColor: "#6c757d",
                confirmButtonText: action === "approve" ? "Yes, Approve" : "Yes, Reject",
            }).then((result) => {
                if (result.isConfirmed) {
                    approveForm.submit(); // Kirim form setelah konfirmasi
                }
            });
        });
    });
</script>
