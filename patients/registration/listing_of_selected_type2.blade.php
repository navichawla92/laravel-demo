<div class="clearfix listing_of_selected_type2" style="display:none;"></div>
<div class="cl listing_of_selected_type2" style="display:none;">
   <div class="care-box">
      <div class="care-section show-care listing_of_selected_type_section">
         <h3>
            <span>Choose Rehab </span>
            <a data-toggle="modal" onClick="addNewItem('add_new_type2')">
               <i class="fa fa-plus"></i>  {{ trans('label.add_new') }}
            </a>            
         </h3>
         <div class="care-search-section">
            <div class="row">
               <div class="col-md-6">
                  <div class="buttonsbottom listing_back">
                     <a onClick="hideListingShowmedicareTab()" class="close   ">
                        <i class="fas fa-arrow-left"></i>  {{ trans('label.back') }}
                     </a>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="care-search">
                     <input type="text" name="search" class="form-control" placeholder="Search by Org. Name/Phone" value="{{ $search_string }}">
                     <i style="display:none;" class="fa fa-times" onClick="getRespectiveListing('rehab', 'listing_of_selected_type2', 'Choose Rehab', 'no', 'Add Rehab', 'View Rehab')"></i>
                     <button onClick="getRespectiveListing('rehab', 'listing_of_selected_type2', 'Choose Rehab', 'yes')" class="btn btn-primary">{{ trans('label.search') }}</button>
                  </div>
               </div>
            </div>
         </div>
        @include('chw.patients.registration.table_of_listing_type2')
      </div>
   </div>
</div>
@include('chw.patients.registration.add_new_type2')