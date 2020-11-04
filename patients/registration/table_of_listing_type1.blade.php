<div class="table-responsive care-table listing_of_selected_type">
	<table class="table">
	   <thead>
	      <tr>
	          <th>{{ trans('label.serial_number_short_form') }}</th>
	          <th> {{ trans('label.organization') }}</th>
              <th> {{ trans('label.doctor') }}</th>
              <th> {{ trans('label.speciality') }} </th>
              <th> {{ trans('label.list_phone') }} </th>
              <th> {{ trans('label.action') }}</th>
	      </tr>
	   </thead>
	   <tbody>
		@if(count($records))
			<?php  $index=($records->perPage() * ($records->currentPage()- 1))+1; ?>
			@foreach($records as $record)
				<tr>
					<td>{{ $index }}</td>
					<td>{{ $record->org_name ? $record->org_name:"-" }}</td>
					<td>{{ $record->name ? $record->name:"-" }}</td>
					<td>{{ $record->speciality ? $record->speciality:"-" }}</td>
					<td>{{ $record->phone_number ? $record->phone_number:"-" }}</td>
					<td>
					 @if($record->type == 'pcp_informations')
                      <a class="assignment_action_btn" data-id="{{ $record->id }}" data-type="pcp_informations" data-type_id="pcp_id" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ trans('label.assign') }}"
                      >
                      @else
                      <a class="assignment_action_btn"  data-id="{{ $record->id }}" data-type="specialities" data-type_id="specialist_id" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ trans('label.assign') }}"
                      >
                      @endif
                      	<img src="{{ asset('images/assign.png') }}" alt="" >
                      </a>
                      <a class="assignment_view_btn" data-type="#view-details1" href="#"
	                          data-modal_heading="PCP Details" 
	                          data-org_name="{{ $record->org_name ? $record->org_name:"-" }}" 
	                          data-doc_name="{{ $record->name ? $record->name:"-" }}" 
	                          data-speciality="{{ $record->speciality ? $record->speciality:"-" }}" 
	                          data-email="{{ $record->email ? $record->email:"-" }}" 
	                          data-phone="{{ $record->phone_number ? $record->phone_number:"-" }}" 
	                          data-fax="{{ $record->fax ? $record->fax:"-" }}" 
	                          data-web_address="{{ $record->web_address ? $record->web_address:"-" }}" 
	                          data-address="{{ $record->address_line1 ? $record->address_line1:"-" }}" 
	                          data-contact_title="{{ $record->contact_title ? $record->contact_title:"-" }}" 
	                          data-contact_name="{{ $record->contact_name ? $record->contact_name:"-" }}" 
	                          data-contact_email="{{ $record->contact_email ? $record->contact_email:"-" }}" 
	                          data-contact_phone="{{ $record->contact_phone ? $record->contact_phone:"-" }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ trans('label.view') }}">
	                          	<i class="fa fa-eye" ></i>
	                      </a>
	                     
					</td>
				</tr>
				<?php  $index++; ?>
			@endforeach
		@else
			<tr><td>{{ trans('label.no_record_found') }}</td></tr>
		@endif
	   </tbody>
	</table>
</div>
<?php echo $records->render(); ?>