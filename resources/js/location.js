var autocomplete;
var componentForm = {
    neighborhood: 'long_name', // neighborhood within borough (Williamsburg)
    sublocality_level_1: 'long_name', // borough within city (Brooklyn)
    locality: 'long_name', // city (New York, Los Angeles)
    administrative_area_level_1: 'short_name', // state (NY, CA)
    country: 'short_name', // country (US)
};

function initAutocomplete() {
    var input = document.getElementById('autocomplete');

    autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', fillPlaceData);

    // Prevent submitting account form when selecting location
    input.addEventListener("keypress", function(event){
        if (event.which == '13') {
            event.preventDefault();
        }
    });
}

function fillPlaceData() {
    var place = autocomplete.getPlace();
    clearComponents();
    if(place.address_components) {
        place.address_components.forEach(setComponentInput);
    }
}

function clearComponents() {
    for (var component in componentForm) {
        document.getElementById(component).value = '';
    }
}

function setComponentInput(component) {
    var addressType = component.types[0];
    if (componentForm[addressType]) {
        var val = component[componentForm[addressType]];
        document.getElementById(addressType).value = val;
    }
}
