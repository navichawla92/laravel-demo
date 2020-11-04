@extends('layouts.app')

@section('css')
  <link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
@endsection
@section('title')
 {{ trans('label.patient_registration') }}
@endsection

@section('content')
<div class="leftsectionpages">
   <div class="row">
      <div class="col-md-6">
         <div class="headingpage">
            <div class="firstname">{{ trans('label.patient_registration') }}</div>
            <span><i class="fas fa-angle-right"></i></span>{{ trans('label.patient_assessment') }}
         </div>
      </div>
   </div>
   <div class="tabsmain">
      <div class="row">
         <div class="col-md-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
               <li class="nav-item"> <a class="nav-link active" id="patientinfo-tab" data-toggle="tab" href="#patient-info-content" role="tab" aria-controls="home" aria-selected="true">{{ trans('label.personal_detail_tab') }} </a> </li>
               <li class="nav-item"> <a class="nav-link" id="medical-care-li" data-toggle="{{ ($patient->chw_tab_completed >=1)?'tab':'' }}" href="#medical-care-content" role="tab" aria-controls="profile" aria-selected="false">{{ trans('label.medical_care_contact_tab') }} </a> </li>
               <li class="nav-item"> <a class="nav-link" id="insurance-li" data-toggle="{{ ($patient->chw_tab_completed >=2)?'tab':'' }}" href="#insurance-content" role="tab" aria-controls="contact" aria-selected="false"> {{ trans('label.insurance_payer') }} </a> </li>
               <li class="nav-item"> <a class="nav-link" id="assessment-li" data-toggle="{{ ($patient->chw_tab_completed >=3)?'tab':'' }}" href="#assessment-content" role="tab" aria-controls="assessment" aria-selected="false">{{ trans('label.chw_assessment') }} </a> </li>
            </ul>
         </div>
         <div class="col-md-4 smalltextunderheading paddingbtm15">
            <div class="document-notetabs">
               <ul class="nav nav-tabs" id="myTab2" role="tablist">
                  <li class="nav-item"> <a class="nav-link {{ ($active_tab == 'document')?'active':'' }}" id="document-tab" href="#document" role="tab" data-toggle="tab" aria-controls="contact" aria-selected="false"> {{ trans('label.documents') }} </a> </li>
                  <li class="nav-item"> <a class="nav-link {{ ($active_tab == 'note')?'active':'' }}" id="note" data-toggle="tab" href="#notes" role="tab" aria-controls="contact" aria-selected="false"> {{ trans('label.notes') }} </a> </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="tab-content" id="myTabContent">
         <div class="tab-pane fade {{ ($active_tab == 'personal_detail')?'show active':'' }}" id="patient-info-content" role="tabpanel" aria-labelledby="home-tab">
            @include('chw.patients.registration.personal_detail')
         </div>
         <!--	second tab	-->
         <div class="tab-pane fade" id="medical-care-content" role="tabpanel" aria-labelledby="profile-tab">
           @if($patient->chw_tab_completed >= 1)
              @include('chw.patients.registration.medical_care')
           @endif
         </div>
         <!--third tab -->
         <div class="tab-pane fade" id="insurance-content" role="tabpanel" aria-labelledby="contact-tab">
            @if($patient->chw_tab_completed >= 2)
              @include('chw.patients.registration.insurance_payer')
            @endif
         </div>
         <!-- fourth tab -->
         <div class="tab-pane fade" id="assessment-content" role="tabpanel" aria-labelledby="contact-tab">
            @if($patient->chw_tab_completed >= 3)
              @include('patients.common.assessment_comments_tab')
            @endif
         </div>
         <!--document	-->
         <div class="tab-pane fade {{ ($active_tab == 'document')?'active show':'' }}" id="document" role="tabpanel" aria-labelledby="contact-tab">
            @include('patients.common.patient_documents_tab')
         </div>
         <!--notes	-->
         <div class="tab-pane fade {{ ($active_tab == 'note')?'active show':'' }}" id="notes" role="tabpanel" aria-labelledby="contact-tab">
             @include('patients.common.patient_notes_tab')
         </div>
      </div>
   </div>
</div>
@endsection

@section('common_script')
  @include('patients.common.common_script')
@endsection  


