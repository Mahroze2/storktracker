@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
@php 
    $orderTracking = getContent('order_tracking.content', true);
@endphp
     <section class="track-section pt-120 pb-120">
        <div class="container">
            <div class="section__header section__header__center">
                <span class="section__cate">
                    {{__(@$orderTracking->data_values->title)}}
                </span>
                <h3 class="section__title"> {{__(@$orderTracking->data_values->heading)}}</h3>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9 col-xl-6">
                    <form action="{{route('order.tracking')}}" method="GET" class="order-track-form mb-4 mb-md-5">
                        @csrf
                        @method("GET")
                        <div class="order-track-form-group">
                            <input type="text" name="order_number" placeholder="@lang('Enter Your Tracking Id')" value="{{@$orderNumber->code}}">
                            <button type="submit">@lang('Track Now')</button>
                        </div>
                    </form>
                </div>
            </div>

            @if($orderNumber)
                <div class="track--wrapper">
                    <div class="track__item @if($orderNumber->status == 1 || $orderNumber->status == 0) done @endif">
                        <div class="track__thumb">
                            <i class="las la-briefcase"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('Preparing')</h5><br>
                            <div class="card card-margin">
                                <div class="card-body ">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-primary">
                                                <span class="widget-49-date-day"><i class="fa fa-archive"></i></span>
                                                <span class="widget-49-date-month"></span>
                                            </div>
                                            <div class="widget-49-meeting-info">
                                                <span class="widget-49-pro-title">Preparing for Dispatch</span>
                                                <span class="widget-49-meeting-time">
                                                    @php echo $orderNumber->created_at->format('m-d-Y')  @endphp at @php echo $orderNumber->created_at->format('h:i a')@endphp</span>
                                                <span class="widget-49-meeting-time"><hr style="padding:0px;margin:0px;color:green;"></span>
                                            </div>
                                        </div>
                                        
                                            <ul class="widget-49-meeting-points text-left">
                                                <li class="widget-49-meeting-item"><span class="">Send By: </span></li>
                                                <li class="widget-49-meeting-item"><span class="ml-3"> @php echo $orderNumber->sender_name  @endphp </span></li><br>
                                                <li class="widget-49-meeting-item"><span class="">Address: </span></li>
                                                <li class="widget-49-meeting-item"><span class=""> @php echo $orderNumber->sender_address  @endphp </span></li>
                                                
                                                <!-- <li class="widget-49-meeting-item"><span>Session timeout increase to 30 minutes</span></li> -->
                                            </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--track__item @if($orderNumber->status == 1 || $orderNumber->status == 0) done @endif-->
                    @php
                    $currenttime=date("m-d-Y h:i a");
                    $myarrival=0;
                    $Arrivedate=date_create($orderNumber->created_at);
                    date_add($Arrivedate,date_interval_create_from_date_string("6 hours"));
                    $timearrived=date_format($Arrivedate,"m-d-Y h:i a");
                    if($currenttime >= $timearrived){
                    $myarrival=1;
                    }
                    @endphp
                   
                    <div class="track__item @if($myarrival == 1 ) done @endif">
                        <div class="track__thumb ">
                            <i class="las la-check-circle"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('Package Arrived')</h5><br>
                            <div class="card card-margin" @if ( $myarrival == 1) style="display:block;" @else style="display:none;"  @endif>
                                <div class="card-body ">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-primary">
                                                <span class="widget-49-date-day"><i class="fa fa-handshake"></i></span>
                                                <span class="widget-49-date-month"></span>
                                            </div>
                                            <div class="widget-49-meeting-info">
                                                <span class="widget-49-pro-title">Arrived at StorkTrack Station</span>
                                                <span class="widget-49-meeting-time" >
                                                <!-- onload="myFunction()" id="demo" -->
                                                @php 
                                                $Arrivedate=date_create($orderNumber->created_at);
                                                date_add($Arrivedate,date_interval_create_from_date_string("6 hours 20 minutes"));
                                                echo date_format($Arrivedate,"m-d-Y");
                                                @endphp at 
                                                @php 
                                                $Arrivedate=date_create($orderNumber->created_at);
                                                date_add($Arrivedate,date_interval_create_from_date_string("6 hours 20 minutes"));
                                                echo date_format($Arrivedate,"h:i a");
                                                @endphp
                                                <!--@php echo $orderNumber->created_at->format('h:i a')@endphp-->
                                                 </span>
                                                <span class="widget-49-meeting-time"><hr style="padding:0px;margin:0px;color:green;"></span>
                                            </div>
                                        </div>
                                        
                                            <!-- <ul class="widget-49-meeting-points text-left">
                                                <li class="widget-49-meeting-item"><span class="">Send By: </span></li>
                                                <li class="widget-49-meeting-item"><span class="ml-3"> @php echo $orderNumber->sender_name  @endphp store</span></li><br>
                                                <li class="widget-49-meeting-item"><span class="">Address: </span></li>
                                                <li class="widget-49-meeting-item"><span class=""> @php echo $orderNumber->sender_address  @endphp state zip code </span></li>
                                                
                                                </ul> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--@if($orderNumber->status == 1 || $orderNumber->paymentInfo->status == 1) done @endif-->
                    @php
                    $currentdate=date("m-d-Y");
                    $Transitdate=date_create($orderNumber->created_at);
                    date_add($Transitdate,date_interval_create_from_date_string("32 hours 15 minutes"));
                    $dateTransit=date_format($Transitdate,"m-d-Y");
                    @endphp
                    <div class="track__item @if($currentdate >= $dateTransit ) done @endif">
                        <div class="track__thumb">
                            <i class="las la-truck-pickup"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('InTransit')</h5><br>
                            <div class="card card-margin" @if ( $currentdate >= $dateTransit ) style="display:block;" @else style="display:none;"  @endif>
                                <div class="card-body ">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-primary">
                                                <span class="widget-49-date-day"><i class="fa fa-truck"></i></span>
                                                <span class="widget-49-date-month"></span>
                                            </div>
                                            <div class="widget-49-meeting-info">
                                                <span class="widget-49-pro-title">Dispatch to the Customer's Address</span>
                                                <span class="widget-49-meeting-time">
                                                @php 
                                                    $Transitdate=date_create($orderNumber->created_at);
                                                    date_add($Transitdate,date_interval_create_from_date_string("32 hours 15 minutes"));
                                                    echo date_format($Transitdate,"m-d-Y");
                                                @endphp at 
                                                 @php 
                                                    $Transitdate=date_create($orderNumber->created_at);
                                                    date_add($Transitdate,date_interval_create_from_date_string("32 hours 15 minutes"));
                                                    echo date_format($Transitdate,"h:i a");
                                                @endphp
                                               
                                                <span class="widget-49-meeting-time"><hr style="padding:0px;margin:0px;color:green;"></span>
                                            </div>
                                        </div>
                                        
                                            <!-- <ul class="widget-49-meeting-points text-left">
                                                <li class="widget-49-meeting-item"><span class="">Send By: </span></li>
                                                <li class="widget-49-meeting-item"><span class="ml-3"> @php echo $orderNumber->sender_name  @endphp store</span></li><br>
                                                <li class="widget-49-meeting-item"><span class="">Address: </span></li>
                                                <li class="widget-49-meeting-item"><span class=""> @php echo $orderNumber->sender_address  @endphp state zip code </span></li>
                                                
                                                </ul> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    $currentdate=date("m-d-Y");
                    $edeliverdate=date_create($orderNumber->created_at);
                    date_add($edeliverdate,date_interval_create_from_date_string("5 days"));
                    $datedeliverd=date_format($edeliverdate,"m-d-Y");
                    @endphp
                    
                    <div class="track__item  @if($currentdate >= $datedeliverd ) done @endif">
                        <div class="track__thumb">
                            <i class="lar la-building"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">@lang('Delivered')</h5><br>
                            <div class="card card-margin" @if($currentdate >= $datedeliverd ) style="display:none;" @else style="display:block;" @endif">
                                <div class="card-body ">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-primary">
                                                <span class="widget-49-date-day"><i class="fa fa-map-marker"></i></span>
                                                <span class="widget-49-date-month"></span>
                                            </div>
                                            <div class="widget-49-meeting-info">
                                                <span class="widget-49-pro-title">Estimated Delivery</span>
                                                <span class="widget-49-meeting-time">
                                                @php 
                                                    $edeliverdate=date_create($orderNumber->created_at);
                                                    date_add($edeliverdate,date_interval_create_from_date_string("5 days"));
                                                    $datedeliverd=date_format($edeliverdate,"m-d-Y");
                                                    echo $datedeliverd;
                                                @endphp at 
                                                @php 
                                                    $edeliverdate=date_create($orderNumber->created_at);
                                                    date_add($edeliverdate,date_interval_create_from_date_string("5 days 5 minutes"));
                                                    echo date_format($edeliverdate,"h:i a");
                                                @endphp
                                                </span>
                                                <span class="widget-49-meeting-time"><hr style="padding:0px;margin:0px;color:green;"></span>
                                            </div>
                                        </div>
                                        
                                            <ul class="widget-49-meeting-points text-left">
                                                <li class="widget-49-meeting-item"><span class="">Receiver: </span></li>
                                                <li class="widget-49-meeting-item"><span class="ml-3"> @php echo $orderNumber->receiver_name  @endphp</span></li><br>
                                                <li class="widget-49-meeting-item"><span class="">Address: </span></li>
                                                <li class="widget-49-meeting-item"><span class=""> @php echo $orderNumber->receiver_address  @endphp </span></li>
                                                
                                                <!-- <li class="widget-49-meeting-item"><span>Session timeout increase to 30 minutes</span></li> -->
                                            </ul>
                                    </div>
                                </div>
                            </div><!--cardend-->
                            <div class="card card-margin" @if($currentdate >= $datedeliverd ) style="display:block;" @else style="display:none;" @endif">
                                <div class="card-body ">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-primary">
                                                <span class="widget-49-date-day"><i class="fa fa-map-marker"></i></span>
                                                <span class="widget-49-date-month"></span>
                                            </div>
                                            <div class="widget-49-meeting-info">
                                                <span class="widget-49-pro-title">Deliverd at Door Step</span>
                                                <span class="widget-49-meeting-time">
                                               @php 
                                                    $edeliverdate=date_create($orderNumber->created_at);
                                                    date_add($edeliverdate,date_interval_create_from_date_string("5 days"));
                                                    $datedeliverd=date_format($edeliverdate,"m-d-Y");
                                                    echo $datedeliverd;
                                                @endphp at 
                                                @php 
                                                    $edeliverdate=date_create($orderNumber->created_at);
                                                    date_add($edeliverdate,date_interval_create_from_date_string("5 days 5 minutes"));
                                                    echo date_format($edeliverdate,"h:i a");
                                                @endphp
                                                
                                                </span>
                                                <span class="widget-49-meeting-time"><hr style="padding:0px;margin:0px;color:green;"></span>
                                            </div>
                                        </div>
                                        
                                            <ul class="widget-49-meeting-points text-left">
                                                <li class="widget-49-meeting-item"><span class="">Receiver: </span></li>
                                                <li class="widget-49-meeting-item"><span class="ml-3"> @php echo $orderNumber->receiver_name  @endphp</span></li><br>
                                                <li class="widget-49-meeting-item"><span class="">Address: </span></li>
                                                <li class="widget-49-meeting-item"><span class=""> @php echo $orderNumber->receiver_address  @endphp </span></li><br>
                                                <li class="widget-49-meeting-item"><span class="">Signature not required <br> <div style="margin-left:6px;">Left at front door</div></span></li>
                                                <li class="widget-49-meeting-item"><span class="" style="line-height:0px;"> </span></li>
                                                <li class="widget-49-meeting-item"><span class="">  </span></li>
                                                
                                                <!-- <li class="widget-49-meeting-item"><span>Session timeout increase to 30 minutes</span></li> -->
                                            </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!-- <div class="track__item @if($orderNumber->status == 1 || $orderNumber->paymentInfo->status == 1 || $orderNumber->paymentInfo->status == 0) done @endif">
                        <div class="track__content">
                            <table>
                                <tr>
                                    <th class="track__title"> @lang('Sender Name')</th>
                                    <th class="track__title"> @lang('Sender Address')</th>
                                    <th class="track__title"> @lang('Reciever Name')</th>
                                    <th class="track__title"> @lang('Reciever Address')</th>
                                    <th class="track__title"> @lang('Created Date')</th>
                                    <th class="track__title"> @lang('Estimated Delivery Date')</th>
                                </tr>
                                format('Y-m-d')
                                <tr>
                                    <td>@php echo $orderNumber->sender_name  @endphp</td>
                                    <td>@php echo $orderNumber->sender_address  @endphp</td>
                                    <td>@php echo $orderNumber->receiver_name  @endphp</td>
                                    <td>@php echo $orderNumber->receiver_address  @endphp</td>
                                    <td>@php echo $orderNumber->created_at  @endphp</td>
                                    <td>@php echo $orderNumber->updated_at  @endphp</td>
                                </tr>
                            </table>
                        </div>
                    </div>  -->
                </div>
            @endif
        </div>  
    </section>
@endsection
