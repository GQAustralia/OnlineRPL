$(function(){

    
    // country code
    //INIT_COUNTRY_CODE.init();
    INIT_COUNTRY_CODE.click();

    // bootstrap datepicker
    INIT_DATEPICKER.build();

    // custom collapsible fields
    CONTROL_COLLAPSE.build();

    INIT_CAROUSEL.build();
    
    /* Popover for Upload files Modal */
    $('[data-toggle="popover"]').popover();
    $('#dataPopOver').attr('data-content','<ul><li><a href="javascript:void(0)"><i class="zmdi zmdi-folder-outline"></i>My Evidence Files</a></li><li><a href="javascript:void(0)"><i class="zmdi zmdi-laptop"></i>My Computer</a></li><li><a href="javascript:void(0)"><i class="zmdi zmdi-google-drive"></i>Google Drive</a></li><li><a href="javascript:void(0)"><i class="zmdi zmdi-dropbox"></i>Drop Box</a></li><li><a href="javascript:void(0)"><i class="zmdi zmdi-cloud-outline"></i>One Drive</a></li></ul>');

    $('[data-toggle="popover"]').popover();

    // Quick fix to handle footer
    GQA_FOOTER.handle_footer();
})


$('body').on('click', function (e) {
     if ($(e.target).data('toggle') !== 'popover'
        && $(e.target).parents('.popover.in').length === 0) { 
        $('[data-toggle="popover"]').popover('hide');
        }
    });

// country code
var INIT_COUNTRY_CODE = {
    doc: $(document),
    elems: "#homeTelNumber, #workTelNumber, #mobileNumber",
    init: function(){
        $(this.elems).intlTelInput({
            preferredCountries: ['au']
        });
    },
    click: function(){
        $(document).on('click', '.flag-dropdown', function(){
            $('body').removeClass('has-country-code');
            $('#autocomplete').css('z-index', 2);
        })
    },
    build: function(){
        INIT_COUNTRY_CODE.init();
        INIT_COUNTRY_CODE.click();
    }
}

// init bootstrap datepicker
var INIT_DATEPICKER = {
    elem: $('[data-init="datepicker"]'),
    init: function(){
        var carousel = $('.carousel-inner');
        this.elem.datetimepicker({
            'format' : 'DD/MM/YYYY'
        }).on('dp.show', function(e){
            carousel.css('overflow', 'visible')
        }).on('dp.hide', function(e){
            carousel.css('overflow', 'hidden')
        })
    },
    build: function(){
        INIT_DATEPICKER.init(); 
    }
}

// control collapse behavior for fields with dependency
var CONTROL_COLLAPSE = {
    elem: $('[data-collapse]'),
    show_hide: function(){
        this.elem.on('click', function(){
            var target= $(this).data('target'),
                show = 'show',
                hide = 'hide',
                sub_target_show = $(this).data('sub-target-show'),
                sub_target_hide = $(this).data('sub-target-hide');
            if($(this).data('collapse') === show){
                $(target).collapse(show)
            }else{
                $(target).collapse(hide).find('.active').removeClass('active');
            }


            if($(this).attr('data-sub-target-show') !== undefined){
                $(sub_target_show).collapse('show');
            }else if($(this).attr('data-sub-target-hide') !== undefined){
                $(sub_target_hide).collapse('hide')
            }
        })
    },
    build: function(){
        CONTROL_COLLAPSE.show_hide();
    }
}

var INIT_CAROUSEL = {
    elem: $('#formWizardCarousel'),
    init: function(){
        this.elem.carousel().on('slide.bs.carousel', function(){
            $("body").scrollTop(0);
        })
    },
    build: function(){
        INIT_CAROUSEL.init();
    }
}

