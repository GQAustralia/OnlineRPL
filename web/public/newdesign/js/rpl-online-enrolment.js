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
        $(document).on('click', this.elems,function(){
            var country_list = $(this).closest('.intl-tel-input').find('.country-list')
            country_list.removeClass('hide');
            $('header, .wizard-steps').addClass('has-country-code');

            $(this).keypress(function(){
                country_list.addClass('hide');
                $('header, .wizard-steps').removeClass('has-country-code');
            })
        })
    },
    build: function(){
        INIT_COUNTRY_CODE.init();
        INIT_COUNTRY_CODE.click();
    }
}

// init bootstrap datepicker
var INIT_DATEPICKER = {
    elem: $('#birthday'),
    init: function(){
        this.elem.datetimepicker({
            'format' : 'DD/MM/YYYY'
        })
    },
    build: function(){
        INIT_DATEPICKER.init(); 
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
