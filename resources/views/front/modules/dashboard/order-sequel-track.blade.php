@extends('front.layouts.app')
<link href="{{ asset('assets/front/8thniqjewells/assets/css/login.css') }}" rel="stylesheet">

@section('content')  
<form action="{{route('front-orders.sequel.track.order')}}" method="post" autocomplete="off" id="loginForm">   
@csrf 
<div class="login-section">
        <div class="container">
            <div class="login-box">
                <div class="text-center w-100 mb-5">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/logo/logo-black.png') }}" width="150" />
                </div>
                <div class="white-box">
                    <h2 class="mb-4">TRACK ORDER</h2>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation" style="width:100%">
                            <button class="nav-link active roletab" id="home-tab" data-roleId='4' data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Sequel</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="form-group">
                                <label>Tracking Number</label>
                                <input type="text" name="trackingNumber" id="trackingNumber" class="form-control login" placeholder="Enter your tracking number" required/>
                                 @if ($errors->has('trackingNumber'))
                                <div class=" invalid-feedback">
                                    {{ $errors->first('trackingNumber') }}
                                </div>
                                @endif
                            </div>
                            
                            <span class="form-group login-error" style="color:red;fornt-size:16px"> </span>
                            <span class="form-group login-success" style="color:green;fornt-size:16px"> </span>
                            <div class="form-group">
                                <button type="submit" href="javascript:void('0')" class="login-button" id="trackOrderBtn">
                                    Track Order <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shape text-center">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" class="shape-bottom">
                </div>
            </div>

            <!--   Tracking data -->
            <table id="shipment_list" class="table table-striped datatable dataTable no-footer" aria-describedby="shipment_list_info" style="width: 1684px;">
                <thead>
                        <tr>
                            <th class="sorting" tabindex="0" aria-controls="shipment_list" rowspan="1" colspan="1" aria-label="Docket: activate to sort column ascending" style="width: 131.2px;">Docket</th>
                            <th class="sorting" tabindex="0" aria-controls="shipment_list" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending" style="width: 141.2px;">Remark</th>
                            <th class="sorting" tabindex="0" aria-controls="shipment_list" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 123.2px;">Status</th>
                            <th class="sorting" tabindex="0" aria-controls="shipment_list" rowspan="1" colspan="1" aria-label="Created By: activate to sort column ascending" style="width: 187.2px;">Estimated Delivery Date</th>
                        </tr>
                </thead>
                <tbody>
                    <tr class="odd">
                        <td valign="top" colspan="9" class="dataTables_empty">
                            @if($orderTrackResult['status']== 'error')
                            <div class="no_data_image text-center">
                                <img width="300px" src="https://sequel247.com//assets/images/delivered.svg">
                                <div> Docket Not Found. </div>
                            </div>
                            @else
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="shipment_list" rowspan="1" colspan="1" aria-label="Docket: activate to sort column ascending" style="width: 131.2px;">{{ $orderTrackResult['data']['docket_no'] }}</th>
                                <th class="sorting" tabindex="0" aria-controls="shipment_list" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending" style="width: 141.2px;"><?php 
                                    foreach($orderTrackResult['data']['tracking'] as $tracking) {
                                        echo $tracking['description'] . ' -- ' .  $tracking['location'] . ' -- ' .  $tracking['date_time'] ."</br></br>";
                                    }
                                ?></th>
                                <th class="sorting" tabindex="0" aria-controls="shipment_list" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 123.2px;">{{ $orderTrackResult['data']['shipment_status'] }}</th>
                                <th class="sorting" tabindex="0" aria-controls="shipment_list" rowspan="1" colspan="1" aria-label="Created By: activate to sort column ascending" style="width: 187.2px;">{{ $orderTrackResult['data']['estimated_delivery'] }}</th>
                            </tr>
                            @endif
                        </td>`
                    </tr>
                </tbody>
            </table>
            <!--   Tracking data -->
        </div>
    </div>
</form>
@endsection
