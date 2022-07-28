window.Vue = require('vue').default;
window.axios = require('axios').default;

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Symposium.token,
    'X-Requested-With': 'XMLHttpRequest'
};

import Vue from 'vue';

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'talks-on-conference-page',
    require('./components/TalksOnConferencePage.vue').default
);

Vue.component(
    'location-lookup',
    require('./components/LocationLookup.vue').default
);

Vue.component(
    'main-header',
    require('./components/MainHeader.vue').default
);

Vue.component(
    'conference-calendar',
    require('./components/ConferenceCalendar.vue').default
);

Vue.component(
    'cfp-fields',
    require('./components/CfpFields.vue').default
);

Vue.component(
    'ModalToggle',
    require('./components/ModalToggle.vue').default
);

Vue.component(
    'SpeakerPackage',
    require('./components/SpeakerPackage.vue').default
);

Vue.component(
    'UpdateQueryString',
    require('./components/UpdateQueryString.vue').default
);

new Vue({
    el: "#app",
});

// jQuery bindings
$(function() {
    $('[data-dismiss=timeout]').each(function() {
        var timeout_len = 2000,
            $dismiss_target = $(this);

        setTimeout(function() {
            $dismiss_target.slideToggle()
        }, timeout_len);
    });

    $('input[type=date]').pickadate({
        format: 'yyyy-mm-dd'
    });
});