@section('script')
   <script type="text/javascript">
   /*
    *--------Advanced Directive Tab--------
    *Scripting for 1st tab starts from here 
   */
   let current_listing = '';
   $(document).ready(function(){
      applpyEllipses('primary_table', 4, 'no');
      applpyEllipses('secondary_table', 3, 'no');
      addOldValue();
      fadeOutAlertMessages();
      $(".set_phone_format").inputmask("(999) 999-9999",{showMaskOnFocus : false, showMaskOnHover : false});

      //call PCP-Info function to select already filled value if any
      dynamicDropDown('#pcp_information', 'pcp_');
      dynamicDropDown('#hhp_dropdown', 'hhp_');
      dynamicDropDown('#hp_dropdown', 'hp_');
      insuranceDropDown('#insurancePrimary');
      insuranceDropDown('#insuranceSecondary');
      datePickers();
      contractPayerValues();

      //on change of PCP-Info select
      $(document).on('change', '.dynamic_dropdown', function(e) {
         dynamicDropDown('#'+$(this).attr('id'),$(this).data('class_initial'));
      });

      $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');  
        //var data = $("#patient-filter-form").serialize();
        getPaginationResult(url);
      });

   });

   function dynamicDropDown(dropdownId,class_initial) {
     if($(dropdownId+' option:selected').val() != ''){

       if($(dropdownId).parent().parent().parent().find('.readonly_field:first').is(":hidden")){
         $(dropdownId).parent().parent().parent().find('.readonly_field span.error').hide().removeClass('active');
       }

       $(dropdownId).parent().parent().parent().find('.readonly_field').show();
       $.each($(dropdownId+' option:selected').data(), function(i, v) {
           $(dropdownId).parent().parent().parent().find('.'+class_initial+i).val(v);
       });
     }else{
       $(dropdownId).parent().parent().parent().find('.readonly_field').hide();
     }
   } 

  function getPaginationResult(url) {
    var required_listing;
    if(current_listing == 'pcp_informations' || current_listing == 'specialities')
      required_listing = 'table_of_listing_type1';
    else
      required_listing = 'table_of_listing_type2';
   $.ajax({
      url:url,
      type:"GET",
      data:{
        is_pagination: 'yes',
        type: current_listing,
        required_listing: required_listing
      },
      dataType: "html",
      success:function(data){
        $(".listing_of_selected_type").parent().find('ul.pagination').remove();
        $(".listing_of_selected_type").remove();
        $(".listing_of_selected_type_section").append(data);
      },
      error:function(data){
        $(".referral_table").html(data);
      }
    });
  }


   function viewRespectiveType(clicked_tag, type) {
      $.each($(clicked_tag).data(), function(i, v) {
        $(type).find('.'+i).html(v);
      });  
      if($(clicked_tag).data('modal_type') && $(clicked_tag).data('modal_type').length){
        if($(clicked_tag).data('modal_type') == 'rehabs'){
          $(type+' p.view_type2_label_title2').show();
          $(type+' p.view_type2_label_name2').show();
          $(type+' p.view_type2_label_email2').show();
          $(type+' p.view_type2_label_phone2').show();
          $(type+' p.view_type2_label_title1').hide();
          $(type+' p.view_type2_label_name1').hide();
          $(type+' p.view_type2_label_email1').hide();
          $(type+' p.view_type2_label_phone1').hide();
        }
        else{
          $(type+' p.view_type2_label_title2').hide();
          $(type+' p.view_type2_label_name2').hide();
          $(type+' p.view_type2_label_email2').hide();
          $(type+' p.view_type2_label_phone2').hide();
          $(type+' p.view_type2_label_title1').show();
          $(type+' p.view_type2_label_name1').show();
          $(type+' p.view_type2_label_email1').show();
          $(type+' p.view_type2_label_phone1').show();
        }
      }
      else{
        $(type+' p.view_type2_label_title2').hide();
        $(type+' p.view_type2_label_name2').hide();
        $(type+' p.view_type2_label_email2').hide();
        $(type+' p.view_type2_label_phone2').hide();
        $(type+' p.view_type2_label_title1').show();
        $(type+' p.view_type2_label_name1').show();
        $(type+' p.view_type2_label_email1').show();
        $(type+' p.view_type2_label_phone1').show();

      } 

      if(current_listing && current_listing == 'specialities')
        $(type).find('.modal_heading').html('Specialist Details');      
      else if(current_listing && current_listing == 'rehabs')
        $(type).find('.modal_heading').html('Rehab Details');
      else if(current_listing && current_listing == 'housing_assistances')
        $(type).find('.modal_heading').html('Housing Assistance Details');
      else if(current_listing && current_listing == 'mental_health_assistances')
        $(type).find('.modal_heading').html('Mental Health Assistance Details');

      $(type).modal('show');
   }   

   function addNewItem(type, heading) {
      $('.model_box_save').removeAttr("disabled");
      $(".set_phone_format").inputmask("(999) 999-9999",{showMaskOnFocus : false, showMaskOnHover : false});
      $('#'+type).find('.headingpage').html(heading);
    
      if(current_listing == 'mental_health_assistances' || current_listing == 'housing_assistances'){
        $('#'+type).find('.add_type2_person_contact_name').text("{{ trans('label.counsellor_person_name') }}");
        $('#'+type).find('.add_type2_person_contact_phone').text("{{ trans('label.counsellor_person_phone') }}");
        $('#'+type).find('.add_type2_person_contact_email').text("{{ trans('label.counsellor_person_email') }}");
        $('#'+type).find('.add_type2_person_contact_title').text("{{ trans('label.counsellor_person_title') }}");
      }
      else if(current_listing == 'rehabs'){
        $('#'+type).find('.add_type2_person_contact_name').text("{{ trans('label.contact_person_name') }}");
        $('#'+type).find('.add_type2_person_contact_phone').text("{{ trans('label.contact_person_phone') }}");
        $('#'+type).find('.add_type2_person_contact_email').text("{{ trans('label.contact_person_email') }}");
        $('#'+type).find('.add_type2_person_contact_title').text("{{ trans('label.contact_person_title') }}");
      }

      if(current_listing != 'specialities')
        $('#'+type).find('input[type=hidden][name=type]').val(current_listing);
      else
        $('#'+type).find('input[type=hidden][name=type]').val('specialities');
      $('#'+type).modal('show');
      initCustomForms();
   }

  // function for save Pcp Info
  function addNewType1(type){

    //unmask value of phone number fields
    $(".set_phone_format").inputmask('remove');
    $('.model_box_save').attr("disabled", "disabled");
    var formData = new FormData($('#add_new_type1_form')[0]);
    $.ajax({
      url:"{{ route('pcp-information-add') }}",
      data:formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success:function(data){
        //$('.model_box_save').removeAttr("disabled");
        //$(".set_phone_format").inputmask("(999) 999-9999",{showMaskOnFocus : false, showMaskOnHover : false});
        $('#'+type).modal('hide');  


        if(current_listing != 'specialities')
          getRespectiveListing(current_listing, 'listing_of_selected_type1','Choose PCP', '','Add PCP');
        else
          getRespectiveListing(current_listing, 'listing_of_selected_type1','Choose Specialist', '','Add Specialist');
      },
      error:function(error){
        $('.model_box_save').removeAttr("disabled");
        $(".set_phone_format").inputmask("(999) 999-9999",{showMaskOnFocus : false, showMaskOnHover : false});
        $.each(error.responseJSON.errors,function(key,value){
            if(key == 'patient_concern')
                $('#patient_concern_error').html(value).addClass('active').show();     
            else
            {
               $('input[name="'+key+'"]').parent().find('span.error').html(value).addClass('active').show();
               $('select[name="'+key+'"]').parent().find('span.error').html(value).addClass('active').show();
           }
        });

        jQuery('html, body').animate({
            scrollTop: jQuery(document).find('.error.active:first').parent().offset().top
        }, 500);
              
      }
    });
  }  

  // function for save Pcp Info
  function addNewType2(type){

    //unmask value of phone number fields
    $(".set_phone_format").inputmask('remove');
    $('.model_box_save').attr("disabled", "disabled");
    var formData = new FormData($('#add_new_type2_form')[0]);
    $.ajax({
      url:"{{ route('registry-add') }}",
      data:formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success:function(data){
        $('#'+type).modal('hide');  

        if(current_listing == 'housing_assistances')
          getRespectiveListing('housing_assistances', 'listing_of_selected_type2', 'Choose Housing Assistance', '','Add Housing Assistance');
        else if(current_listing == 'rehabs')
          getRespectiveListing('rehabs', 'listing_of_selected_type2', 'Choose Rehab', '','Add Rehab Information');
        else if(current_listing == 'mental_health_assistances')
          getRespectiveListing('mental_health_assistances', 'listing_of_selected_type2', 'Choose Mental Health Assistance', '','Add Mental Health Assistance');

        //getRespectiveListing(current_listing, 'listing_of_selected_type2');
      },
      error:function(error){
        $('.model_box_save').removeAttr("disabled");
        $(".set_phone_format").inputmask("(999) 999-9999",{showMaskOnFocus : false, showMaskOnHover : false});
        $.each(error.responseJSON.errors,function(key,value){
            if(key == 'patient_concern')
                $('#patient_concern_error').html(value).addClass('active').show();     
            else
            {
               $('input[name="'+key+'"]').parent().find('span.error').html(value).addClass('active').show();
               $('select[name="'+key+'"]').parent().find('span.error').html(value).addClass('active').show();
           }
        });

        jQuery('html, body').animate({
            scrollTop: jQuery(document).find('.error.active:first').parent().offset().top
        }, 500);
              
      }
    });
  }

  function saveform(button_pressed,formId,tab)
  {

    //unmask value of phone number fields
    $(".set_phone_format").inputmask('remove');

    var formData = new FormData($(formId)[0]);

    $.ajax({
      url:"{{ route('registration_chw_assessment_save') }}",
      data:formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success:function(data){
        $('input,textarea,select').removeClass('changed-input');
        if(button_pressed == 'saveandclose' || button_pressed == 'movetopre' || button_pressed == 'movetoreg')
        {
          window.location.href="{{ route('chw-registrations')  }}";
        }
        else if(button_pressed == 'saveandnext')
        {
          //enable phone masking again 
          $(".set_phone_format").inputmask("(999) 999-9999",{showMaskOnFocus : false, showMaskOnHover : false});

          if(tab == 1)
          {
            getMedicareTabHtml('yes');
          }
          else if(tab == 2)
          {
           $.ajax({  
                url:"{{ route('registration_chw_assessment_get_medical_care_tab_html') }}",
                type: "GET",
                dataType: "html",
                data: {
                  tab: 'insurance-html',
                  patient_id:"{{ encrypt($patient->id) }}"
                },
                success:function(data){

                  //check if not required ticked for PCP in second tab if so then clear any added PCP
                  if($('.medical_care_content input[type=checkbox][name=pcp_not_required]').is(":checked")){
                    $(".medical_care_content .care-table.pcp_section tbody").html(
                      '<tr><td colspan="5"><h6 class="care-nodata">No Data added yet</h6></td></tr>'
                    );
                  }  

                  $('#insurance-li').attr('data-toggle','tab')
                  $('#insurance-content').html(data);

                  //move to next available tab
                  $('.nav-tabs a.active').parent().next('li').find('a').trigger('click');
                  insuranceDropDown('#insurancePrimary');
                  insuranceDropDown('#insuranceSecondary');
                  contractPayerValues();
                  datePickers();
                  addOldValue();
                  insuranceDiv();
                  initCustomForms();
                  //scroll top
                  jQuery('html, body').animate({
                      scrollTop: jQuery('body').offset().top
                  }, 500);
                  
               }
            });
          }
          else if(tab == 3)
          {
            $.ajax({  
                url:"{{ route('registration_chw_assessment_get_medical_care_tab_html') }}",
                type: "GET",
                dataType: "html",
                data: {
                  tab: 'assessment-html',
                  patient_id:"{{ encrypt($patient->id) }}"
                },
                success:function(data){

                  $('#assessment-li').attr('data-toggle','tab')
                  $('#assessment-content').html(data);

                  //move to next available tab
                  $('.nav-tabs a.active').parent().next('li').find('a').trigger('click');
                  initCustomForms();
                  //scroll top
                  jQuery('html, body').animate({
                      scrollTop: jQuery('body').offset().top
                  }, 500);
               }
            });
          }
        }
      },
      error:function(error){

          //enable phone masking again 
          $(".set_phone_format").inputmask("(999) 999-9999",{showMaskOnFocus : false, showMaskOnHover : false});

          $.each(error.responseJSON.errors,function(key,value){
              $('input[name="'+key+'"]').parent().find('span.error').html(value).addClass('active').show();
              $('select[name="'+key+'"]').parent().find('span.error').html(value).addClass('active').show();
              if(key == 'pcp_not_required'){
                $('#pcp_not_required').html(value).addClass('active').show();
              }
              else if(key == 'lives_with')
                $('#lives_with_error').html(value).addClass('active').show();
              else if(key == 'living_with_other_text')
                $('#living_with_other_text').html(value).addClass('active').show();
              else if(key == 'is_insured')
                $('#is_insured_error').html(value).addClass('active').show();   
              else if(key == 'contract_payer')
                $('#contract_payer_error').html(value).addClass('active').show(); 
              else if(!key.indexOf("insurances"))
              {
                if (key.indexOf('0') > -1)
                {
                  key = key.replace(".0", "[0]");
                  key = key.replace(".", "[");
                  key += ']';
                }
                else
                {
                  key = key.replace(".1", "[1]");
                  key = key.replace(".", "[");
                  key += ']';
                }
                 $('input[name="'+key+'"]').parent().find('span.error').html(value).addClass('active').show();
                 $('select[name="'+key+'"]').parent().find('span.error').html(value).addClass('active').show();
              }
          }); 

          if($('#Insurance_div span.error.active').length){
          if(!$('#Insurance_div span.error.active:first').closest('.tab-pane').hasClass('active'))
          {
             $('.insure-tabs .nav-pills').find('a').removeClass('active');
             $('.insure-tabs #v-pills-tabContent .tab-pane').removeClass('show active');

             var nav_link_active = $('#Insurance_div span.error.active:first').closest('.tab-pane').attr('aria-labelledby');
             
             $('#Insurance_div .nav-pills').find('a[id='+nav_link_active+']').addClass('active')
             $('#Insurance_div span.error.active:first').closest('.tab-pane').addClass('show active')
          }

          jQuery('html, body').animate({
              scrollTop: jQuery(document).find('.error.active:first').parent().offset().top
          }, 500);

          }else{
          jQuery('html, body').animate({
              scrollTop: jQuery(document).find('.error.active:first').parent().offset().top
          }, 500);
          } 
          
         /* jQuery('html, body').animate({
              scrollTop: jQuery(document).find('.error.active:first').parent().offset().top
          }, 500);   */  
      }
    });
  }  

  function assignItem(type, id, value)
  {
    var dataSet = {patient_id: "{{ encrypt($patient->id) }}", type:type, [id]: value};
    $.ajax({
      url:"{{ route('registration_chw_assessment_assign_item') }}",
      data:dataSet,
      type:"GET",
      dataType: "json",
      success:function(data){
        getMedicareTabHtml('no');
        current_listing = '';
      },
      error:function(error){

        $.each(error.responseJSON.errors,function(key,value){
            $('.listing_of_selected_type_section').prepend('\
              <div class="alert alert-danger alert-dismissible"> \
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                  '+value+'\
              </div>\
            ');
          }); 

        jQuery('html, body').animate({
            scrollTop: jQuery(document).find('.alert-danger').parent().offset().top
        }, 500);     

        fadeOutAlertMessages();
    }
    });
  }

  function removeItem(type, id, id_to_be_deleted)
  {
     bootbox.confirm({ 
        message: "Are you sure, you want to remove?", 
        buttons: {
        confirm: {
            label: 'Yes',
           // className: 'btn-primary'
        },
        cancel: {
            label: 'No',
          //  className: 'btn-primary'
        }
        },
        callback: function(result){  
        if (result) {
          var dataSet = {patient_id: "{{ encrypt($patient->id) }}", type:type, [id]: id_to_be_deleted};
          $.ajax({
            url:"{{ route('registration_chw_assessment_remove_item') }}",
            data:dataSet,
            type:"GET",
            dataType: "json",
            success:function(data){
              getMedicareTabHtml('no');
            },
            error:function(error){

                jQuery('html, body').animate({
                    scrollTop: jQuery(document).find('.error.active:first').parent().offset().top
                }, 500);     
            }
          });
        }
        else {
          bootbox.hideAll();
          return false;
        }
       }
    });
  }

  function getMedicareTabHtml(scroll){
    $.ajax({  
        url:"{{ route('registration_chw_assessment_get_medical_care_tab_html') }}",
        type: "GET",
        dataType: "html",
        data: {
          tab: 'medicare-html',
          patient_id:"{{ encrypt($patient->id) }}"
        },
        success:function(data){
         
          $('#medical-care-content').html('');
          $('#medical-care-content').html(data);
          
          
          if(scroll == 'yes')
          {
            $('#medical-care-li').attr('data-toggle','tab');
            
            //move to next available tab
            $('.nav-tabs a.active').parent().next('li').find('a').trigger('click');
            
            //scroll top
            jQuery('html, body').animate({
                scrollTop: jQuery('body').offset().top
            }, 500);
          }
          else {
            if(jQuery(document).find('.alert-success.alert-dismissible:first').length > 0){
              jQuery('html, body').animate({
                    scrollTop: jQuery(document).find('.alert-success.alert-dismissible:first').offset().top-50
                }, 500); 
            }
            fadeOutAlertMessages();
          }
          initCustomForms();
          applpyEllipses('primary_table', 4, 'no');
          applpyEllipses('secondary_table', 3, 'no');
       }
    });
  }

  function getRespectiveListing(type, required_listing, listing_heading, is_search,add_heading, view_heading)
  {
    if(is_search == 'yes'){
        var dataSet = {required_listing: required_listing, type:type, is_search: 'yes', search_string: $('.listing_of_selected_type_section input[name=search]').val()};
    }else{
        var dataSet = {required_listing: required_listing, type:type};
    }
    $.ajax({  
        url:"{{ route('registration_chw_assessment_listing_by_type') }}",
        type: "GET",
        dataType: "html",
        data: dataSet,
        success:function(data){
          current_listing = type;
          $('#medical-care-content .listing_of_selected_type1, #medical-care-content .listing_of_selected_type2').remove();
          $('#medical-care-content .medical_care_content').hide();
          $('#medical-care-content').append(data);
          $('#medical-care-content .'+required_listing).show();
          $('#medical-care-content .'+required_listing+' .listing_of_selected_type_section h3:first span').text(listing_heading);

          //change OnClick parameters for PCP/Specialist
          $('#medical-care-content .'+required_listing+' .listing_of_selected_type_section .care-search button').attr("onClick","getRespectiveListing('"+type+"', '"+required_listing+"', '"+listing_heading+"', 'yes', '"+add_heading+"', '"+view_heading+"')");
          $('#medical-care-content .'+required_listing+' .listing_of_selected_type_section .care-search i').attr("onClick","getRespectiveListing('"+type+"', '"+required_listing+"', '"+listing_heading+"', 'no', '"+add_heading+"', '"+view_heading+"')");
          
          var add_type = '';
          if(required_listing == 'listing_of_selected_type1'){
            add_type = 'add_new_type1';
            applpyEllipses('listing_of_selected_type_section', 5, 'no');
          }
          else{
            add_type = 'add_new_type2';
            applpyEllipses('listing_of_selected_type_section', 4, 'no');
            
          }

          if(type == 'mental_health_assistances' || type == 'housing_assistances'){
            $('#medical-care-content .'+required_listing+' .listing_of_selected_type_section .list_2_contact_person_name').text("{{ trans('label.counsellor_person_name') }}");
            $('#medical-care-content .'+required_listing+' .listing_of_selected_type_section .list_2_contact_person_phone').text("{{ trans('label.counsellor_person_phone') }}");
          }
            
           $('#medical-care-content .'+required_listing+' .listing_of_selected_type_section h3:first a').attr("onClick","addNewItem('"+add_type+"', '"+add_heading+"')");
          //console.log('here');
          // initCustomForms();
          if(is_search == 'yes'){
              $('#medical-care-content .'+required_listing+' .listing_of_selected_type_section .care-search i').show();
          }else{
              $('#medical-care-content .'+required_listing+' .listing_of_selected_type_section .care-search i').hide();
          }
            // for tooltip
          $(function () {
            $('[data-toggle="tooltip"]').tooltip()
          })
          //scroll top
          jQuery('html, body').animate({
              scrollTop: jQuery('body').offset().top
          }, 500);
       }
    });
  }

  //for patient info tab
  $('input[type=checkbox][name=living_with_other]').change(function() {
    
    if(this.checked) {
      $('input[type=checkbox][name="lives_with"]').prop("checked", false);
      $('input[type=checkbox][name="lives_with"]').parent('.jcf-checkbox').removeClass('jcf-checked');
      $('input[type=checkbox][name="lives_with"]').parent('.jcf-checkbox').addClass('jcf-unchecked');
      $(this).attr("checked", true);
      $('.is_other').show();
    }else{
      if($('.is_other').find('input').attr("old_value") == $('.is_other').find('input').val()){
          $('.is_other').find('input').removeClass('changed-input');
          console.log('here');
        }
        else if($('.is_other').find('input').attr("old_value") == ''){
            $('.is_other').find('input').removeClass('changed-input');
        }
        $('.is_other').find('span.error').hide().removeClass('active');
        $('.is_other').hide();
    }
  });     

  //to hide is other error
  $('input[name=living_with_other_text]').focus(function() {
      $('#living_with_other_text').html('').removeClass('active').hide();
  });   

  //to show cross icon on search something
  $('input[type=checkbox][name=living_with_other]').change(function() {
    
    if(this.checked) {
      $('input[type=checkbox][name="lives_with"]').prop("checked", false);
      $('input[type=checkbox][name="lives_with"]').parent('.jcf-checkbox').removeClass('jcf-checked');
      $('input[type=checkbox][name="lives_with"]').parent('.jcf-checkbox').addClass('jcf-unchecked');
      $(this).attr("checked", true);
      $('.is_other').show();
    }else{
      if($('.is_other').find('input').attr("old_value") == $('.is_other').find('input').val()){
          $('.is_other').find('input').removeClass('changed-input');
          console.log('here');
        }
        else if($('.is_other').find('input').attr("old_value") == ''){
            $('.is_other').find('input').removeClass('changed-input');
        }
        $('.is_other').find('span.error').hide().removeClass('active');
        $('.is_other').hide();
    }
  }); 

  //for patient living
  $('input[type=checkbox][name="lives_with"]').change(function() {

    $('input[type=checkbox][name="lives_with"]').not(this).prop('checked', false);

   // $('input[type=checkbox][name="lives_with"]').attr("checked", false);
    $('input[name=living_with_other]').prop("checked", false);
    $('.is_other').find('input').removeClass('changed-input');
    $('.is_other').hide(); //uncheck all checkboxes
    $('input[type=checkbox][name="lives_with"],input[name=living_with_other]').parent('.jcf-checkbox').removeClass('jcf-checked');
     $('input[type=checkbox][name="lives_with"],input[name=living_with_other]').parent('.jcf-checkbox').addClass('jcf-unchecked');
     $('input[type=checkbox][name="lives_with"]').each(function(){
        if($(this).is(":checked") && $(this).attr("old-data") == 'jcf-checked'){
           $(this).removeClass('changed-input');
        }
        else if(!$(this).is(":checked") && $(this).attr("old-data") == 'jcf-unchecked'){
         $(this).removeClass('changed-input');
        }
        else {
         $(this).addClass('changed-input');
        } 
     });

     $(this).attr("checked", true);  //check the clicked one

  }); 

  // for tab changes
  function show_second_emergency_contact(){
    $('.second_emergency_contact_section').show();
    $('.second_emergency_contact_button').hide();
  }  

  // for tab changes
  function hideListingShowmedicareTab(){
    $('#medical-care-content .medical_care_content').show();
    $('#medical-care-content .listing_of_selected_type1, #medical-care-content .listing_of_selected_type2').remove();
    current_listing = '';
  }

  $(document).on('click','.emergency_checkbox',function(){
    $(".emergency_checkbox").attr("checked", false); //uncheck all checkboxes
    $(".emergency_checkbox").parent('.jcf-checkbox').removeClass('jcf-checked');

     $(".emergency_checkbox").each(function(){
        if($(this).is(":checked") && $(this).attr("old-data") == 'jcf-checked'){
           $(this).removeClass('changed-input');
        }
        else if(!$(this).is(":checked") && $(this).attr("old-data") == 'jcf-unchecked'){
         $(this).removeClass('changed-input');
        }
        else {
         $(this).addClass('changed-input');
        } 
    });

    //$(this).attr("checked", true);  //check the clicked one
    $('.emergency_checkbox').not(this).prop('checked', false);
  });


 /* Changes for not required */
 //On change not required checkbox for any of the option
  $(document).on('change', '.not_required_checkbox', function(){
    if(this.checked) {
      $('#pcp_add_new_btn').hide();
      $('.'+$(this).data('section_class')).addClass('disable-not-section');
      $('#'+this.name).html('').addClass('active').hide();
    }else{
      if($('.pcp_section table tbody tr').find('td').length <= 1)
        $('#pcp_add_new_btn').show();
      $('.'+$(this).data('section_class')).removeClass('disable-not-section');
    }
  });

