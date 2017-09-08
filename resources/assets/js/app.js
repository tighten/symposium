if (window.Vue === undefined) {
    window.Vue = require('vue');
}

Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = Symposium.token;

import TalksOnConferencePage from './components/TalksOnConferencePage.vue';

new Vue({
    el: '#talks-on-conference-page',
    components: {
        TalksOnConferencePage: TalksOnConferencePage
    }
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
