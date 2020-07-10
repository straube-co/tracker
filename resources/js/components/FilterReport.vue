<template>
    <form class="card-body" @submit.prevent="onSubmit" @change="canSave = false">
        <h5>Custom filter</h5>
        <div class="form-row">
            <div class="form-group col">
                <label for="report-project_id">Project</label>
                <select class="custom-select" id="report-project_id" v-model="project_id">
                    <option :value="null">Select</option>
                    <option disabled>--</option>
                    <option v-for="project in projects" :value="project.id">
                        {{ project.name }}
                    </option>
                </select>
            </div>
            <div class="form-group col">
                <label for="report-activity_id">Activity</label>
                <select class="custom-select" id="report-activity_id" v-model="activity_id">
                    <option :value="null">Select</option>
                    <option disabled>--</option>
                    <option v-for="activity in activities" :value="activity.id">
                        {{ activity.name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="report-user_id">User</label>
                <select class="custom-select" id="report-user_id" v-model="user_id">
                    <option :value="null">Select</option>
                    <option disabled>--</option>
                    <option v-for="user in users" :value="user.id">
                        {{ user.name }}
                    </option>
                </select>
            </div>
            <div class="form-group col">
                <label for="report-started">From</label>
                <date-input class="form-control" id="report-started" v-model="started"></date-input>
            </div>
            <div class="form-group col">
                <label for="form-finished">To</label>
                <date-input class="form-control" id="report-finished" v-model="finished"></date-input>
            </div>
        </div>
        <div class="text-right">
            <template v-if="filter">
                <button class="btn btn-link" @click="location = location.pathname">Reset</button>
                <button v-if="canSave" type="button" class="btn btn-primary" @click="onSave">Save</button>
            </template>
            <button type="submit" class="btn btn-primary ml-auto" :disabled="isSubmitting">Apply</button>
        </div>
    </form>
</template>

<script>
    export default {
        props: [
            'filter',
        ],
        data() {
            return {
                isSubmitting: false,
                canSave: true,
                errors: {},
                projects: [],
                activities: [],
                users: [],

                // Form
                project_id: this.input('project_id'),
                activity_id: this.input('activity_id'),
                user_id: this.input('user_id'),
                started: this.input('started', ''),
                finished: this.input('finished', ''),
            }
        },
        methods: {
            reset() {
                this.isSubmitting = false;
                this.errors = {};

                this.project_id = null;
                this.activity_id = null;
                this.user_id = null;
                this.started = '';
                this.finished = '';
            },
            input(name, def = null) {
                return this.filter && this.filter[name] ? this.filter[name] : def;
            },
            error(name) {
                if (!this.errors || !this.errors[name]) {
                    return null;
                }
                return this.errors[name].join(' ');
            },
            getParams() {
                const params = {};
                [
                    'project_id',
                    'activity_id',
                    'user_id',
                    'started',
                    'finished',
                ].forEach((name) => {
                    if (!this[name]) {
                        return;
                    }
                    params[name] = this[name];
                });
                return params;
            },
            onSave() {
                this.$root.$emit('create-report',this.getParams());
            },
            onSubmit() {
                this.isSubmitting = true;
                this.errors = {};

                // TODO: Maybe validate filters before submitting?
                //       Or only do it on the back-end?

                const args = [];
                const params = this.getParams();
                Object.keys(params).forEach((key) => {
                    args.push(encodeURIComponent(`filter[${key}]`) + '=' + encodeURIComponent(params[key]));
                });
                location = location.pathname + '?' + args.join('&');
            },
        },
        async created() {
            const [ projects, activities, users ] = await Promise.all([
                axios.get(this.$root.route('api.projects.index')),
                axios.get(this.$root.route('api.activities.index')),
                axios.get(this.$root.route('api.users.index')),
            ]);
            if (projects.data) {
                this.projects = projects.data;
            }
            if (activities.data) {
                this.activities = activities.data;
            }
            if (users.data) {
                this.users = users.data;
            }
        },
    }
</script>