//for insurance tab 
$(document).on('change', 'input[name=is_insured]', function(e) {
  insuranceDiv();
});

//for insurance tab 
$('.wrapper').on('change', '#contract_payer_section', function(e) {
  contractPayerValues();
});

//for insurance tab 

function insuranceDiv(){
  //for insurance tab 
  if ($('.is_insured').is(':checked')){
    $('.insurance_optional_section').addClass('disabled-nav-link');
    $('.insurance_optional_section').find('input').removeClass('changed-input');
    $('.insurance_optional_section').find('select').removeClass('changed-input');
    
    $('.insure-tabs .nav-pills').find('a').removeClass('active');
    $('.insure-tabs #v-pills-tabContent .tab-pane').removeClass('show active');
    

    $('#v-pills-messages').addClass('show active');
    $('#v-pills-messages-tab').addClass('active');
  }
  else
  {
    $('.insurance_optional_section').removeClass('disabled-nav-link');
  }
}




function contractPayerValues(){
  $('span.error').hide().removeClass('active');
  if($('#contract_payer_section option:selected').val() != ''){
    
    if($('#contract_payer_section').parent().parent().parent().find('.readonly_field:first').is(":hidden")){
      $('#contract_payer_section').parent().parent().parent().find('.readonly_field span.error').hide().removeClass('active');
    }
    
    $('#contract_payer_section').parent().parent().parent().find('.readonly_field').show();
    $.each($('#contract_payer_section option:selected').data(), function(i, v) {
        $('#contract_payer_section').parent().parent().parent().find('.'+i).val(v);
    });
  }else{
    $('#contract_payer_section').parent().parent().parent().find('.readonly_field').hide();
    $('#contract_payer_section').parent().parent().parent().find('input:not([type=hidden],[name=authorization_code]),select').val('');
  }
}

