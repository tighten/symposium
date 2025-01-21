<template>
    <div>
        <slot :lookup="lookup" @keydown.enter.prevent></slot>
        <input type="hidden" name="latitude" v-model="latitude">
        <input type="hidden" name="longitude" v-model="longitude">
        <input type="hidden" name="location_name" v-model="locationName">
    </div>
</template>

<script>
export default {
    name: 'LocationLookup',
    data() {
        return {
            latitude: '',
            longitude: '',
            locationName: '',
        };
    },
    methods: {
        lookup(input) {
            if (process.env.MIX_DISABLE_LOCATION_LOOKUP) {
                return;
            }

            const dropdown = new google.maps.places.Autocomplete(input.target);

            dropdown.addListener('place_changed', () => {
                const place = dropdown.getPlace();

                this.latitude = place.geometry.location.lat();
                this.longitude = place.geometry.location.lng();
                this.locationName = this.getLocationName(place.address_components);
            });
        },
        getLocationName(components) {
            const country = components.find(component => {
                return component.types.includes('country');
            })?.long_name;
            const city = components.find(component => {
                return component.types.includes('locality') ||
                    component.types.includes('postal_town');
            })?.long_name;

            const values = country === 'United States'
                ? [city, this.getState(components), country]
                : [city, country];

            return values.filter(v => v).join(', ');
        },
        getState(components) {
            return components.find(component => {
                return component.types.includes('administrative_area_level_1');
            })?.short_name;
        },
    },
};
</script>
