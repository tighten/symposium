<template>
    <div>
        <h3>My Talks</h3>
        <p><i>Note: "Submit" just means "mark as submitted." At the moment this isn't actually sending anything to the conference organizers.</i></p>
        <strong>Applied to speak at this conference</strong>
        <ul class="conference-talk-submission-sidebar">
            <li v-for="talk in talksAtConference" v-cloak>
                <a class="btn btn-xs btn-default" @click.prevent="unsubmit(talk)">
                    <i v-show="talk.loading" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                    Un-Submit
                </a>
                <a :href="talk.url">{{ talk.title }}</a>
            </li>
            <li v-if="talksAtConference.length == 0" v-cloak>
                None
            </li>
        </ul>

        <strong>Not applied to speak at this conference</strong>
        <ul class="conference-talk-submission-sidebar">
            <li v-for="talk in talksNotAtConference" v-cloak>
                <a class="btn btn-xs btn-primary" @click.prevent="submit(talk)">
                    <i v-show="talk.loading" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                    Submit
                </a>
                <a :href="talk.url">{{ talk.title }}</a>
            </li>
            <li v-if="talksNotAtConference.length == 0" v-cloak>
                None
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    ready: function () {
        Symposium.talks.forEach(function (talk) {
            talk.loading = false;
        });

        console.log(Symposium.talks);
        this.talks = Symposium.talks;
    },
    props: {
        conferenceId: {}
    },
    data: function () {
        return {
            talks: []
        };
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
};
</script>
