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

            $(this).keypress(function(){
                country_list.addClass('hide')
            })
        })
    },
    build: function(){
        this.doc.ready(function(){INIT_COUNTRY_CODE.init()})
        INIT_COUNTRY_CODE.click();
    }
}
INIT_COUNTRY_CODE.build();


// Autocomplete address form 
// Reference: https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform

var autocomplete;
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
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }

    populateStates('country', 'state')

    var current_state = document.getElementById('administrative_area_level_1'),
        all_states = document.getElementById('state'),
        new_state;

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

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}