<template>
    <FullCalendar :options="calendarOptions" />
</template>

<script>
import '@fullcalendar/core/vdom';
import FullCalendar from '@fullcalendar/vue';
import dayGridPlugin from '@fullcalendar/daygrid'

export default {
    name: 'conference-calendar',
    props: {
        events: {
            type: Array,
            required: true,
        },
    },
    components: {
        FullCalendar,
    },
    data() {
        return {
            colors: {
                'conference': '#428bca',
                'cfp-opening': '#F39C12',
                'cfp-closing': '#E74C3C',
            }
        };
    },
    computed: {
        calendarOptions() {
            return {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay',
                },
                dayMaxEvents: true,
                plugins: [
                    dayGridPlugin,
                ],
                initialView: 'dayGridMonth',
                events: this.formattedEvents,
            };
        },
        formattedEvents() {
            return this.events.map(event => {
                return {
                    id: event.id,
                    title: event.title,
                    start: event.start,
                    end: event.end,
                    url: event.url,
                    allDay: true,
                    color: this.colors[event.type],
                };
            });
        },
    },
}
</script>