$('.wrapper').on('change', '.insurances', function(e) {
  insuranceDropDown('#'+$(this).attr('id'));
});

function insuranceDropDown(insurancesId) {
  if(insurancesId == '#insurancePrimary' && $(insurancesId).val())
    $("#insuranceSecondary option[value=" + $(insurancesId).val() + "]").attr('disabled','disabled')
        .siblings().removeAttr('disabled');
  if(insurancesId == '#insuranceSecondary' && $(insurancesId).val())
    $("#insurancePrimary option[value=" + $(insurancesId).val() + "]").attr('disabled','disabled')
        .siblings().removeAttr('disabled');
  if($(insurancesId+' option:selected').val() != ''){

    if($(insurancesId).parent().parent().parent().find('.readonly_field:first').is(":hidden")){
      $(insurancesId).parent().parent().parent().find('.readonly_field span.error').hide().removeClass('active');
    }

    $(insurancesId).parent().parent().parent().find('.readonly_field').show();
    $.each($(insurancesId+' option:selected').data(), function(i, v) {
        $(insurancesId).parent().parent().parent().find('.'+i).val(v);
    });
  }else{
    $(insurancesId).parent().parent().parent().find('.readonly_field').hide();
    $(insurancesId).parent().parent().parent().find('input:not([type=hidden],.do_not_empty),select').val('');
  }
}


