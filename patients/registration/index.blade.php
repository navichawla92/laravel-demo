@extends('layouts.app')

@section('css')
<link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
@endsection

@section('title')
 {{trans('label.patient_registration')}}
@endsection

@section('content')
<div class="leftsectionpages">
	<div class="row">
		<div class="col-md-6 col-4">
			<div class="headingpage"> {{trans('label.patient_registration')}} </div>
		</div>
	</div>

	<div class="top-search register-search">
		<form method="POST" id="patient-filter-form" action="{{ route('patient-filter') }}">	
			@csrf
			<ul>
				<li><input type="text" placeholder="{{trans('label.search_patients')}}" class="refernce_number" name="refernce_number" disabled=""></li>
				<li>
					{!! Form::select('status', [''=>'Status','0'=>'Pending','1'=>'Incomplete','2'=>'Complete'], $filter_status, ['class' => 'status_filter customselect']) !!}
				</li>
				<li class="date-box">
					<input type="text" placeholder="{{trans('label.reg_from')}}" name="from_date" class="from_date" value="{{ $filter_from_date }}" readonly>
					<img src="{{ asset('images/calendaradd.png') }}" alt="">
				</li>
				<li class="date-box">
					<input type="text" placeholder="{{trans('label.reg_to')}}" name="to_date" class="to_date" value="{{ $filter_to_date }}" readonly>
					<img src="{{ asset('images/calendaradd.png') }}" alt="">
				</li>
				<li>
					<button href="#" class="btn btn-primary basic-btn" disabled=""><b> {{trans('label.search')}} </b></button>
					<a href="#" class="reset_all_filter"><b> {{trans('label.reset')}} </b></a>
				</li>
			</ul>
		</form>
	</div>
	

	<div class="table-responsive register-table referral_table {!! count($patients) < 4 ? 'fix_table_height' : '' !!}">
		@if(session()->has('message.level'))
		    <div class="alert alert-{{ session('message.level') }} alert-dismissible"> 
		        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		    	{!! session('message.content') !!}
		    </div>
		@endif  
		@include('chw.patients.registration.registration_table')
	</div>	
	
</div>

</div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){

	applpyEllipses('register-table', 7, 'yes');
	
	$(".from_date").datepicker({
		autoclose: true,
		format: "mm-dd-yyyy",
		endDate: '-0d'
	}).on("changeDate", function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$(".to_date").datepicker("setStartDate", minDate);
		ajaxListTable();
	});
	$(".to_date").datepicker({
		autoclose: true,
		format: "mm-dd-yyyy",
		endDate: '-0d'
	})
	.on("changeDate", function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$(".from_date").datepicker("setEndDate", minDate);
		ajaxListTable();
	});
	$("select[name=status]").on("change", function() {
		ajaxListTable();
	});
	$(".role_filter").on("change", function() {
		ajaxListTable();
	});
	$(".searchstatus").on("keyup", ".refernce_number",function () {
		searchword = $(this).val();
		if ((searchword.length) >= 3) {
			ajaxListTable();
		}
	});

	$('body').on('click', '.pagination a', function(e) {
		e.preventDefault();
		var url = $(this).attr('href');  
		var data = $("#patient-filter-form").serialize();
		getPatients(url,data);
	});
	$('body').on('click', '.reset_all_filter', function(e) {
		e.preventDefault();
		$('.refernce_number').val('');
		$('.status_filter').val('');
		$('.from_date').val('');
		$('.to_date').val('');
		var url = "{{ route('chw-registrations') }}";  
		var data = '';
		getPatients(url,data);
	});
	
	fadeOutAlertMessages();
}); 
var ajaxReq = null;
function ajaxListTable(){
	if (ajaxReq != null) ajaxReq.abort();
	var formData = new FormData($("#patient-filter-form")[0]);
	ajaxReq = $.ajax({
		url:"{{ route('chw-registrations') }}",
		data:$("#patient-filter-form").serialize(),
		type:"GET",
		processData: false,
		contentType: false,
		dataType: "html",
		success:function(data){
			$(".referral_table").html(data);
			applpyEllipses('register-table', 7, 'yes');
			table_load();
		},
		error:function(data){
			$(".referral_table").html(data);
			applpyEllipses('register-table', 7, 'yes');
			table_load();
		}
	});
}

function getPatients(url,data) {
	$.ajax({
		url:url,
		type:"GET",
		data:data,
		processData: false,
		contentType: false,
		dataType: "html",
		success:function(data){
			$(".referral_table").html(data);
			applpyEllipses('register-table', 7, 'yes');
			table_load();
		},
		error:function(data){
			$(".referral_table").html(data);
			applpyEllipses('register-table', 7, 'yes');
			table_load();
		}
	});
}
</script> 
@endsection
