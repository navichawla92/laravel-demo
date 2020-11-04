<?php
   $speciality_array=speciality_array();
   ?>
<div class="modal fade adddocumentdocuments" id="add_new_type1" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   {!! Form::open(['id' => 'add_new_type1_form']) !!}
   <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
   <input type="hidden" name="type" value="pcp_informations">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <div class="headingpage"> Add New Type1 </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
         </div>
         <div class="modal-body">
            <div class="datapopfileds">
               <div class="clearfix"></div>

                <div class="row">
                  <div class="col-6">
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.doctor_name')}}* </label>
                        {!! Form::text('name',null,['maxlength'=>'60']) !!}
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.org_name')}}* </label>
                        {!! Form::text('org_name',null,['maxlength'=>'100']) !!}
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.speciality')}}* </label>
                        {!! Form::select('speciality', array('' => 'Please select') + $speciality_array,null,array("class" => "customselect")) !!}
                        <span class="error" style="color:red"></span>
                     </div>

                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.phone_number')}}* </label>
                        <div class="clearfix"></div>
                        <div class="row">
                           <div class="col-md-2">
                              {!! Form::text('phone_code','+1',['class' => 'phone_number_class','disabled'=>true]) !!} 
                           </div>
                           <div class="col-md-10">
                              {!! Form::text('phone_number',null,['class' => 'set_phone_format']) !!}
                              <span class="error" style="color:red"></span>
                           </div>
                        </div>
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.address_line_1')}}* </label>
                        {!! Form::text('address_line1',null,['maxlength'=>'100']) !!}
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.address_line_2')}} </label>
                        {!! Form::text('address_line2',null,['maxlength'=>'100']) !!}
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.city')}}* </label>
                        {!! Form::text('city',null,['maxlength'=>'50']) !!}
                        <span class="error" style="color:red"></span>
                     </div>

                     <div class="textfieldglobal">
                        <div class="row">
                           <div class="col-6">
                              <div class="">
                                 <label class="labelfieldsname" > {{trans('label.state')}}* </label>
                                 {!! Form::select('state_id', $states,null,['class' => 'customselect']); !!}    
                                 <span class="error" style="color:red"></span>
                              </div>
                           </div>
                           <div class="col-6">
                              <div class="">
                                 <label class="labelfieldsname" > {{ trans('label.zip_code') }}* </label>
                                 {!! Form::text('zip',null,['maxlength'=>'5']) !!}
                                 <span class="error" style="color:red"></span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.email_address')}} </label>
                        {!! Form::text('email',null,['maxlength'=>'45']) !!}
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.fax')}} </label>
                        {!! Form::text('fax',null,['maxlength'=>'10']) !!}
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.web_address')}} </label>
                        {!! Form::text('web_address',null,['maxlength'=>'100']) !!}
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.contact_person_name')}} </label>
                        {!! Form::text('contact_name',null,['maxlength'=>'60']) !!}
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.contact_person_phone')}} </label>
                        <div class="clearfix"></div>
                        <div class="row">
                           <div class="col-md-2">
                              {!! Form::text('phone_code','+1',['class' => 'phone_number_class','disabled'=>true]) !!} 
                           </div>
                           <div class="col-md-10">
                              {!! Form::text('contact_phone',null,['class' => 'set_phone_format']) !!}
                              <span class="error" style="color:red"></span>
                           </div>
                        </div>
                        <span class="error" style="color:red"></span>
                     </div>
                     <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.contact_person_title')}} </label>
                        {!! Form::text('contact_title',null,['maxlength'=>'10']) !!}
                        <span class="error" style="color:red"></span>
                     </div>
                      <div class="textfieldglobal">
                        <label class="labelfieldsname" > {{trans('label.contact_person_email')}} </label>
                        {!! Form::text('contact_email',null,['maxlength'=>'45']) !!}
                        <span class="error" style="color:red"></span>
                     </div>


                  </div>
               </div>
               
               
               
            </div>
         </div>
         <div class="modal-footer">
            <div class="buttonsbottom">
               <button type="button" class="next model_box_save" onClick="javascript:addNewType1('add_new_type1')"> {{trans('label.save')}} </button>
               <a href="#" class="close" data-dismiss="modal" aria-label="Close"> {{trans('label.cancel')}} </a> 
            </div>
         </div>
      </div>
   </div>
   {!! Form::close() !!}
</div>