var USI_INPUT_UI = {
    usi_field: $('#usiField'),
    input: $('.pseudo-input input[type="text"]'),
    input_box_body: $('#usiInputBody'),
    pointer: 0,
    doc: $(document),
    init: function() {
        var is_valid = true;

        USI_INPUT_UI.input.on('keypress paste drop', function (event) {
            var regex = new RegExp("^[a-zA-Z0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            var len = $(this).val().length;

            console.log(key);

            if (len > 1) {
                is_valid = false;
                event.preventDefault();
                return false;
            }
            else {
                is_valid = true;
            }
            
            if (!regex.test(key)) {
                is_valid = false;
                event.preventDefault();
                return false;
            }
            else {
                is_valid = true;
                USI_INPUT_UI.move_right($(this));
            }
        });

        USI_INPUT_UI.input.on('keyup', function(event) {
            if (is_valid === true) {
                if (event.keyCode === 8) {
                    $(this).val('');
                    USI_INPUT_UI.move_left($(this));
                }
                if (event.keyCode === 37) {
                    USI_INPUT_UI.move_left($(this));
                }
                if (event.keyCode === 39) {
                    USI_INPUT_UI.move_right($(this));
                }
            }

            var str = '';

            USI_INPUT_UI.input.each(function(index) {
               str = str + $(this).val();
               USI_INPUT_UI.usi_field.val(str);
            });
        });     

        USI_INPUT_UI.input.on('focus', function(event) {
            $(this).parent().addClass('active').siblings().removeClass('active');
        });

        USI_INPUT_UI.input.on('blur', function (event) {
            $(this).parent().removeClass('active');
        });

    },
    move_left: function(obj) {
        obj.parent().prev().find('input[type="text"]').focus().select(); 
    },
    move_right: function(obj) {
         obj.parent().next().find('input[type="text"]').focus().select();
    },
    set_active: function(that) {
        that.addClass('active');
        that.siblings().removeClass('active');

        console.log(that.index());
    },
    populate: function() {
        var char = String.fromCharCode(event.keyCode).toUpperCase();
        USI_INPUT_UI.input_box.eq(USI_INPUT_UI.pointer).text(char)
        USI_INPUT_UI.usi_value[USI_INPUT_UI.pointer] = char;
        USI_INPUT_UI.input_box.eq(USI_INPUT_UI.pointer + 1)
            .addClass('active')
            .siblings().removeClass('active');

        USI_INPUT_UI.pointer = USI_INPUT_UI.pointer + 1;
    },
    build: function() {
        USI_INPUT_UI.init();
    }
}

// Autocomplete address form 
// Reference: https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform

var autocomplete, autocomplete_postal;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        {types: ['address']}
    );

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', function(){
        fillInAddress(autocomplete, '')
    });

    autocomplete_postal = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete_postal')),
        {types: ['address']}
    );

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete_postal.addListener('place_changed', function(){
        fillInAddress(autocomplete_postal, '_postal')
    });
}

function fillInAddress(autocomplete, unique) {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in componentForm) {
        if (!!document.getElementById(component + unique)) {
            document.getElementById(component + unique).value = '';
            document.getElementById(component + unique).disabled = false;
        }
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType] && document.getElementById(addressType + unique)) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType + unique).value = val;
        }
    }

    if(unique === ''){
        populateStates('country', 'state')
        var current_state = document.getElementById('administrative_area_level_1' + unique),
            all_states = document.getElementById('state'),
            new_state;
    }else{
        populateStates('country_postal', 'state_postal')
        var current_state = document.getElementById('administrative_area_level_1_postal'),
            all_states = document.getElementById('state_postal'),
            new_state;
    }

    function check_state(current_state_value){
        for(var i = 0; i < all_states.length; i++){
            if(current_state.value === all_states.options[i].value) return true;
        }
    }

    if(check_state(current_state.value)){
        all_states.value = current_state.value;
    }else{
        new_state = document.createElement('option');
        new_state.value = current_state.value;
        new_state.text = current_state.value;
        new_state.setAttribute('selected', true);
        all_states.add(new_state)
    }
    //$('#state').append('<option selected value=' + current_state + '>' + current_state + '</option>');
}
