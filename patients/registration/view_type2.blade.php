<div class="modal fade" id="view-details2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content info-modal">
      <div class="modal-header">
        <h4> <span class="modal_heading"></span></h4>
      </div>
      <div class="modal-body patient-info medicare-info">
        <p> {{ trans('label.org_name') }}:<span class="org_name"></span></p>
        <p> {{ trans('label.email') }}:<span class="email"></span></p>
        <p> {{ trans('label.phone_number') }}:<span class="phone"></span></p>
        <p> {{ trans('label.fax') }}:<span class="fax"></span></p>
        <p> {{ trans('label.web_address') }}:<span class="web_address"></span></p>
        <p> {{ trans('label.address_word') }}:<span class="address"></span></p>
        <p class="view_type2_label_title1">{{ trans('label.counsellor_person_title') }}:<span class="contact_title"></span> </p>
        <p class="view_type2_label_title2" style="display: none">{{ trans('label.contact_person_title') }}:<span class="contact_title"></span></p>

         <p class="view_type2_label_name1">{{ trans('label.counsellor_person_name') }}:<span class="contact_name"></span> </p>
        <p class="view_type2_label_name2" style="display: none">{{ trans('label.contact_person_name') }}:<span class="contact_name"></span></p>

         <p class="view_type2_label_email1">{{ trans('label.counsellor_person_email') }}:<span class="contact_email"></span> </p>
        <p class="view_type2_label_email2" style="display: none">{{ trans('label.contact_person_email') }}:<span class="contact_email"></span></p>

         <p class="view_type2_label_phone1">{{ trans('label.counsellor_person_phone') }}:<span class="contact_phone"></span> </p>
        <p class="view_type2_label_phone2" style="display: none">{{ trans('label.contact_person_phone') }}:<span class="contact_phone"></span></p>
      </div>
      <div class="modal-footer">
        <div class="buttonsbottom">
          <a href="#" class="close" data-dismiss="modal" aria-label="Close"> {{ trans('label.close') }} </a> </div>
        </div>
      </div>
  </div>
</div>