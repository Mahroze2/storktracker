@extends('admin.layouts.app')
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
                                    <th>@lang('Receiver - Branch')</th>
                                    <th>@lang('Amount - Order Number')</th>
                                    <th>@lang('Creations Date')</th>
                                    <th>@lang('Pre Status')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($courierInfos as $courierInfo)
                                <tr>
                                    <td data-label="@lang('Sender Branch - Staff')">
                                       <span class="font-weight-bold">
                                        <!-- {{__($courierInfo->senderBranch->name)}}</span><br> -->
                                       {{__($courierInfo->senderStaff->fullname)}}
                                    </td>
                                    <td data-label="@lang('Receiver Branch - Staff')">
                                        @if($courierInfo->receiver_branch_id)
                                            <span class="font-weight-bold">{{__($courierInfo->receiverBranch->name)}}</span>
                                        @else
                                            @lang('N/A')
                                        @endif
                                        <!-- <br>
                                        @if($courierInfo->receiver_staff_id)
                                            {{__($courierInfo->receiverStaff->fullname)}}
                                        @else
                                            <span>@lang('N/A')</span>
                                        @endif -->
                                    </td>

                                    <td data-label="@lang('Amount - Order Tracking')">
                                        <span class="font-weight-bold">{{getAmount($courierInfo->paymentInfo->amount)}} {{ $general->cur_text }}</span><br>
                                        <span>{{__($courierInfo->code) }}</span>
                                    </td>

                                     <td data-label="@lang('Creations Date')">
                                        {{showDateTime($courierInfo->created_at, 'd M Y')}}<br>{{ diffForHumans($courierInfo->created_at) }}
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
                                       <a href="{{route('admin.courier.invoice', $courierInfo->id)}}" title="" class="icon-btn bg--10 ml-1">@lang('Invoice')</a>
                                       <a href="{{route('admin.courier.info.details', $courierInfo->id)}}" title="" class="icon-btn btn--priamry">@lang('Details')</a>
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
                    {{ paginateLinks($courierInfos) }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form action="{{route('admin.courier.date.search')}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush


@push('script-lib')
  <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
  <script>
    (function($){
        "use strict";
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
  </script>
@endpush
