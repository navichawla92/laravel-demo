<table class="table">
	<thead>
		<th> {{trans('label.patient_name')}} </th>
		<th data-toggle="tooltip" data-placement="top" title="{{trans('label.referral_number')}}">{{trans('label.ref_no')}}</th>
		<th data-toggle="tooltip" data-placement="top" title="{{trans('label.registration_number')}}"> {{trans('label.reg_no')}} </th>
		<th data-toggle="tooltip" data-placement="top" title="{{trans('label.registration_date')}}">{{trans('label.reg_date')}} </th>
		<th>{{trans('label.gender')}}</th>
		<th>{{trans('label.age')}}</th>
		<th>{{trans('label.list_phone')}}</th>
		<th data-toggle="tooltip" data-placement="top" title="{{trans('label.assesment_status')}}">{{trans('label.assesment_status')}} </th>
		<th>Action</th>
	</thead>
	<tbody>
		@if(count($patients))
		<?php  $color_array = ['name-green','name-voilet','name-red','name-light',]; $i = 0;?>
		@foreach($patients as $patient)
		<tr>
			<?php
			$patient->calc($patient->random_key);
			$name = '';
      		$name .= $patient->first_name ? ucfirst($patient->first_name) : '-';
      		$name .= ' ';
      		$name .= $patient->last_name ? ucfirst($patient->last_name) : '-';
			?>
			<td title="{{ $name }}" ><a href="{{ route('registration_chw_assessment', encrypt($patient->id)) }}"><span class="name-circle <?php echo "status_color_".$patient->chw_case_status; ?>">{{ $patient->first_name ? substr($patient->first_name,0,1) : "-"}}{{ $patient->last_name ? substr($patient->last_name,0,1) : ""}}</span>{{ $name }}</a></td>
			<td>{{ $patient->case_number }}</td>
			<td>{{ $patient->registration_number ? $patient->registration_number : "-" }}</td>
			<td>{{ $patient->registered_at }}</td>
			<td>{{ $patient->gender }}</td>
			<td>
			<?php
				$final_age = get_dob_in_years($patient->dob);
				echo $final_age;
			?>
			</td>
			<td>{{ $patient->phone ? $patient->phone : "-"}}</td>
			<td>{!! $patient->chw_case_status_badge !!}</td>
			<td>
				<div class="dropdown more-btn">
					<button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span>...</span>
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
						<?php
						if($patient->casestatusvalue == 3){
							?>
							<a href="#" class="dropdown-item"><i class="far fa-eye"></i>View</a> 
							<a href="#" class="dropdown-item"><i class="fas fa-sync-alt"></i>Restore</a>
							<?php	
						}
						else{

							?>
					
							<a href="{{ route('registration_chw_assessment', encrypt($patient->id)) }}"  class="dropdown-item"><img src="{{ asset('images/edit.png') }}" alt=""/> {{trans('label.assess')}} </a> 
							
							<a href="{{ route('registration_patient_notes', [Auth::user()->roles->pluck('name')[0],encrypt($patient->id)]) }}" class="dropdown-item"><img src="{{ asset('images/comment.png') }}" alt=""/> {{trans('label.notes')}} </a> 
							<a href="{{ route('registration_patient_documents', [Auth::user()->roles->pluck('name')[0],encrypt($patient->id)]) }}" class="dropdown-item"><img src="{{ asset('images/file.png') }}" alt="">{{trans('label.documents')}} </a>
							
							<?php
						}
						if($i <= 3) $i++; else $i = 0;
						?>
					</div>
				</div>			
			</td>
		</tr>
		@endforeach
		@else
		<tr><td colspan="9">No record found</td></tr>
		@endif
	</tbody>
</table>
<?php echo $patients->render(); ?>

