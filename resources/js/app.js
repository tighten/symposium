window.Vue = require('vue').default;
window.axios = require('axios').default;

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Symposium.token,
    'X-Requested-With': 'XMLHttpRequest'
};

import Vue from 'vue';
import VCalendar from 'v-calendar';
import Dismiss from './directives/Dismiss';

Vue.use(VCalendar);

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
    'cfp-fields',
    require('./components/CfpFields.vue').default
);

Vue.component(
    'MenuToggle',
    require('./components/MenuToggle.vue').default
);

Vue.component(
    'ModalToggle',
    require('./components/ModalToggle.vue').default
);

Vue.component(
    'CurrencySelection',
    require('./components/CurrencySelection.vue').default
);

Vue.component(
    'UpdateQueryString',
    require('./components/UpdateQueryString.vue').default
);

Vue.directive('dismiss', Dismiss);

new Vue({
    el: "#app",
});
