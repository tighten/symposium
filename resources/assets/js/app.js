if (window.Vue === undefined) {
    window.Vue = require('vue');
}

Vue.use(require('vue-resource'));
Vue.http.options.emulateJSON = true;

new Vue({
    el: '#talks-on-conference-page',
    ready: function () {
        talks.forEach(function (talk) {
            talk.loading = false;
        });
        this.$set('talks', talks);
    },
    props: {
        conferenceId: {}
    },
    data: {
        talks: []
    },
    computed: {
        talksAtConference: function () {
            return this.talks.filter(function (talk) {
                return talk.atThisConference;
            });
        },
        talksNotAtConference: function () {
            return this.talks.filter(function (talk) {
                return ! talk.atThisConference;
            });
        },
    },
    methods: {
        changeSubmissionStatus: function (talk, submitting) {
            talk.atThisConference = submitting;
            talk.loading = true;

            var data = {
                'conferenceId': this.conferenceId,
                'talkId': talk.id
            };

            var method = submitting ? 'post' : 'delete';

            this.$http[method]('/submissions', data, function (data, status, request) {
                talk.loading = false;
            }).error(function (data, status, request) {
                alert('Something went wrong.');
                talk.loading = false;
            });
        },
        submit: function (talk) {
            this.changeSubmissionStatus(talk, true);
        },
        unsubmit: function (talk) {
            this.changeSubmissionStatus(talk, false);
        },
    },
    http: {
        root: '/'
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
