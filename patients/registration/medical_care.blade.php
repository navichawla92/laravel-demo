@include('patients.common.profile_status_bar')
<div class="patient-detail medical_care_content">
  {!! Form::model($patient,['id' => 'medical-care-tab-form']) !!}
  {!! Form::hidden('patient_id', encrypt($patient->id)) !!}
  {!! Form::hidden('step_number', '2') !!}
 <div class="care-box">
    <div class="care-section">
      @if(session()->has('message.pcp-level'))
        <div class="alert alert-{{ session('message.pcp-level') }} alert-dismissible"> 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {!! session('message.content') !!}
        </div>
      @endif
       <h3>
		   <span class="med-head">{{ trans('label.pcpi') }}</span>

           
          <div class="checkdiv not-req"> 
            {!! Form::checkbox('pcp_not_required', null, (($patient->pcp_not_required == 1) ? true : false), ['class' => 'customcheck not_required_checkbox', 'data-section_class' => 'pcp_section', 'old-data'=>($patient->pcp_not_required == 1) ? 'jcf-checked':'jcf-unchecked']) !!}
            <label>{{ trans('label.none') }} </label>
			  
          </div>
		   <a id="pcp_add_new_btn" href="javascript:getRespectiveListing('pcp_informations', 'listing_of_selected_type1', 'Choose PCP', '','Add PCP')" {!! ($patient->pcp_id || $patient->pcp_not_required == 1)?"style='display:none;'":"" !!}><i class="fa fa-plus"></i> {{ trans('label.add_new') }}</a>

       </h3>
       <span class="error" id="pcp_not_required" style="color:red"></span>
       <div class="table-responsive care-table  primary_table pcp_section {{ ($patient->pcp_not_required == 1) ? 'disable-not-section' : '' }}">
          <table class="table ">
             <thead>
                <tr>
                   <th> {{ trans('label.organization') }}</th>
                   <th> {{ trans('label.doctor') }}</th>
                   <th> {{ trans('label.speciality') }} </th>
                   <th> {{ trans('label.list_phone') }} </th>
                   <th> {{ trans('label.action') }}</th>
                </tr>
             </thead>
             <tbody>
                @if($patient->pcp_id)
                    <tr>
                       <td>{{ $patient->pcp_info->org_name ? $patient->pcp_info->org_name:"-" }}</td>
                       <td>{{ $patient->pcp_info->name ? $patient->pcp_info->name:"-"  }}</td>
                       <td>{{ $patient->pcp_info->speciality ? $patient->pcp_info->speciality:"-" }}</td>
                       <td>{{ $patient->pcp_info->phone_number ? $patient->pcp_info->phone_number:"-" }}</td>
                       <td>
                          <div class="dropdown more-btn dropup">
                             <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span>...</span>
                             </button>
                             <div class="dropdown-menu " aria-labelledby="dropdownMenu2">
                                <a onClick="viewRespectiveType(this, '#view-details1')" href="#"
                                  data-modal_heading="PCP Details" 
                                  data-org_name="{{ $patient->pcp_info->org_name ? $patient->pcp_info->org_name:"-" }}" 
                                  data-doc_name="{{ $patient->pcp_info->name ? $patient->pcp_info->name:"-" }}" 
                                  data-speciality="{{ $patient->pcp_info->speciality ? $patient->pcp_info->speciality:"-" }}" 
                                  data-email="{{ $patient->pcp_info->email ? $patient->pcp_info->email:"-" }}" 
                                  data-phone="{{ $patient->pcp_info->phone_number ? $patient->pcp_info->phone_number:"-" }}" 
                                  data-fax="{{ $patient->pcp_info->fax ? $patient->pcp_info->fax:"-" }}" 
                                  data-web_address="{{ $patient->pcp_info->web_address ? $patient->pcp_info->web_address:"-" }}" 
                                  data-address="{{ $patient->pcp_info->address_line1 ? $patient->pcp_info->address_line1:"-" }}" 
                                  data-contact_title="{{ $patient->pcp_info->contact_title ? $patient->pcp_info->contact_title:"-" }}" 
                                  data-contact_name="{{ $patient->pcp_info->contact_name ? $patient->pcp_info->contact_name:"-" }}" 
                                  data-contact_email="{{ $patient->pcp_info->contact_email ? $patient->pcp_info->contact_email:"-" }}" 
                                  data-contact_phone="{{ $patient->pcp_info->contact_phone ? $patient->pcp_info->contact_phone:"-" }}" 
                                  class="dropdown-item"><i class="fa fa-eye"></i> {{ trans('label.view') }}
                                </a>
                                <a onClick="removeItem('pcp_informations', 'pcp_id', {{ $patient->pcp_info->id }})" class="dropdown-item"><i class="fa fa-trash-alt"></i> {{ trans('label.delete') }}</a>
                             </div>
                          </div>
                       </td>
                    </tr>
                @else
                    <tr class="care-nodata-row">
                        <td colspan="5">
                        <h6 class="care-nodata">{{ trans('label.no_data_added_yet') }}</h6>
                    </tr>
                @endif
             </tbody>
          </table>
       </div>
    </div>
    <div class="care-section">
      @if(session()->has('message.speciality-level'))
        <div class="alert alert-{{ session('message.speciality-level') }} alert-dismissible"> 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {!! session('message.content') !!}
        </div>
      @endif
		<h3> <span class="med-head">{{ trans('label.specialist_information') }}</span>
        <a href="javascript:getRespectiveListing('specialities', 'listing_of_selected_type1', 'Choose Specialist', '','Add Specialist')" {!! ($patient->specialist_id && count($patient->specialist_id)>=5)?"style='display:none;'":"" !!}><i class="fa fa-plus"></i> {{ trans('label.add_new') }}</a>

       </h3>
       <div class="table-responsive care-table primary_table">
          <table class="table">
             <thead>
                <tr>
                   <th> {{ trans('label.organization') }}</th>
                   <th> {{ trans('label.doctor') }}</th>
                   <th> {{ trans('label.speciality') }} </th>
                   <th> {{ trans('label.list_phone') }} </th>
                   <th> {{ trans('label.action') }}</th>
                </tr>
             </thead>
             <tbody>
                @if($patient->specialist_id)
                  @foreach($patient->specialist_id as $specialist)
                    <tr>
                       <td>{{ $patient->speciality_info($specialist)->org_name ? $patient->speciality_info($specialist)->org_name:"-" }}</td>
                       <td>{{ $patient->speciality_info($specialist)->name ? $patient->speciality_info($specialist)->name:"-"  }}</td>
                       <td>{{ $patient->speciality_info($specialist)->speciality ? $patient->speciality_info($specialist)->speciality:"-" }}</td>
                       <td>{{ $patient->speciality_info($specialist)->phone_number ? $patient->speciality_info($specialist)->phone_number:"-" }}</td>
                       <td>
                          <div class="dropdown more-btn dropup">
                             <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span>...</span>
                             </button>
                             <div class="dropdown-menu " aria-labelledby="dropdownMenu2">
                                <a onClick="viewRespectiveType(this, '#view-details1')" href="#"
                                  data-modal_heading="Specialist Details" 
                                  data-org_name="{{ $patient->speciality_info($specialist)->org_name ? $patient->speciality_info($specialist)->org_name:"-" }}" 
                                  data-doc_name="{{ $patient->speciality_info($specialist)->name ? $patient->speciality_info($specialist)->name:"-" }}" 
                                  data-speciality="{{ $patient->speciality_info($specialist)->speciality ? $patient->speciality_info($specialist)->speciality:"-" }}" 
                                  data-email="{{ $patient->speciality_info($specialist)->email ? $patient->speciality_info($specialist)->email:"-" }}" 
                                  data-phone="{{ $patient->speciality_info($specialist)->phone_number ? $patient->speciality_info($specialist)->phone_number:"-" }}" 
                                  data-fax="{{ $patient->speciality_info($specialist)->fax ? $patient->speciality_info($specialist)->fax:"-" }}" 
                                  data-web_address="{{ $patient->speciality_info($specialist)->web_address ? $patient->speciality_info($specialist)->web_address:"-" }}" 
                                  data-address="{{ $patient->speciality_info($specialist)->address_line1 ? $patient->speciality_info($specialist)->address_line1:"-" }}" 
                                  data-contact_title="{{ $patient->speciality_info($specialist)->contact_title ? $patient->speciality_info($specialist)->contact_title:"-" }}" 
                                  data-contact_name="{{ $patient->speciality_info($specialist)->contact_name ? $patient->speciality_info($specialist)->contact_name:"-" }}" 
                                  data-contact_email="{{ $patient->speciality_info($specialist)->contact_email ? $patient->speciality_info($specialist)->contact_email:"-" }}" 
                                  data-contact_phone="{{ $patient->speciality_info($specialist)->contact_phone ? $patient->speciality_info($specialist)->contact_phone:"-" }}" 
                                  class="dropdown-item"><i class="fa fa-eye"></i> {{ trans('label.view') }}
                                </a>
                                <a onClick="removeItem('specialities', 'specialist_id', {{ $specialist }})" class="dropdown-item"><i class="fa fa-trash-alt"></i> {{ trans('label.delete') }}</a>
                             </div>
                          </div>
                       </td>
                    </tr>
                  @endforeach
                @else
                    <tr class="care-nodata-row">
                        <td colspan="6">
                        <h6 class="care-nodata">{{ trans('label.no_data_added_yet') }}</h6>
                    </tr>
                @endif
             </tbody>
          </table>
       </div>
    </div>
    <div class="care-section">
      @if(session()->has('message.rehab-level'))
        <div class="alert alert-{{ session('message.rehab-level') }} alert-dismissible"> 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {!! session('message.content') !!}
        </div>
      @endif
		<h3> <span class="med-head">{{ trans('label.rehab_information') }} </span>
         <a href="javascript:getRespectiveListing('rehabs', 'listing_of_selected_type2', 'Choose Rehab', '','Add Rehab Information')" {!! ($patient->rehab_information_id)?"style='display:none;'":"" !!}><i class="fa fa-plus"></i> {{ trans('label.add_new') }}</a>
       </h3>
       <div class="table-responsive care-table secondary_table">
          <table class="table">
             <thead>
                <tr>
                   <th>{{ trans('label.organization') }}</th>
                   <th>{{ trans('label.contact_person_name') }}</th>
                   <th> {{ trans('label.contact_person_phone') }} </th>
                   <th>{{ trans('label.action') }}</th>
                </tr>
             </thead>
             <tbody>
                @if($patient->rehab_information_id)
                    <tr>
                       <td>{{ $patient->rehab_info->org_name ? $patient->rehab_info->org_name:"-" }}</td>
                       <td>{{ $patient->rehab_info->contact_name ? $patient->rehab_info->contact_name:"-"  }}</td>
                       <td>{{ $patient->rehab_info->contact_phone  ? $patient->rehab_info->contact_phone  :"-" }}</td>
                       <td>
                          <div class="dropdown more-btn dropup">
                             <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span>...</span>
                             </button>
                             <div class="dropdown-menu " aria-labelledby="dropdownMenu2">
                                <a onClick="viewRespectiveType(this, '#view-details2')" href="#"
                                  data-modal_heading="Rehab Details" 
                                  data-modal_type="{{ $patient->rehab_info->type ? $patient->rehab_info->type:"-" }}"
                                  data-org_name="{{ $patient->rehab_info->org_name ? $patient->rehab_info->org_name:"-" }}" 
                                  data-name="{{ $patient->rehab_info->name ? $patient->rehab_info->name:"-" }}" 
                                  data-email="{{ $patient->rehab_info->email ? $patient->rehab_info->email:"-" }}" 
                                  data-phone="{{ $patient->rehab_info->phone_number ? $patient->rehab_info->phone_number:"-" }}" 
                                  data-fax="{{ $patient->rehab_info->fax ? $patient->rehab_info->fax:"-" }}" 
                                  data-web_address="{{ $patient->rehab_info->web_address ? $patient->rehab_info->web_address:"-" }}" 
                                  data-address="{{ $patient->rehab_info->address_line1 ? $patient->rehab_info->address_line1:"-" }}" 
                                  data-contact_title="{{ $patient->rehab_info->contact_title ? $patient->rehab_info->contact_title:"-" }}" 
                                  data-contact_name="{{ $patient->rehab_info->contact_name ? $patient->rehab_info->contact_name:"-" }}" 
                                  data-contact_email="{{ $patient->rehab_info->contact_email ? $patient->rehab_info->contact_email:"-" }}" 
                                  data-contact_phone="{{ $patient->rehab_info->contact_phone ? $patient->rehab_info->contact_phone:"-" }}" 
                                  class="dropdown-item"><i class="fa fa-eye"></i> {{ trans('label.view') }}
                                </a>
                                <a onClick="removeItem('rehab', 'rehab_information_id', {{ $patient->rehab_info->id }})" class="dropdown-item"><i class="fa fa-trash-alt"></i> {{ trans('label.delete') }}</a>
                             </div>
                          </div>
                       </td>
                    </tr>
                @else
                    <tr class="care-nodata-row">
                        <td colspan="6">
                        <h6 class="care-nodata">{{ trans('label.no_data_added_yet') }}</h6>
                    </tr>
                @endif
             </tbody>
          </table>
          
       </div>
    </div>
    <div class="care-section">
      @if(session()->has('message.housing_assistance-level'))
        <div class="alert alert-{{ session('message.housing_assistance-level') }} alert-dismissible"> 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {!! session('message.content') !!}
        </div>
      @endif
		<h3> <span class="med-head">{{ trans('label.housing_assistance') }}  </span>
          <a href="javascript:getRespectiveListing('housing_assistances', 'listing_of_selected_type2', 'Choose Housing Assistance', '','Add Housing Assistance')" {!! ($patient->housing_assistance_id)?"style='display:none;'":"" !!}><i class="fa fa-plus"></i> {{ trans('label.add_new') }}</a>
       </h3>
       <div class="table-responsive care-table secondary_table">
          <table class="table">
             <thead>
                <tr>
                   <th>{{ trans('label.organization') }}</th>
                   <th>{{ trans('label.counsellor_person_name') }}</th>
                   <th> {{ trans('label.counsellor_person_phone') }} </th>
                   <th>{{ trans('label.action') }}</th>
                </tr>
             </thead>
             <tbody>
                @if($patient->housing_assistance_id)
                    <tr>
                       <td>{{ $patient->housing_info->org_name ? $patient->housing_info->org_name:"-" }}</td>
                       <td>{{ $patient->housing_info->contact_name ? $patient->housing_info->contact_name:"-"  }}</td>
                       <td>{{ $patient->housing_info->contact_phone  ? $patient->housing_info->contact_phone  :"-" }}</td>
                       <td>
                          <div class="dropdown more-btn dropup">
                             <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span>...</span>
                             </button>
                             <div class="dropdown-menu " aria-labelledby="dropdownMenu2">
                                <a onClick="viewRespectiveType(this, '#view-details2')" href="#"
                                  data-modal_heading="Housing Assistance Details" 
                                  data-org_name="{{ $patient->housing_info->org_name ? $patient->housing_info->org_name:"-" }}" 
                                  data-name="{{ $patient->housing_info->name ? $patient->housing_info->name:"-" }}" 
                                  data-email="{{ $patient->housing_info->email ? $patient->housing_info->email:"-" }}" 
                                  data-phone="{{ $patient->housing_info->phone_number ? $patient->housing_info->phone_number:"-" }}" 
                                  data-fax="{{ $patient->housing_info->fax ? $patient->housing_info->fax:"-" }}" 
                                  data-web_address="{{ $patient->housing_info->web_address ? $patient->housing_info->web_address:"-" }}" 
                                  data-address="{{ $patient->housing_info->address_line1 ? $patient->housing_info->address_line1:"-" }}" 
                                  data-contact_title="{{ $patient->housing_info->contact_title ? $patient->housing_info->contact_title:"-" }}" 
                                  data-contact_name="{{ $patient->housing_info->contact_name ? $patient->housing_info->contact_name:"-" }}" 
                                  data-contact_email="{{ $patient->housing_info->contact_email ? $patient->housing_info->contact_email:"-" }}" 
                                  data-contact_phone="{{ $patient->housing_info->contact_phone ? $patient->housing_info->contact_phone:"-" }}" 
                                  class="dropdown-item"><i class="fa fa-eye"></i> {{ trans('label.view') }}
                                </a>
                                <a onClick="removeItem('housing_assistance', 'housing_assistance_id', {{ $patient->housing_info->id }})" class="dropdown-item"><i class="fa fa-trash-alt"></i> {{ trans('label.delete') }}</a>
                             </div>
                          </div>
                       </td>
                    </tr>
                @else
                    <tr class="care-nodata-row">
                        <td colspan="6">
                        <h6 class="care-nodata">{{ trans('label.no_data_added_yet') }}</h6>
                    </tr>
                @endif
             </tbody>
          </table>
       </div>
    </div>
    <div class="care-section">
      @if(session()->has('message.mental_health_assistance-level'))
        <div class="alert alert-{{ session('message.mental_health_assistance-level') }} alert-dismissible"> 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {!! session('message.content') !!}
        </div>
      @endif
		<h3> <span class="med-head">{{ trans('label.mental_health_assistance') }} </span>
          <a href="javascript:getRespectiveListing('mental_health_assistances', 'listing_of_selected_type2', 'Choose Mental Health Assistance', '','Add Mental Health Assistance')" {!! ($patient->mental_health_assistance_id)?"style='display:none;'":"" !!}><i class="fa fa-plus"></i> {{ trans('label.add_new') }}</a>
       </h3>
       <div class="table-responsive care-table secondary_table">
          <table class="table">
             <thead>
                <tr>
                   <th>{{ trans('label.organization') }}</th>
                   <th>{{ trans('label.counsellor_person_name') }}</th>
                   <th>{{ trans('label.counsellor_person_phone') }}</th>
                   <th>{{ trans('label.action') }}</th>
                </tr>
             </thead>
             <tbody>
                @if($patient->mental_health_assistance_id)
                    <tr>
                       <td>{{ $patient->mental_health_info->org_name ? $patient->mental_health_info->org_name:"-" }}</td>
                       <td>{{ $patient->mental_health_info->contact_name ? $patient->mental_health_info->contact_name:"-"  }}</td>
                       <td>{{ $patient->mental_health_info->contact_phone  ? $patient->mental_health_info->contact_phone  :"-" }}</td>
                       <td>
                          <div class="dropdown more-btn dropup">
                             <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span>...</span>
                             </button>
                             <div class="dropdown-menu " aria-labelledby="dropdownMenu2">
                                <a onClick="viewRespectiveType(this, '#view-details2')" href="#"
                                  data-modal_heading="Mental Health Assistance Details" 
                                  data-org_name="{{ $patient->mental_health_info->org_name ? $patient->mental_health_info->org_name:"-" }}" 
                                  data-name="{{ $patient->mental_health_info->name ? $patient->mental_health_info->name:"-" }}" 
                                  data-email="{{ $patient->mental_health_info->email ? $patient->mental_health_info->email:"-" }}" 
                                  data-phone="{{ $patient->mental_health_info->phone_number ? $patient->mental_health_info->phone_number:"-" }}" 
                                  data-fax="{{ $patient->mental_health_info->fax ? $patient->mental_health_info->fax:"-" }}" 
                                  data-web_address="{{ $patient->mental_health_info->web_address ? $patient->mental_health_info->web_address:"-" }}" 
                                  data-address="{{ $patient->mental_health_info->address_line1 ? $patient->mental_health_info->address_line1:"-" }}" 
                                  data-contact_title="{{ $patient->mental_health_info->contact_title ? $patient->mental_health_info->contact_title:"-" }}" 
                                  data-contact_name="{{ $patient->mental_health_info->contact_name ? $patient->mental_health_info->contact_name:"-" }}" 
                                  data-contact_email="{{ $patient->mental_health_info->contact_email ? $patient->mental_health_info->contact_email:"-" }}" 
                                  data-contact_phone="{{ $patient->mental_health_info->contact_phone ? $patient->mental_health_info->contact_phone:"-" }}" 
                                  class="dropdown-item"><i class="fa fa-eye"></i> {{ trans('label.view') }}
                                </a>
                                <a onClick="removeItem('mental_health_assistance', 'mental_health_assistance_id', {{ $patient->mental_health_info->id }})" class="dropdown-item"><i class="fa fa-trash-alt"></i> {{ trans('label.delete') }}</a>
                             </div>
                          </div>
                       </td>
                    </tr>
                @else
                    <tr class="care-nodata-row">
                        <td colspan="6">
                        <h6 class="care-nodata">{{ trans('label.no_data_added_yet') }}</h6>
                    </tr>
                @endif
             </tbody>
          </table>
       </div>
    </div>
 </div>
 <div class="buttonsbottom">
    <button type="button" class="next" onClick="javascript:saveform('saveandnext','#medical-care-tab-form','2')">{{trans('label.save_and_next')}}</button>
    <button type="button" class="next" onClick="javascript:saveform('saveandclose','#medical-care-tab-form','2')">{{trans('label.save_and_close')}}</button>
    <a href="#" class="close close close_form">{{ trans('label.cancel') }}</a> 
 </div>
 {!! Form::close() !!}
</div>
@include('chw.patients.registration.view_type1')
@include('chw.patients.registration.view_type2')