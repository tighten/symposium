<template>
    <div>
        <div class="text-gray-500 mt-4">Accepted to speak at this conference:</div>
        <ul class="list-none pl-0">
            <li v-for="talk in talksAccepted" v-cloak>
                <a :href="talk.url" class="hover:text-indigo-500">{{ talk.title }}</a>
                <a class="inline-block cursor-pointer mt-4 bg-white border border-indigo-500 text-indigo-500 rounded px-1 text-center" @click.prevent="undoAcceptance(talk)">
                    <div class="flex items-center">
                        <loading-spinner v-show="talk.loading" class="h-4 w-4 mr-1 border-indigo-300 text-indigo-800"></loading-spinner>
                        Undo
                    </div>
                </a>
            </li>
            <li v-if="talksAccepted.length === 0" v-cloak>
                None
            </li>
        </ul>

        <div class="text-gray-500 mt-8">Applied to speak at this conference:</div>
        <ul class="list-none pl-0">
            <li v-for="talk in talksSubmitted" v-cloak>
                <a :href="talk.url" class="hover:text-indigo-500">{{ talk.title }}</a>
                <a class="inline-block cursor-pointer mt-4 bg-indigo-500 text-white rounded px-1 text-center" @click.prevent="markAccepted(talk)">
                    <div class="flex items-center">
                        <loading-spinner v-show="talk.loading" class="h-4 w-4 mr-1 border-white text-indigo-800"></loading-spinner>
                        Mark Accepted
                    </div>
                </a>
                <a class="inline-block cursor-pointer mt-4 bg-white border border-indigo-500 text-indigo-500 rounded px-1 text-center ml-2" @click.prevent="unsubmit(talk)">
                    <div class="flex items-center">
                        <loading-spinner v-show="talk.loading" class="h-4 w-4 mr-1 border-indigo-300 text-indigo-800"></loading-spinner>
                        Un-Submit
                    </div>
                </a>
            </li>
            <li v-if="talksSubmitted.length === 0" v-cloak>
                None
            </li>
        </ul>

        <div class="text-gray-500 mt-8">Not applied to speak at this conference:</div>
        <ul class="list-none pl-0">
            <li v-for="talk in talksNotSubmitted" v-cloak>
                <a :href="talk.url" class="hover:text-indigo-500">{{ talk.title }}</a>
                <a class="inline-block cursor-pointer mt-4 bg-indigo-500 text-white rounded px-1 text-center" @click.prevent="submit(talk)">
                    <div class="flex items-center">
                        <loading-spinner v-show="talk.loading" class="h-4 w-4 mr-1 border-white text-indigo-800"></loading-spinner>
                        Mark Submitted
                    </div>
                </a>
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

import LoadingSpinner from './LoadingSpinner.vue';

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
        talksSubmitted: function(){ return this.talks.filter(({ submitted, accepted }) => submitted && !accepted) },
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

            switch (status) {
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
    components: {
        LoadingSpinner,
    },
};
</script>
