@extends('staff.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Sender - Staff')</th>
                                <th>@lang('Receiver - Branch  ')</th>
                                <th>@lang('Tracking Number')</th>
                                    <th>@lang('Creations Date')</th>
                                    <th>@lang('Pre Status')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($courierDeliveys as $courierInfo)
                                <tr>
                                    <tr>
                                    <td data-label="@lang('Sender Branch')">
                                    <!-- <span>{{__($courierInfo->senderBranch->name)}}</span><br> -->
                                    {{__($courierInfo->senderStaff->fullname)}}
                                </td>

                                <td data-label="@lang('Receiver Branch - Staff')">
                                    <span>
                                        @if($courierInfo->receiver_branch_id)
                                            {{__($courierInfo->receiverBranch->name)}}
                                        @else
                                            @lang('N/A')
                                        @endif
                                    </span>
                                    <!-- <br>
                                    @if($courierInfo->receiver_staff_id)
                                        {{__($courierInfo->receiverStaff->fullname)}}
                                    @else
                                        <span>@lang('N/A')</span>
                                    @endif -->
                                </td>

                                <td data-label="@lang('Amount Order Number')">
                                    <span class="font-weight-bold">
                                        <!-- {{getAmount($courierInfo->paymentInfo->amount)}} {{ $general->cur_text }}</span><br> -->
                                    <span>{{__($courierInfo->code) }}</span>
                                </td>

                                     <td data-label="@lang('Creations Date')">
                                        {{showDateTime($courierInfo->created_at, 'd M Y')}}<br>{{ diffForHumans($courierInfo->created_at)}}
                                    </td>

                                    <td data-label="@lang('Payment Status')">
                                        @if($courierInfo->paymentInfo->status == 1)
                                            <span class="badge badge--success">@lang('InTransit')</span>
                                        @elseif($courierInfo->paymentInfo->status == 0)
                                            <span class="badge badge--danger">@lang('Stork Station')</span>
                                        @endif
                                    </td>


                                    <td data-label="@lang('Status')">
                                        @if($courierInfo->status == 0)
                                            <span class="badge badge--primary">@lang('Received')</span>
                                        @elseif($courierInfo->status == 1)
                                            <span class="badge badge--success">@lang('Delivered')</span>
                                        @endif
                                    </td>
                                
                                    <td data-label="@lang('Action')">
                                        @if($courierInfo->status  == 0 && $courierInfo->paymentInfo->status == 1)
                                            <a href="javascript:void(0)" title="" class="icon-btn btn--info ml-1 delivery" data-code="{{$courierInfo->code}}">@lang('Delivered')</a>
                                        @endif
                                        @if($courierInfo->status  == 0 && $courierInfo->paymentInfo->status == 0)
                                            <a href="javascript:void(0)" title="" class="icon-btn btn--success ml-1 payment" data-code="{{$courierInfo->code}}">@lang('InTransit')</a>
                                        @endif
                                       <a href="{{route('staff.courier.invoice', encrypt($courierInfo->id))}}" class="icon-btn bg--10 ml-1">@lang('Invoice')</a>
                                       <a href="{{route('staff.courier.details', encrypt($courierInfo->id))}}" class="icon-btn btn--priamry ml-1">@lang('Details')</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($courierDeliveys) }}
                </div>
            </div>
        </div>
    </div>



<div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Transit Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            
            <form action="{{route('staff.courier.payment')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Are you sure that courier is intransit?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="deliveryBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Delivery Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            
            <form action="{{route('staff.courier.delivery')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Are you sure to delivered this courier?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection



@push('script')
<script>
    'use strict';
    $('.payment').on('click', function () {
        var modal = $('#paymentBy');
        modal.find('input[name=code]').val($(this).data('code'))
        modal.modal('show');
    });

    $('.delivery').on('click', function () {
        var modal = $('#deliveryBy');
        modal.find('input[name=code]').val($(this).data('code'))
        modal.modal('show');
    });
</script>
@endpush