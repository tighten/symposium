import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Symposium.token,
    'X-Requested-With': 'XMLHttpRequest'
};

import Vue from 'vue';
import VCalendar from 'v-calendar';
import Dismiss from './directives/Dismiss';
import '../css/app.css'

Vue.use(VCalendar);

import Clients from './components/passport/Clients.vue';
import AuthorizedClients from './components/passport/AuthorizedClients.vue';
import PersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';
import TalksOnConferencePage from './components/TalksOnConferencePage.vue';
import LocationLookup from './components/LocationLookup.vue';
import CfpFields from './components/CfpFields.vue';
import MenuToggle from './components/MenuToggle.vue';
import ModalToggle from './components/ModalToggle.vue';
import CurrencySelection from './components/CurrencySelection.vue';
import UpdateQueryString from './components/UpdateQueryString.vue';

Vue.directive('dismiss', Dismiss);

new Vue({
    el: "#app",
    components: {
        'passport-clients':  Clients,
        'passport-authorized-clients':  AuthorizedClients,
        'passport-personal-access-tokens':  PersonalAccessTokens,
        'talks-on-conference-page':  TalksOnConferencePage,
        'location-lookup':  LocationLookup,
        CfpFields,
        MenuToggle,
        ModalToggle,
        CurrencySelection,
        UpdateQueryString,
    }
});
