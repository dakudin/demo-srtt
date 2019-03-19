/**
 * Created by Monk on 01.07.2018.
 */

//group add limit
var maxGroup = 4,
    roomCount = 1,
    childAgeCount = 0;

function storeTravelFields()
{
    if(typeof Storage === "undefined")
        return;

    localStorage.clear();

    if($('#quote-country').val())
        localStorage.setItem("quoteCountry", $('#quote-country').val());
    else
        localStorage.setItem("quoteCountry", '');
    if($('#quote-city').val())
        localStorage.setItem("quoteCity", $('#quote-city').val());
    else
        localStorage.setItem("quoteCity", '');
    if($('#quote-airport').val())
        localStorage.setItem("quoteAirport", $('#quote-airport').val());
    else
        localStorage.setItem("quoteAirport", '');

    localStorage.setItem("quoteFlightCategory", $('#quote-flight-category').val());
    localStorage.setItem("quoteDate", $('#quote-date').val());
    localStorage.setItem("quoteDuration", $('#quote-duration').val());
    localStorage.setItem("quoteBudget", $('#quote-budget').val());
    localStorage.setItem("quoteDetails", $('#quote-details').val());

    localStorage.setItem("userTitle", $('#user-title').val());
    localStorage.setItem("userFirstName", $('#user-first-name').val());
    localStorage.setItem("userLastName", $('#user-last-name').val());
    localStorage.setItem("userEmail", $('#user-email').val());
    localStorage.setItem("userPhone", $('#user-phone').val());

    localStorage.setItem("userAddressStreet", $('#user-address-street').val());
    localStorage.setItem("userAddressTown", $('#user-address-town').val());
    localStorage.setItem("userAddressCounty", $('#user-address-county').val());
    localStorage.setItem("userAddressPostcode", $('#user-address-postcode').val());

    localStorage.setItem("roomCount", roomCount);
    localStorage.setItem("childAgeCount", childAgeCount);

    for(var i=1; i<=roomCount; i++) {
        localStorage.setItem("TravelQuote[room]["+i+"][adult]", $("#TravelQuote\\[room\\]\\["+i+"\\]\\[adult\\]").val());
        localStorage.setItem("TravelQuote[room]["+i+"][child]", $("#TravelQuote\\[room\\]\\["+i+"\\]\\[child\\]").val());
        for(var j=1; j<=childAgeCount; j++){
            var childAgeVal = $("#TravelQuote\\[room\\]\\["+i+"\\]\\[childage\\]\\["+j+"\\]").val();
            if(childAgeVal) {
                localStorage.setItem("TravelQuote[room][" + i + "][childage][" + j + "]", childAgeVal);
            }
        }
    }
}

