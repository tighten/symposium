<template>
    <div>
        <slot :lookup="lookup" @keydown.enter.prevent></slot>
        <input type="hidden" name="latitude" v-model="latitude">
        <input type="hidden" name="longitude" v-model="longitude">
    </div>
</template>

<script>
export default {
    name: 'LocationLookup',
    data() {
        return {
            latitude: '',
            longitude: '',
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
            });
        },
    },
};
</script>
