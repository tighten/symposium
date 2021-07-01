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

new Vue({
    el: "#app",
});

// jQuery bindings
$(function() {
    $('[data-confirm]').on('click', function( e ) {
        if (! confirm($(this).attr('data-confirm'))) {
            e.preventDefault();
            e.cancelBubble = true;
        }
    });

    $('[data-toggle=collapse]').on('click', function( e ) {
        var target = $(this).attr('data-target');

        e.preventDefault();

        $(target).toggle();
    });

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

    $('.bio-modal').on('shown.bs.modal', function () {
        $(this).find('textarea').focus();
    });

    $('[data-clipboard]').each(function (i, element) {
        $(element).tooltip({
            trigger: 'manual',
            placement: 'bottom',
            title: 'Copied!'
        });

        var client = new ZeroClipboard(element);
        client.on("ready", function(readyEvent) {
            client.on("aftercopy", function(event) {
                $(element).tooltip('show');
                setTimeout(function () {
                    $(element).tooltip('hide');
                }, 800);
            } );
        });
    });
});
