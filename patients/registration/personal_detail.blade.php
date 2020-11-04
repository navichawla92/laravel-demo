@include('patients.common.profile_status_bar')
<?php
  $relationshipOptions=relationship_array();
?>
{!! Form::model($patient,['id' => 'personal-detail-tab-form']) !!}
  {!! Form::hidden('patient_id', encrypt($patient->id)) !!}
  {!! Form::hidden('step_number', '1') !!}
<div class="personliving">
  <div class="safety-box">
    <div class="headingpage">{{ trans('label.patient_living_situation') }}*</div>
    <span class="smalltextunderheading">{{ trans('label.check_only_one_which_is_applicable') }}</span>
    <span class="error" id="lives_with_error" style="color:red"></span>
    <div class="clearfix"></div>
    <div class="row check-body">
        
        @foreach($lives_with as $key=>$live_with)
           <div class="col-md-6 col-xl-3">
            <div class="checkdiv">
              {!! Form::checkbox('lives_with', $key, ($key == $patient->lives_with ? true : false),['class'=>'customcheck','old-data'=>($key == $patient->lives_with)? 'jcf-checked':'jcf-unchecked']) !!}
              <label>{{ $live_with }}</label>
            </div>
            </div>
        @endforeach
        <div class="col-md-6 col-xl-3">
          <div class="checkdiv">
            {!! Form::checkbox('living_with_other',null, (($patient->living_with_other) ? true : false),['class'=>'customcheck','old-data'=>($patient->living_with_other)? 'jcf-checked':'jcf-unchecked']) !!}
            <label>Other</label>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="checkdiv is_other textfieldglobal" {!! ((!$patient->living_with_other) ? 'style="display:none;"' : '') !!}>
            {!! Form::text('living_with_other_text',null,array("maxlength" => 100)) !!}
          </div>
          <span class="error" id="living_with_other_text" style="color:red"></span>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="personliving">
  <div class="safety-box">
  <div class="headingpage">{{trans('label.family_contact')}}*</div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-5">
        <p class="smalltextunderheading margnbootom">{{trans('label.person_1_detail')}}
          <span class="checkdiv">
            {!! Form::checkbox('emergency_person1_checkbox',null, (($patient->emergency_person1_checkbox && !$patient->emergency_person2_checkbox) ? true : false),['class'=>'customcheck emergency_checkbox','old-data'=>($patient->emergency_person1_checkbox && !$patient->emergency_person2_checkbox)? 'jcf-checked':'jcf-unchecked']) !!}
            <label>{{trans('label.emergency_contact')}}</label>
          </span>
        </p>
    </div>
    <div class="col-md-5">
      <?php 
        $show_second_person = false;
        if(!empty($patient->emergency_person2_checkbox) || !empty($patient->emergency_person2_name) || !empty($patient->emergency_person2_phone) || !empty($patient->emergency_person2_address) || !empty($patient->emergency_person2_address2) || (!empty($patient->emergency_person2_relation) && $patient->emergency_person2_relation != 'default') || !empty($patient->emergency_person2_state_id) || !empty($patient->emergency_person2_city) || !empty($patient->emergency_person2_zip))
        {
          $show_second_person = true;
        }
      ?>
      <div class="buttonpatient second_emergency_contact_button" style="{{ $show_second_person? "display:none;": "" }}"><a href="javascript:show_second_emergency_contact()"><i class="fas fa-plus"></i> {{trans('label.add_another_emergency_contact')}}</a></div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-5">
      <div class="row">
        <div class="col-md-7">
          <div class="textfieldglobal">
            <label class="labelfieldsname" name="patient_alias">{{trans('label.name')}}*</label>
            {!! Form::text('emergency_person1_name',null,array('maxlength' => 60)) !!}
            <span class="error" style="color:red"></span>
          </div>
        </div>
        <div class="col-md-5">
          <div class="textfieldglobal">
            <label class="labelfieldsname" >{{trans('label.emergency_person1_relation')}}*</label>
            {!! Form::select('emergency_person1_relation', array('' => 'Please select') + $relationshipOptions,null,array("class" => "customselect")) !!}
            <span class="error" style="color:red"></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="textfieldglobal">
        <label class="labelfieldsname" >{{trans('label.emergency_person1_phone')}}*</label>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-2">
            {!! Form::text('phone_code','+1',['class' => 'phone_number_class text-center','disabled'=>true]) !!} 
          </div>
          <div class="col-10">
          {!! Form::text('emergency_person1_phone',null,['class' => 'set_phone_format']) !!}
          <span class="error" style="color:red"></span>
         </div>
        </div>
        <span class="error" style="color:red"></span>
      </div>
    </div>
    <div class="col-md-5">
      <div class="textfieldglobal">
        <label class="labelfieldsname" >{{trans('label.address_line_1')}}* </label>
        {!! Form::text('emergency_person1_address',null,array('maxlength' => 100)) !!}
        <span class="error" style="color:red"></span>
      </div>
    </div>
    <div class="col-md-5">
      <div class="textfieldglobal">
        <label class="labelfieldsname" >{{trans('label.address_line_2')}}</label>
        {!! Form::text('emergency_person1_address2',null,array('maxlength' => 100)) !!}
        <span class="error" style="color:red"></span>
      </div>
    </div>
    <div class="col-md-5">
      <div class="textfieldglobal">
        <label class="labelfieldsname" >{{trans('label.city')}}*</label>
        {!! Form::text('emergency_person1_city',null,array('maxlength' => 50)) !!}
        <span class="error" style="color:red"></span>
      </div>
    </div>
    <div class="col-md-5">
      <div class="row">
        <div class="col-md-7">
          <div class="textfieldglobal">
            <label class="labelfieldsname" >{{trans('label.state')}}*</label>
              {!! Form::select('emergency_person1_state_id',$states,null,array("class" => "customselect")) !!}
            <span class="error" style="color:red"></span>
          </div>
        </div>
        <div class="col-md-5">
          <div class="textfieldglobal">
            <label class="labelfieldsname" >{{trans('label.zip_code')}}*</label>
            {!! Form::text('emergency_person1_zip',null,array('maxlength' => 5)) !!}
            <span class="error" style="color:red"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="second_emergency_contact_section" style="{{ $show_second_person? "": "display:none;" }}">
      <span class="smalltextunderheading margnbootom">{{trans('label.person_2_detail')}}
      <div class="checkdiv">
            {!! Form::checkbox('emergency_person2_checkbox',null, (($patient->emergency_person2_checkbox && !$patient->emergency_person1_checkbox) ? true : false),['class'=>'customcheck emergency_checkbox','old-data'=>($patient->emergency_person2_checkbox && !$patient->emergency_person1_checkbox)? 'jcf-checked':'jcf-unchecked']) !!}
            <label>{{trans('label.emergency_contact')}}</label>
      </div>
      </span>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-7">
              <div class="textfieldglobal">
                <label class="labelfieldsname" name="patient_alias">{{trans('label.name')}}</label>
                {!! Form::text('emergency_person2_name',null,array('maxlength' => 60)) !!}
                <span class="error" style="color:red"></span>
              </div>
            </div>
            <div class="col-md-5">
              <div class="textfieldglobal">
                <label class="labelfieldsname" >{{trans('label.emergency_person2_relation')}}</label>
                {!! Form::select('emergency_person2_relation', array('' => 'Please select') + $relationshipOptions,null,array("class" => "customselect")) !!}
                <span class="error" style="color:red"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="textfieldglobal">
            <label class="labelfieldsname" >{{trans('label.emergency_person2_phone')}}</label>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-2">
                {!! Form::text('phone_code','+1',['class' => 'phone_number_class text-center','disabled'=>true]) !!} 
              </div>
              <div class="col-10">
              {!! Form::text('emergency_person2_phone',null,['class' => 'set_phone_format']) !!}
              <span class="error" style="color:red"></span>
             </div>
            </div>
            <span class="error" style="color:red"></span>
          </div>
        </div>
        <div class="col-md-5">

          <div class="textfieldglobal">
            <label class="labelfieldsname" >{{trans('label.address_line_1')}} </label>
            {!! Form::text('emergency_person2_address',null,array('maxlength' => 100)) !!}
            <span class="error" style="color:red"></span>
          </div>
        </div>
        <div class="col-md-5">
          <div class="textfieldglobal">
            <label class="labelfieldsname" >{{trans('label.address_line_2')}}</label>
            {!! Form::text('emergency_person2_address2',null,array('maxlength' => 100)) !!}
            <span class="error" style="color:red"></span>
          </div>
        </div>
        <div class="col-md-5">
          <div class="textfieldglobal">
            <label class="labelfieldsname" >{{trans('label.city')}}</label>
            {!! Form::text('emergency_person2_city',null,array('maxlength' => 50)) !!}
            <span class="error" style="color:red"></span>
          </div>
        </div>
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-7">
              <div class="textfieldglobal">
                <label class="labelfieldsname" >{{trans('label.state')}}</label>
                  {!! Form::select('emergency_person2_state_id',$states,null,array("class" => "customselect")) !!}
                <span class="error" style="color:red"></span>
              </div>
            </div>
            <div class="col-md-5">
              <div class="textfieldglobal">
                <label class="labelfieldsname" >{{trans('label.zip_code')}}</label>
                {!! Form::text('emergency_person2_zip',null,array('maxlength' => 5)) !!}
                <span class="error" style="color:red"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  </div>
  <div class="clearfix"></div>
  <div class="personliving">
    <div class="safety-box">
      <div class="headingpage">{{ trans('label.ed_visits_and_admissions') }}*</div>
      <div class="mt-10"></div>
      <div class="clearfix"></div>
      <div class="row">
          <div class="col-md-5">
              <div class="textfieldglobal">
                  <label class="labelfieldsname">{{ trans('label.ed_visits_last_12_months') }}</label>
                  {!! Form::text('ed_visits_last_12_months',null,array('maxlength' => 10)) !!}
                  <span class="error" style="color:red"></span> 
              </div>
          </div>
          <div class="col-md-5">
              <div class="textfieldglobal">
                  <label class="labelfieldsname">{{ trans('label.ed_admissions_last_12_months') }}</label>
                  {!! Form::text('ed_admissions_last_12_months',null,array('maxlength' => 10)) !!}
                  <span class="error" style="color:red"></span> 
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="buttonsbottom">
    <button type="button" class="next" onClick="javascript:saveform('saveandnext','#personal-detail-tab-form','1')">{{trans('label.save_and_next')}}</button>
    <button type="button" class="next" onClick="javascript:saveform('saveandclose','#personal-detail-tab-form','1')">{{trans('label.save_and_close')}}</button>
    <a href="#" class="close close close_form">{{ trans('label.cancel') }}</a> 
</div>
{!! Form::close() !!}