function restoreTravelFields()
{
    if(typeof Storage === "undefined")
        return;

    if(!localStorage.getItem("userTitle"))
        return;

    $('#quote-country').val(localStorage.getItem("quoteCountry"));
    $('#quote-city').val(localStorage.getItem("quoteCity"));
    $('#quote-airport').val(localStorage.getItem("quoteAirport"));
    $('#quote-flight-category').val(localStorage.getItem("quoteFlightCategory"));
    $('#quote-date').val(localStorage.getItem("quoteDate"));
    $('#quote-duration').val(localStorage.getItem("quoteDuration"));
    $('#quote-budget').val(localStorage.getItem("quoteBudget"));
    $('#quote-details').val(localStorage.getItem("quoteDetails"));

    $('#user-title').val(localStorage.getItem("userTitle"));
    $('#user-first-name').val(localStorage.getItem("userFirstName"));
    $('#user-last-name').val(localStorage.getItem("userLastName"));
    $('#user-email').val(localStorage.getItem("userEmail"));
    $('#user-phone').val(localStorage.getItem("userPhone"));

    $('#user-address-street').val(localStorage.getItem("userAddressStreet"));
    $('#user-address-town').val(localStorage.getItem("userAddressTown"));
    $('#user-address-county').val(localStorage.getItem("userAddressCounty"));
    $('#user-address-postcode').val(localStorage.getItem("userAddressPostcode"));

    var prevRoomCount = localStorage.getItem("roomCount");
    var prevChildAgeCount = localStorage.getItem("childAgeCount");

    for(var i=1; i<=prevRoomCount; i++){
        if(i != 1){
            $(".addMoreRoom").click();
        }

        var adult = localStorage.getItem("TravelQuote[room]["+i+"][adult]");
        if(adult) $("#TravelQuote\\[room\\]\\["+i+"\\]\\[adult\\]").val(adult);

        var child = localStorage.getItem("TravelQuote[room]["+i+"][child]");
//        if(child) $("#TravelQuote\\[room\\]\\["+i+"\\]\\[child\\]").val(child);

        for(var j=1; j<=child; j++){
            //add child age control
            $(".btn-number[data-type='plus'][data-field='TravelQuote\\[room\\]\\["+i+"\\]\\[child\\]']").click();

            var childFound=0;
            for(var k=1; k<=prevChildAgeCount; k++) {
                var childAge = localStorage.getItem("TravelQuote[room][" + i + "][childage][" + k + "]");

                if (childAge) {
                    childFound++;
                    if (childFound == j) {
                        $("#TravelQuote\\[room\\]\\[" + i + "\\]\\[childage\\]\\[" + childAgeCount + "\\]").val(childAge);
                    }
                }
            }
        }

    }

    $("#acceptConfirm1").prop('checked',true);
    $("#acceptConfirm2").prop('checked',true);

    //submit form after authorization
    if(!$("#login-modal").length) {
//        $('.quote-form').submit();
    }
}

function addListeners()
{
    //group add limit
    var form = $('.quote-form'),
        quoteConfirmation = form.find('.quote-form__confirmation input');

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

    $("#btn-show-retailers").click(function(){
        if (!$(this).find('.has-error').length) {
            var form = $("#quote-form"),
                data = form.data("yiiActiveForm");

            $.each(data.attributes, function () {
                this.status = 3;
            });
            form.yiiActiveForm("validate");

            if (form.find(".has-error").length) {
                return false;
            }

            $("#quote-info-block").addClass("hidden");
            $("#retailer-block").removeClass("hidden");


        }
    });

    $("#btn-back").click(function(){
        $("#retailer-block").addClass("hidden");
        $("#quote-info-block").removeClass("hidden");
    });

    form.on('beforeSubmit', formBeforeSubmitHandler);

    quoteConfirmation.change(quoteChangeHandler);

    restoreTravelFields();
}

//add more fields child age control
function addChildAgeField(inputField){
    inputField.parents(".fieldGroup").find('.fieldGroup:last');

    childAgeCount++;
    var roomNumber = inputField.attr("data-room");
    var fieldHTML = '<div class="fieldChildAge">'+$(".fieldChildAgeCopy").html()+'</div>';
    fieldHTML = fieldHTML.split('TravelQuote[room][][childage]').join('TravelQuote[room]['+roomNumber+'][childage]['+childAgeCount+']');

    inputField.parents(".fieldGroup").find('.fieldChildAge:last').after(fieldHTML);
}

function removeChildAgeField(inputField){
    inputField.parents(".fieldGroup").find('.fieldChildAge:last').remove();
}

function quoteChangeHandler()
{
    var confirm = true,
        submit = $('.quote-form :submit');

    $('.quote-form__confirmation input').each(function(i,elem){
        confirm = confirm && $(elem).prop('checked');
    });

    if(!$('.m_switch_check:checkbox:checked').length){
        confirm = false;
    }

    if (confirm)
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

function formBeforeSubmitHandler()
{
    var submit = $('.quote-form :submit'),
        container = $('.global-container');

    if (!$(this).find('.has-error').length)
    {
        if($("#login-modal").length){
            storeTravelFields();
            $("#login-modal").modal("show");
            return false;
        }else {
            submit.addClass('button_state_processing');
            container.addClass('global-container_state_overlay');
            localStorage.clear();
        }

        return true;
    }
}

function contentLoaded()
{
    addListeners();
    quoteChangeHandler()
}

document.addEventListener("DOMContentLoaded", contentLoaded);
