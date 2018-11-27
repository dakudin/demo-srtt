/**
 * Created by Monk on 01.07.2018.
 */

//group add limit
var maxGroup = 4,
    roomCount = 1,
    childAgeCount = 0;

function storeSkiingFields()
{
    if(typeOf(Storage) === "undefined")
        return;

    localStorage.setItem("name", $('#quote-country').val());
    localStorage.setItem("name", $('#quote-city').val());
    localStorage.setItem("name", $('#quote-airport').val());
    localStorage.setItem("name", $('#quote-flight-category').val());
    localStorage.setItem("name", $('#quote-date').val());
    localStorage.setItem("name", $('#quote-duration').val());
    localStorage.setItem("name", $('#quote-budget').val());
    localStorage.setItem("name", $('#quote-details').val());

    localStorage.setItem("name", $('#user-title').val());
    localStorage.setItem("name", $('#user-first-name').val());
    localStorage.setItem("name", $('#user-last-name').val());
    localStorage.setItem("name", $('#user-email').val());
    localStorage.setItem("name", $('#user-phone').val());

    localStorage.setItem("name", $('#user-address-street').val());
    localStorage.setItem("name", $('#user-address-town').val());
    localStorage.setItem("name", $('#user-address-county').val());
    localStorage.setItem("name", $('#user-address-postcode').val());
}

function addListeners()
{
    //group add limit
    var form = $('.quote-form'),
        myDetails = form.find('.quote-form__my-details input'),
//        regionDrop = $("[data-trigger=region-drop]"),
        countrySkiDrop = $("[data-trigger=dep-drop]");
        regionDrop = $("[data-trigger=region-drop]"),
        countryDrop = $("[data-trigger=country-drop]");


    $("#quote-form").on("click", "button.btn-number", function(e){
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');

        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {

                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                    if(input.attr('data-field') == "childCount") {
                        removeChildAgeField(input);
                    }
                }
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                    if(input.attr('data-field') == "childCount"){
                        addChildAgeField(input);
                    }
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });

    // input number with plus and mines
    $("#quote-form").on("focusin", ".input-number", function(){
        $(this).data('oldValue', $(this).val());
    });

    $("#quote-form").on("change", ".input-number", function(){
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
    });

    $("#quote-form").on("keydown", ".input-number", function(){

        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    //add more fields group
    $(".addMoreRoom").click(function(){
        if($("body").find('.fieldGroup').length < maxGroup){
            var fieldHTML = '<div class="panel panel-default fieldGroup">'+$(".fieldGroupCopy").html()+'</div>';
            roomCount++;
//            fieldHTML = fieldHTML.replace('roomNumberValue', roomCount.toString());
            fieldHTML = fieldHTML.split('TravelQuote[room][][adult]').join('TravelQuote[room]['+roomCount+'][adult]');
            fieldHTML = fieldHTML.split('TravelQuote[room][][child]').join('TravelQuote[room]['+roomCount+'][child]');
            fieldHTML = fieldHTML.split('data-room=""').join('data-room="'+roomCount+'"');

            $('body').find('.fieldGroup:last').after(fieldHTML);

            $(".roomNumber").each(function (index){
                $(this).html(index+1);
            });
        }else{
            alert('Maximum '+maxGroup+' rooms are allowed.');
        }
    });

    //remove room fields group
    $("body").on("click",".roomRemove",function(){
        $(this).parents(".fieldGroup").remove();

        $(".roomNumber").each(function (index){
            $(this).html(index+1);
        });
    });

    form.on('afterValidate', formAfterValidateHandler);

    myDetails.change(myDetailChangeHandler);

//    countrySkiDrop.change(countryChangeHandler);
//    countryDrop.change(dropdownChangeHandler);
//    regionDrop.change(dropdownChangeHandler);
}

//add more fields child age control
function addChildAgeField(inputField){
    inputField.parents(".fieldGroup").find('.fieldGroup:last');

    childAgeCount++;
    roomNumber = inputField.attr("data-room");
    var fieldHTML = '<div class="fieldChildAge">'+$(".fieldChildAgeCopy").html()+'</div>';
    fieldHTML = fieldHTML.split('TravelQuote[room][][childage]').join('TravelQuote[room]['+roomNumber+'][childage]['+childAgeCount+']');

    inputField.parents(".fieldGroup").find('.fieldChildAge:last').after(fieldHTML);
}

function removeChildAgeField(inputField){
    inputField.parents(".fieldGroup").find('.fieldChildAge:last').remove();
}
/*
function dropdownChangeHandler(){
    var data = {};
    data[$(this).attr("data-name")] = $(this).val();
    data['company-ids'] = $('#company-ids').val();
    data['show-any-value'] = $('#show-any-value').val();

    if($(this).attr("data-parent")){
        var parent = $($(this).attr("data-parent"));
        data[parent.attr("data-name")] = parent.val();
    }

    var target = $(this).attr("data-target");

    $.post(
        $(this).attr("data-url"),
        data,
        function( response ) {
            var slct = $(target);
            slct.empty();

            var items = "";
            $.each( response, function( key, val ) {
                items += "<option value='" + val['id'] + "'>" + val['name'] + "</option>";
            });
            $(items).appendTo( slct );
            slct.change();
            slct.multiselect('rebuild');
        }
    );
}
*/
function myDetailChangeHandler()
{
    var checkbox = $('.quote-form__my-details input'),
        value = checkbox.prop('checked'),
        submit = $('.quote-form :submit');

    if (value)
        submit.removeAttr('disabled');
    else
        submit.attr('disabled', 'disabled');
}

function compare(a,b) {
    if (a.name < b.name)
        return -1;
    if (a.name > b.name)
        return 1;
    return 0;
}
/*
function countryChangeHandler(){
    var data = {};
    data[$(this).attr("data-name")] = $(this).val();
    data['company-ids'] = $('#company-ids').val();
    data['show-any-value'] = $('#show-any-value').val();

    var target = $(this).attr("data-target");

    $.post(
        $(this).attr("data-url"),
        data,
        function( response ) {
            var slct = $(target);
            slct.empty();

            var items = "";
            $.each( response, function( key, val ) {
                items += "<option value='" + val['id'] + "'>" + val['name'] + "</option>";
            });
            $(items).appendTo( slct );
        }
    );
}
*/
function formAfterValidateHandler()
{
    var submit = $('.quote-form :submit'),
        container = $('.global-container');

    if (!$(this).find('.has-error').length)
    {
        submit.addClass('button_state_processing');
        container.addClass('global-container_state_overlay');
    }
}

function contentLoaded()
{
    addListeners();
    myDetailChangeHandler()
}

document.addEventListener("DOMContentLoaded", contentLoaded);
