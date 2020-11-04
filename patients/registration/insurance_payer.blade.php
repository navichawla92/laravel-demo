@include('patients.common.profile_status_bar')
<?php
if($patient_insurance_primary){
    $patient_insurance_primary->calc($patient->random_key);
}
if($patient_insurance_secondary){
    $patient_insurance_secondary->calc($patient->random_key);
}
$patient->calc($patient->random_key);

?>
  {!! Form::model($patient,['id' => 'patient-insurance-tab-form']) !!}
  {!! Form::hidden('patient_id', encrypt($patient->id)) !!}
  {!! Form::hidden('step_number', '3') !!}
  <div class="personliving">
    <div class="row">
      <div class="col-md-3">
        <span class="headingpage insure-head">{{ trans('label.insurance_information') }}</span>
        <div class="checkdiv insurancecheckrequired"> 
          {!! Form::checkbox('is_insured',null, null,['class'=>'customcheck is_insured','old-data'=>($patient->is_insured)? 'jcf-checked':'jcf-unchecked']) !!}
          <label>{{ trans('label.not_requried') }}</label>
        </div>
      </div>
    </div>
     <div class="row insure-tabs" id="Insurance_div">
        <div class="col-sm-3 insure-side">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link insurance_optional_section {{ ($patient->is_insured)?'disabled-nav-link':'active' }}" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">{{ trans('label.primary_insurance') }}</a>
              <a class="nav-link insurance_optional_section {{ ($patient->is_insured)?'disabled-nav-link':'' }}" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ trans('label.secondary_insurance') }}</a>
              <a class="nav-link {{ ($patient->is_insured)?'active':'' }}" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{ trans('label.contracted_payer') }}</a>
            </div>
         </div>
         <div class="col-sm-9">
              
    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade {{ ($patient->is_insured)?'':'show active' }} insurance_optional_section" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
         <div class="safety-box">
            <div class="row">
              <div class="col-md-6">
                <div class="textfieldglobal">
                  <label class="labelfieldsname">{{ trans('label.name_of_insurance') }}</label>
                  <select name="insurances[0][insurance_id]" class="insurances customselect" id='insurancePrimary'>
                    <option value=""> {{ trans('label.please_select') }}</option>
                    @foreach($insurances as $key=>$insurance)
                     <option value="{{ $insurance->id }}" data-insurance_address_line1="{{ $insurance->address_line1 }}" data-address_line2="{{ $insurance->address_line2 }}" data-insurance_code="{{ $insurance->code }}" data-insurance_city="{{ $insurance->city }}" data-insurance_zip="{{ $insurance->zip }}" data-insurance_state="{{ $insurance->state_id }}" data-insurance_state_name="{{ $insurance->state_name }}" data-insurance_contact_name="{{ $insurance->contact_name }}" data-insurance_contact_number="{{ $insurance->contact_phone }}" data-insurance_contact_email="{{ $insurance->contact_email }}" data-insurance_contact_title="{{ $insurance->contact_title }}" data-insurance_phone_number="{{ $insurance->phone_number }}" data-insurance_web_address="{{ $insurance->web_address }}" data-insurance_fax="{{ $insurance->fax }}"
                      @if ($patient_insurance_primary &&  $insurance->id === $patient_insurance_primary->insurance_id) selected @endif
                      >{{$insurance->org_name}} </option>
                    @endforeach
                  </select>
                  <input type="hidden" name="insurances[0][type]" value="primary">
                  <input type="hidden" name="insurances[0][primary_id]" value="{{$patient_insurance_primary ? $patient_insurance_primary->id : ""}}">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.code') }}</label>
                  <input placeholder="" type="text" class="insurance_code" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.address_line_1') }}</label>
                  <input placeholder="" type="text" class="insurance_address_line1" disabled="">
                </div>
                <div class="textfieldglobal readonly_field readonly_field">
                  <label class="labelfieldsname">{{ trans('label.address_line_2') }}</label>
                  <input placeholder="" type="text" class="address_line2" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.city') }}</label>
                  <input placeholder="" type="text" class="insurance_city" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.state') }}</label>
                  <input placeholder="" type="text" class="insurance_state_name" disabled="">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.zip_code') }}</label>
                  <input placeholder="" type="text" class="insurance_zip" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.phone_number') }}</label>
                  <input placeholder="" type="text" class="insurance_phone_number" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.fax') }}</label>
                  <input placeholder="" type="text" class="insurance_fax" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.web_address') }}</label>
                  <input placeholder="" type="text" class="insurance_web_address" disabled="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_name') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_name" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_title') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_title" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_phone') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_number" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_email') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_email" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.policy') }} #</label>
                  <input placeholder="" class="do_not_empty" type="text" maxlength="100" name="insurances[0][policy]"  value="{{$patient_insurance_primary ? $patient_insurance_primary->policy : ""}}">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.group') }} #</label>
                  <input placeholder="" class="do_not_empty" type="text" maxlength="100" name="insurances[0][group]"  value="{{$patient_insurance_primary ? $patient_insurance_primary->group : ""}}">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.authorized_by') }}</label>
                  <input placeholder="" class="do_not_empty" type="text" maxlength="60" name="insurances[0][authorized_by]"  value="{{$patient_insurance_primary ? $patient_insurance_primary->authorized_by : ""}}">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.authorization') }} #</label>
                  <input placeholder="" class="do_not_empty" type="text" maxlength="100" name="insurances[0][authorization]"  value="{{$patient_insurance_primary ? $patient_insurance_primary->authorization : ""}}">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <div class="calendar33 textwidthforfull">
                    <label class="labelfieldsname">{{ trans('label.effective_date') }}</label>
                    <input placeholder="" id="primary_effective_date" class="do_not_empty effective_datePickerInsurance" type="text" name="insurances[0][effective_date]" class="effective_datePickerInsurance" value="{{$patient_insurance_primary ? $patient_insurance_primary->effective_date : ""}}" old_value="{{$patient_insurance_primary ? $patient_insurance_primary->effective_date : ""}}">
                    <span class="calendarfromto"><label for="primary_effective_date"><img src="{{ asset('images/calendaradd.png') }}" alt=""></label></span>
                    <span class="error" style="color:red"></span>
                  </div>
                </div>
                <div class="textfieldglobal readonly_field">
                  <div class="calendar33 textwidthforfull">
                    <label class="labelfieldsname">{{ trans('label.expiration_date') }}</label>
                    <input placeholder="" id="primary_expire_date" class="do_not_empty expiry_datePickerInsurance" type="text" name="insurances[0][expiration_date]" class="expiry_datePickerInsurance"  value="{{$patient_insurance_primary ? $patient_insurance_primary->expiration_date : ""}}" old_value="{{$patient_insurance_primary ? $patient_insurance_primary->expiration_date : ""}}">
                    <span class="calendarfromto"><label for="primary_expire_date"><img src="{{ asset('images/calendaradd.png') }}" alt=""></label></span> 
                    <span class="error" style="color:red"></span>
                  </div>
                </div>
              </div>
            </div>
         </div> 
      </div>
      <div class="tab-pane fade insurance_optional_section" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
        <div class="safety-box">
          <div class="row">
              <div class="col-md-6">
                <div class="textfieldglobal">
                  <label class="labelfieldsname">{{ trans('label.name_of_insurance') }}</label>
                  <select name="insurances[1][insurance_id]" class="insurances customselect" id='insuranceSecondary'>
                    <option value="">{{ trans('label.please_select') }}</option>
                      @foreach($insurances as $key=>$insurance)
                      <option value="{{$insurance->id}}" data-insurance_address_line1="{{$insurance->address_line1}}" data-address_line2="{{$insurance->address_line2}}" data-insurance_code="{{$insurance->code}}" data-insurance_city="{{$insurance->city}}" data-insurance_zip="{{$insurance->zip}}" data-insurance_state="{{$insurance->state_id}}" data-insurance_state_name="{{$insurance->state_name}}" data-insurance_contact_name="{{$insurance->contact_name}}" data-insurance_contact_number="{{$insurance->contact_phone}}" data-insurance_contact_email="{{$insurance->contact_email}}" data-insurance_contact_title="{{$insurance->contact_title}}" data-insurance_phone_number="{{$insurance->phone_number}}" data-insurance_web_address="{{$insurance->web_address}}" data-insurance_fax="{{$insurance->fax}}"
                      @if ($patient_insurance_secondary && $insurance->id === $patient_insurance_secondary->insurance_id) selected @endif
                      
                      >{{ $insurance->org_name }} </option>
                    @endforeach
                  </select> 
                  <input type="hidden" name="insurances[1][type]" value="secondary">
                  <input type="hidden" name="insurances[1][primary_id]" value="{{$patient_insurance_secondary ? $patient_insurance_secondary->id : ""}}">
                   <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.code') }}</label>
                  <input placeholder="" type="text" class="insurance_code" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.address_line_1') }}</label>
                  <input placeholder="" type="text" class="insurance_address_line1" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.address_line_2') }}</label>
                  <input placeholder="" type="text" class="address_line2" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.city') }}</label>
                  <input placeholder="" type="text" class="insurance_city" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.state') }}</label>
                  <input placeholder="" type="text" class="insurance_state_name" disabled="">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.zip_code') }}</label>
                  <input placeholder="" type="text" class="insurance_zip" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.phone_number') }}</label>
                  <input placeholder="" type="text" class="insurance_phone_number" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.fax') }}</label>
                  <input placeholder="" type="text" class="insurance_fax" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.web_address') }}</label>
                  <input placeholder="" type="text" class="insurance_web_address" disabled="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_name') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_name" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_title') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_title" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_phone') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_number" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_email') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_email" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.policy') }} #</label>
                  <input placeholder="" class="do_not_empty" type="text" maxlength="100" name="insurances[1][policy]" value="{{$patient_insurance_secondary ? $patient_insurance_secondary->policy : ""}}">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.group') }} #</label>
                  <input placeholder="" class="do_not_empty" type="text" maxlength="100" name="insurances[1][group]" value="{{$patient_insurance_secondary ? $patient_insurance_secondary->group : ""}}">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.authorized_by') }}</label>
                  <input placeholder="" class="do_not_empty" type="text" maxlength="60" name="insurances[1][authorized_by]" value="{{$patient_insurance_secondary ? $patient_insurance_secondary->authorized_by : ""}}">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.authorization') }} #</label>
                  <input placeholder="" class="do_not_empty" type="text" maxlength="100" name="insurances[1][authorization]" value="{{$patient_insurance_secondary ? $patient_insurance_secondary->authorization : ""}}">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <div class="calendar33 textwidthforfull">
                    <label class="labelfieldsname">{{ trans('label.effective_date') }}</label>
                    <input placeholder="" id="secondary_effective_date" class="do_not_empty effective_datePickerInsurance" type="text" name="insurances[1][effective_date]" class="effective_datePickerInsurance" value="{{$patient_insurance_secondary ? $patient_insurance_secondary->effective_date : ""}}" old_value="{{$patient_insurance_secondary ? $patient_insurance_secondary->effective_date : ""}}">
                    <span class="calendarfromto"><label for="secondary_effective_date"><img src="{{ asset('images/calendaradd.png') }}" alt=""></label></span> 
                    <span class="error" style="color:red"></span>
                  </div>
                </div>
                <div class="textfieldglobal readonly_field">
                  <div class="calendar33 textwidthforfull">
                    <label class="labelfieldsname">{{ trans('label.expiration_date') }}</label>
                    <input placeholder="" id="secondary_expire_date" class="do_not_empty expiry_datePickerInsurance" type="text" name="insurances[1][expiration_date]" class="expiry_datePickerInsurance" value="{{$patient_insurance_secondary ? $patient_insurance_secondary->expiration_date : ""}}" old_value="{{$patient_insurance_secondary ? $patient_insurance_secondary->expiration_date : ""}}">
                    <span class="calendarfromto"><label for="secondary_expire_date"><img src="{{ asset('images/calendaradd.png') }}" alt=""></label></span> 
                    <span class="error" style="color:red"></span>
                  </div>
                </div>
              </div>
            </div>
        
        
        </div>
        </div>
      <div class="tab-pane fade {{ ($patient->is_insured)?'show active':'' }}" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
         <div class="safety-box">
          <div class="row">
              <div class="col-md-6">
                <div class="textfieldglobal">
                  <label class="labelfieldsname">{{ trans('label.select_contract_payer') }}</label>
                  <select name="contract_payer" class="contract_payer customselect" id="contract_payer_section">
                    <option value="">{{ trans('label.please_select') }}</option>
                    @foreach($contract_payers as $key=>$insurance)
                    <option value="{{ $insurance->id }}" 
                      data-insurance_address_line1="{{ $insurance->address_line1 }}" data-address_line2="{{ $insurance->address_line2 }}" data-insurance_code="{{ $insurance->code }}" data-insurance_city="{{ $insurance->city }}" data-insurance_zip="{{ $insurance->zip }}" data-insurance_state="{{ $insurance->state_id }}" data-insurance_state_name="{{ $insurance->state_name }}" data-insurance_contact_name="{{ $insurance->contact_name }}" data-insurance_contact_number="{{ $insurance->contact_phone }}" data-insurance_contact_email="{{ $insurance->contact_email }}" data-insurance_email="{{ $insurance->email }}" data-insurance_contact_fax="{{ $insurance->contact_fax }}" data-insurance_contact_title="{{ $insurance->contact_title }}" data-insurance_phone_number="{{ $insurance->phone_number }}" data-insurance_web_address="{{ $insurance->web_address }}" data-insurance_fax="{{ $insurance->fax }}" data-insurance_organization="{{ $insurance->org_name }}" data-insurance_start_date="{{ $insurance->effective_start_date }}" data-insurance_end_date="{{ $insurance->effective_end_date }}" data-insurance_confirmation="{{ $insurance->auth_confirmation }}"
                      @if ($insurance->id === $patient->contract_payer) selected @endif >{{ $insurance->name }} </option>
                    @endforeach
                  </select>
                   <span class="error" id="contract_payer_error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.org_name') }}</label>
                  <input placeholder="" type="text" class="insurance_organization" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.code') }}</label>
                  <input placeholder="" type="text" class="insurance_code" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.address_line_1') }}</label>
                  <input placeholder="" type="text" class="insurance_address_line1" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.address_line_2') }}</label>
                  <input placeholder="" type="text" class="address_line2" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.city') }}</label>
                  <input placeholder="" type="text" class="insurance_city" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.state') }}</label>
                  <input placeholder="" type="text" class="insurance_state_name" disabled="">
                  <span class="error" style="color:red"></span>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.zip_code') }}</label>
                  <input placeholder="" type="text" class="insurance_zip" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <div class="calendar33 textwidthforfull">
                    <label class="labelfieldsname">{{ trans('label.effective_start_date') }}</label>
                    <input placeholder="" type="text" class="datePickerInsurance insurance_start_date" disabled="">
                    <span class="calendarfromto"><img src="{{ asset('images/calendaradd.png') }}" alt=""></span> </div>
                </div>
                <div class="textfieldglobal readonly_field">
                  <div class="calendar33 textwidthforfull">
                    <label class="labelfieldsname">{{ trans('label.effective_end_date') }}</label>
                    <input placeholder="" type="text" class="datePickerInsurance insurance_end_date" disabled="">
                    <span class="calendarfromto"><img src="{{ asset('images/calendaradd.png') }}" alt=""></span> </div>
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.authorization_code') }} *</label>
                  <input placeholder="" maxlength="100" type="text" value="{{ $patient->authorization_code }}" name="authorization_code">
                  <span class="error" style="color:red"></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.confirmation') }} #</label>
                  <input placeholder="" type="text" class="insurance_confirmation" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.phone_number') }}</label>
                  <input placeholder="" type="text" class="insurance_phone_number" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.email_address') }}</label>
                  <input placeholder="" type="text" class="insurance_email" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.fax') }}</label>
                  <input placeholder="" type="text" class="insurance_fax" disabled="">
                </div>
                 <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.web_address') }}</label>
                  <input placeholder="" type="text" class="insurance_web_address" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_name') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_name" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_title') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_title" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_phone') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_number" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_email') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_email" disabled="">
                </div>
                <div class="textfieldglobal readonly_field">
                  <label class="labelfieldsname">{{ trans('label.contact_person_fax') }}</label>
                  <input placeholder="" type="text" class="insurance_contact_fax" disabled="">
                </div>
               
              </div>
            </div>
        
         </div>
     </div>
         <div class="buttonsbottom">
            <button type="button" class="next" onClick="javascript:saveform('saveandnext','#patient-insurance-tab-form','3')">{{trans('label.save_and_next')}}</button>
            <button type="button" class="next" onClick="javascript:saveform('saveandclose','#patient-insurance-tab-form','3')">{{trans('label.save_and_close')}}</button>
            <a href="#" class="close close close_form">{{ trans('label.cancel') }}</a> 
        </div>
    </div>  
         </div>
     </div> 
  </div>

 {!! Form::close() !!}
