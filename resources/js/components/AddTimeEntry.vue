<template>
    <div>
        <div class="form-row">
            <div class="form-group col">
                <label>Project</label>
                <select class="custom-select">
                    <option>Select</option>
                    <option disabled>--</option>
                    <option v-for="project in projects" :value="project.id">{{ project.name }}</option>
                </select>
            </div>
            <div class="form-group col">
                <label>Activity</label>
                <select class="custom-select">
                    <option>Select</option>
                    <option disabled>--</option>
                    <option v-for="activity in activities" :value="activity.id">{{ activity.name }}</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label>Taks description</label>
                <textarea class="form-control" v-model="description" @keyup="filterDescription" @keydown.enter.prevent="() => {}"></textarea>
            </div>
        </div>
        <div class="form-row" v-if="!isPreviousTime">
            <div class="form-group col">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="is-previous-time" @change="isPreviousTime = true" />
                    <label class="custom-control-label" for="is-previous-time">Record previous time</label>
                </div>
            </div>
        </div>
        <div v-if="isPreviousTime">
            <div class="form-row">
                <div class="form-group col">
                    <label>Date</label>
                    <input class="form-control" type="text" v-model="date" placeholder="YYYY-MM-DD" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label>Started at</label>
                    <input class="form-control" type="text" v-model="started" placeholder="HH:MM" />
                </div>
                <div class="form-group col">
                    <label>Finished at</label>
                    <input class="form-control" type="text" v-model="finished" placeholder="HH:MM" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isPreviousTime: false,
                projects: [],
                activities: [],

                description: '',
                date: this.formatDate(new Date()),
                started: '',
                finished: '',
            }
        },
        methods: {
            filterDescription() {
                this.description = this.description.replace(/[\r\n]+/g, ' ');
            },
            formatDate(date) {
                const year = date.getFullYear().toString();
                const month = (date.getMonth() + 101).toString().substring(1);
                const day = (date.getDate() + 100).toString().substring(1);
                return year + '-' + month + '-' + day;
            },
        },
        async created() {
            const [ projects, activities ] = await Promise.all([
                axios.get(route('api.projects.index')),
                axios.get(route('api.activities.index')),
            ]);
            if (projects.data) {
                this.projects = projects.data;
            }
            if (activities.data) {
                this.activities = activities.data;
            }
        },
    }
</script>
