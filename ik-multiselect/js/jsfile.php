<style>
.ik_main_multiselector .ikmultiselect_selector{
    display: grid;
}
.ik_main_multiselector .ikmultiselect_selector label{
    float: left;
}
/* Cambiar color de checkbox */
.ik_main_multiselector .ikmultiselect_selector input[type="checkbox"] {
    opacity:1;
}
.ik_main_multiselector .ikmultiselect_selector input[type="checkbox"]::before {
	display: block;
	content: "";
	z-index: 9999;
	position: relative;
	top: -1px;
    left: -3px;
    float: left;
    width: 16px;
    height: 16px;
	margin-right: 5px;
	background-size: 16px 16px! important;
	background: url('<?php echo get_site_url(); ?>/wp-content/plugins/ik-multiselect/images/checkbox-unchecked.jpg');
}
.ik_main_multiselector .ikmultiselect_selector input[type="checkbox"]:checked::before {
    background: url('<?php echo get_site_url(); ?>/wp-content/plugins/ik-multiselect/images/checkbox-checked.jpg');
}
.ik_main_multiselector .ik_values_selected, .ik_main_multiselector .ikmultiselect_selector, .ik_main_multiselector .ik_multiselector_search_field, .ik_main_multiselector .ik_multiselector_search_field{
    border: 1px solid #f2f2f2;
    padding: 5px 12px;
    text-transform: capitalize;
}
.ik_main_multiselector .ik_values_selected, .ik_main_multiselector .ikmultiselect_selector{
    min-width: 220px;
    min-height: 30px;
}
.ik_main_multiselector .ik_values_selected span, .ik_main_multiselector .ikmultiselect_selector label{
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
    -khtml-user-select: none; /* Konqueror HTML */
    -moz-user-select: none; /* Old versions of Firefox */
    -ms-user-select: none; /* Internet Explorer/Edge */
    user-select: none;
}
.ik_main_multiselector .ik_values_selected, .ik_main_multiselector .ikmultiselect_selector label{
    cursor: pointer;
    width: 100%;
}
.ik_main_multiselector .ik_values_selected:after{
    content: url('<?php echo get_site_url(); ?>/wp-content/plugins/ik-multiselect/images/arrow-multiple.png');
    float: right;
}
.ik_main_multiselector .ik_values_selected.ik_multiselector_open:after{
    transform: rotate(180deg);
}
.ik_main_multiselector .ikmultiselect_selector {
    display: none;
    float: left;
    position: absolute;
    background: #fff;
    z-index: 9999999999999999999999;
}
.ik_main_multiselector .ikmultiselect_selector .ik_options_multiple{
    overflow-y: scroll;
    max-height: 210px;
}
.ik_main_multiselector .ik_multiselector_search_field{
    width: 100%! important;
    float: unset! important;
}
.ik_main_multiselector .ik_multiselector_searchbox{
    padding-bottom: 7px;
}
.ik_main_multiselector .ik_options_multiple input[type=checkbox] {
    margin: 2px! important;
    width: 15px! important;
    position: relative;
    top: 3px! important;
    left: 0! important;
}
.ik_main_multiselector .ik_values_selected span {
    display: inline-block! important;
    margin: 0! important;
}
</style>
<script>
function ik_selectMultiple(select){
    
    //I define the ID of the selector
    if (select.attr('name') != undefined){
        var selectorElementID = select.attr('name')+'_multiselect';
        var selectorElementID = selectorElementID.replace(/[^\w\s]/gi, '');
    } else if (select.attr('id') != undefined){
        var selectorElementID = select.attr('id')+'_multiselect';
    } else {
        var selectorElementID = select.attr('class')+'_multiselect';
    }
    
    //I define the initial value for the multiple select
    if (select.find('option:selected') != undefined){
        var valueInitial = select.find('option:selected').text();
    } else if (select.val() != undefined){
        var valueInitial = select.val();
    } else {
        var valueInitial = select.find('option:first-child').text();
    }
    
    var selector_multi = '<div id="'+selectorElementID+'" class="ik_main_multiselector" style="width:'+select.width()+'px"><div class="ik_values_selected" toggle="close"><span>'+valueInitial+'</span></div><div class="ikmultiselect_selector" style="width:'+select.width()+'px;"><div class="ik_options_multiple"></div></div></div>';
    select.attr('style','display: none');
    select.attr('multiple', true);
    jQuery(selector_multi).insertAfter(select);
    //I append select all
	jQuery('<label><input type="checkbox" class="ik_multiselect_selectall"><span>Select All</span></label>').appendTo('#'+selectorElementID+' .ikmultiselect_selector .ik_options_multiple');
    select.find('option').each(function() {
        if (jQuery(this).val() != undefined && jQuery(this).val().length != 0 && jQuery(this).text() != ''){
            var options_multipleselect = '<label><input type="checkbox" value="'+jQuery(this).val()+'"><span>'+jQuery(this).text()+'</span></label>'
            jQuery(options_multipleselect).appendTo('#'+selectorElementID+' .ikmultiselect_selector .ik_options_multiple');
        }
    });
    
    //I add the search bar
    jQuery('<div class="ik_multiselector_searchbox"><input type="text" class="ik_multiselector_search_field" placeholder="Search Option" /></div>').prependTo('#'+selectorElementID+' .ikmultiselect_selector');
        //if value is not disabled then I check it on multiselector
    if(jQuery(select.find('option:selected')).prop('disabled') == false && jQuery(select.find('option:selected')).val() != undefined){
        jQuery('#'+selectorElementID+' .ikmultiselect_selector input[value='+valueInitial+']').attr('checked', true);
    }
}