/* for cancel and move tab */

 // for cancel button on every form
  $('body').on('click', '.close_form', function(e) {
      e.preventDefault();
      closeForm();
  });

  function addOldValue(){
      $("input,textarea,select").each(function(){
        if($(this).attr('type') == 'radio'){
            if ($(this).is(":checked")) {
              $(this).attr('old_value',$(this).val());
            }
        }else{
          $(this).attr('old_value',$(this).val());

        } 
      })
  }

  function closeForm(){
    if ($('.changed-input').length){
      bootbox.confirm({ 
        message: "There is some unsaved data which will be lost if you close/reload this page. Are you sure you still want to close/reload this page?", 
        callback: function(result){  
          if (result) {
            $('input,textarea,select').removeClass('changed-input');
            window.location.href="{{ route('chw-registrations') }}";
          }
          else {
            bootbox.hideAll();
            return false;
          }
        }
      });
    }
    else {
      window.location.href="{{ route('chw-registrations') }}";
    }
  }  

  function datePickers(){
    $('.effective_datePickerInsurance').datepicker({
      autoclose: true,
      format: 'mm-dd-yyyy',
      endDate: '-0d'
    });

    $('.expiry_datePickerInsurance').datepicker({
      autoclose: true,
      format: 'mm-dd-yyyy',
      startDate: '+0d'
    });
  }
  // for tab changes

  $('#myTab2 li a.nav-link').on('click',function(e){
    if($(this).attr('data-toggle') == 'tab' && !$('.changed-input').length){
      $('#myTab li a.nav-link').removeClass('active');
    }else if($(this).attr('data-toggle') == 'tab' && $('.changed-input').length && !$(this).hasClass('active')){
      e.preventDefault();
      bootbox.alert("{{ trans('message.unsaved_error_message') }}");
      return false;
    }else{
      e.preventDefault();
    }
  });

  $('#myTab li a.nav-link').on('click',function(e){
      if($(this).attr('data-toggle') == 'tab' && !$('.changed-input').length){
        $('#myTab2 li a.nav-link').removeClass('active');
      }else if($(this).attr('data-toggle') == 'tab' && $('.changed-input').length && !$(this).hasClass('active')){
      e.preventDefault();
      bootbox.alert("{{ trans('message.unsaved_error_message') }}");
      return false;
    }else{
      e.preventDefault();
    }
  });

  // for all keyup,keydown, change for every input field

  $('body').on('change keyup keydown', 'input, textarea, select', function (e) {
    if($(this).attr("old_value") == $(this).val() && $(this).attr('type') != 'checkbox'){
        $(this).removeClass('changed-input');
    }
    else if($(this).attr('type') == 'checkbox'){
        if($(this).is(":checked") && $(this).attr("old-data") == 'jcf-checked'){
          $(this).removeClass('changed-input');
        }
        else if(!$(this).is(":checked") && $(this).attr("old-data") == 'jcf-unchecked'){
          $(this).removeClass('changed-input');
        }
        else {
          $(this).addClass('changed-input');
        }     
    }
    /*else if($(this).attr("name") != 'comment') {
        $(this).addClass('changed-input');
    }*/
    else {
        $(this).addClass('changed-input');
    }
    
    //for radio button changes alert
    if($(this).attr('type') == 'radio'){
      if($(this).attr("old_value") == $(this).val()){
          $(this).removeClass('changed-input');
          $('input[name="'+$(this).attr("name")+'"]').removeClass('changed-input');
      }
      else{
        $(this).addClass('changed-input');
      }
    }    
  });

  // for click on side bar or logout button
  $(document).on('click','#menu-drop li a,.profilediv .dropdown-item',function(e){
    if ($('.changed-input').length){
      bootbox.alert("{{ trans('message.unsaved_error_message') }}");
      return false;
    }
  });

  // for tooltip
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

 // touch issue



  $(document).on("click touchend", '.assignment_action_btn', function(e) { 
      e.preventDefault();
      assignItem($(this).data('type'), $(this).data('type_id'), $(this).data('id'));
  });

   $(document).on("click touchend", '.assignment_view_btn', function(e) { 
      e.preventDefault();
      viewRespectiveType($(this), $(this).data('type'));
  });

  </script>
@endsection  
