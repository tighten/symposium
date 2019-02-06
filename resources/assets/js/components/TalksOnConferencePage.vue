<template>
    <div>
        <h3>My Talks</h3>
        <strong>Accepted to speak at this conference</strong>
        <ul class="conference-talk-submission-sidebar">
            <li v-for="talk in talksAccepted" v-cloak>
                <a class="btn btn-xs btn-success" disabled>
                    <i v-show="talk.loading" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                    <i v-show="!talk.loading" class="glyphicon checked"></i>
                    Accepted!
                </a>
                <a class="btn btn-xs btn-danger" @click.prevent="undoAcceptance(talk)">
                    <i v-show="talk.loading" class="glyphicon glyphicon- glyphicon-refresh-animate"></i>
                    Undo
                </a>
                <a :href="talk.url">{{ talk.title }}</a>
            </li>
            <li v-if="talksAccepted.length === 0" v-cloak>
                None
            </li>
        </ul>
        <strong>Applied to speak at this conference</strong>
        <ul class="conference-talk-submission-sidebar">
            <li v-for="talk in talksSubmitted" v-cloak>
                <a class="btn btn-xs btn-success" @click.prevent="markAccepted(talk)">
                    <i v-show="talk.loading" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                    <i v-show="!talk.loading" class="glyphicon checked"></i>
                    Mark Accepted
                </a>
                <a class="btn btn-xs btn-default" @click.prevent="unsubmit(talk)">
                    <i v-show="talk.loading" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                    Un-Submit
                </a>
                <a :href="talk.url">{{ talk.title }}</a>
            </li>
            <li v-if="talksSubmitted.length === 0" v-cloak>
                None
            </li>
        </ul>

        <strong>Not applied to speak at this conference</strong>
        <ul class="conference-talk-submission-sidebar">
            <li v-for="talk in talksNotSubmitted" v-cloak>
                <a class="btn btn-xs btn-primary" @click.prevent="submit(talk)">
                    <i v-show="talk.loading" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                    Mark Submitted
                </a>
                <a :href="talk.url">{{ talk.title }}</a>
            </li>
            <li v-if="talksNotSubmitted.length === 0" v-cloak>
                None
            </li>
        </ul>
    </div>
</template>

<script>
const SUBMITTED = "submitted";
const UNSUBMITTED = "unsubmitted";

export default {
    mounted: function () {
        Symposium.talks.forEach(talk => talk.loading = false);
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
        talksSubmitted: function(){ return this.talks.filter(({ submitted }) => submitted) },
        talksAccepted: function(){ return this.talks.filter(({ accepted }) => accepted ) },
        talksNotSubmitted: function(){ return this.talks.filter(({ accepted, submitted }) => !accepted && !submitted) },
    },
    methods: {
        updateSubmission: function (talk, status) {
            talk.loading = true;
            const data = {
                conferenceId: this.conferenceId,
                talkId: talk.id,
            };

            switch(status){
                case SUBMITTED:
                    axios.post('/submissions', data)
                        .then(response => {
                            talk.submissionId = response.data.submissionId;
                            talk.submitted = true;
                            talk.loading = false;
                        })
                        .catch(() => {
                            alert('Something went wrong.');
                            talk.loading = false;
                        });
                    break;
                case UNSUBMITTED:
                    axios.delete(`/submissions/${talk.submissionId}`)
                        .then(() => {
                            talk.submitted = false;
                            talk.submissionId = null;
                            talk.loading = false;
                        })
                        .catch(() => {
                            alert('Something went wrong.');
                            talk.loading = false;
                        });
                    break;
            }
        },
        submit: function (talk) {
            this.updateSubmission(talk, SUBMITTED);
        },
        unsubmit: function (talk) {
            this.updateSubmission(talk, UNSUBMITTED);
        },
        markAccepted: function (talk) {
            axios.post('/acceptances', { submissionId: talk.submissionId })
                .then((response) => {
                    talk.accepted = true;
                    talk.submitted = false;
                    talk.loading = false;
                    talk.acceptanceId = response.data.acceptanceId;
                })
                .catch(() => {
                    alert('Something went wrong.');
                    talk.loading = false;
                });
        },
        undoAcceptance: function (talk) {
            axios.delete(`/acceptances/${talk.acceptanceId}`, { submissionId: talk.submissionId })
                .then(() => {
                    talk.accepted = false;
                    talk.submitted = true;
                    talk.loading = false;
                })
                .catch(() => {
                    alert('Something went wrong.');
                    talk.loading = false;
                });
        }
    },
    http: {
        root: '/'
    }
};
</script>