//Check or unchecks and adds or removes a value from select
jQuery(document.body).on('change', '.ik_main_multiselector .ik_options_multiple input' ,function(){
    var optionToCheck = jQuery(this).parent().parent().parent().parent().parent().find('select option[value="'+jQuery(this).val()+'"]');
    if(optionToCheck.is(':selected')) {
        optionToCheck.attr('selected', false);
    } else {
        optionToCheck.attr('selected', true);
    }
});

//Multiple selector searcher of options
jQuery(document.body).on('keyup keydown keypress change', '.ik_main_multiselector .ik_multiselector_search_field' ,function(){
    ik_search_in_multiselect(this);
});

//Search option in multiselect
function ik_search_in_multiselect(thisInput){
    var optionsToSearch = jQuery(thisInput).parent().parent().find('.ik_options_multiple label span');
    var valueInput = jQuery(thisInput).val().toLowerCase();
    if(valueInput.length > 0){
        jQuery(optionsToSearch).parent().attr('style', 'display: block;');
        optionsToSearch.each(function() {
            if (!jQuery(this).text().toLowerCase().includes(valueInput)){
                jQuery(this).parent().fadeOut(400);
                jQuery(this).parent().attr('style', 'display: none! important');
            }
        });
    } else {
        jQuery(optionsToSearch).parent().attr('style', 'display: block;');
    }
}


//Opens and closes multiselector when clicking the select box
jQuery(document.body).on('click', '.ik_values_selected' ,function(){
    ik_multiselect_openclose(this);
}); 

//function to open and close multiselect
function ik_multiselect_openclose(multiselect){
    if (jQuery(multiselect).attr('toggle') == 'close'){
        //First I close all multi selectors and delete any possible search input filled up
        jQuery('.ik_main_multiselector .ik_values_selected').attr('toggle', 'close');
        jQuery('.ik_main_multiselector .ik_values_selected').removeClass('ik_multiselector_open');
        jQuery('.ik_main_multiselector .ikmultiselect_selector').fadeOut(400);
        jQuery('.ik_main_multiselector .ikmultiselect_selector .ik_multiselector_search_field').val('');

        //I open multiselector
        jQuery(multiselect).attr('toggle', 'open');
        //I add this class to change the position of the arrow
        jQuery(multiselect).addClass('ik_multiselector_open');
        jQuery(multiselect).parent().find('.ikmultiselect_selector').fadeIn(400);
    } else {
        jQuery(multiselect).attr('toggle', 'close');
        jQuery(multiselect).removeClass('ik_multiselector_open');
        jQuery(multiselect).parent().find('.ikmultiselect_selector').fadeOut(400);
        jQuery('.ik_main_multiselector .ik_options_multiple label').attr('style', 'display: block;');
    }
}

//select all when select all clicked
jQuery(document.body).on('click', '.ik_multiselect_selectall' ,function(){
	var optionToCheck = jQuery(this).parent().parent().parent().parent().parent().find('option');
	var otherInputsCheck = jQuery(this).parent().parent().find('input:checkbox');
	if (jQuery(this).attr('checkinfo') == 'yes'){
		jQuery(this).attr('checkinfo', 'no');
		optionToCheck.attr('selected', false);
		otherInputsCheck.not(this).prop('checked', false);
	} else {
		jQuery(this).attr('checkinfo', 'yes');
		optionToCheck.attr('selected', true);
		otherInputsCheck.not(this).prop('checked', 'checked');
	}
}); 

// Closes select if I click outside of it
jQuery(document).on("click", function(event){
    var $trigger = jQuery(".innerMultiselect");
    if($trigger !== event.target && !$trigger.has(event.target).length){
        jQuery('.ik_main_multiselector .ikmultiselect_selector').fadeOut(400);
        jQuery('.ik_main_multiselector .ikmultiselect_selector').parent().find('.ik_values_selected').removeClass('ik_multiselector_open');
        jQuery('.ik_main_multiselector .ikmultiselect_selector').parent().find('.ik_values_selected').attr('toggle', 'close');
        jQuery('.ik_main_multiselector .ik_options_multiple label').attr('style', 'display: block;');
    } 
});

// I start the .ik_selectMultiple when a select has the class .ikmultiselect
jQuery('body select').each(function() {
    if (jQuery(this).hasClass('ikmultiselect')){
        
        //If select2 exists I disabled it for this select
        if (jQuery.fn.select2) {
          jQuery(this).select2('enable',false);
        }
        jQuery(jQuery(this)).wrap('<div class="innerMultiselect"></div>');
        ik_selectMultiple(jQuery(this));
    }
});
</script>