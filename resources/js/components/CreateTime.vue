<template>
    <div class="modal fade" ref="modal" id="create-time" tabindex="-1" role="dialog" aria-labelledby="create-time-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create-time-label">New Time Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Project</label>
                            <select class="custom-select" v-model="project">
                                <option :value="null">Select</option>
                                <option disabled>--</option>
                                <option v-for="project in projects" :value="project.id">{{ project.name }}</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label>Activity</label>
                            <select class="custom-select" v-model="activity">
                                <option :value="null">Select</option>
                                <option disabled>--</option>
                                <option v-for="activity in activities" :value="activity.id">{{ activity.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Task description</label>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">{{ isPreviousTime ? 'Save' : 'Start timer' }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                projects: [],
                activities: [],

                // Form
                project: null,
                activity: null,
                description: '',
                isPreviousTime: false,
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
            reset() {
                this.project = null;
                this.activity = null;
                this.description = '';
                this.isPreviousTime = false;
                this.date = this.formatDate(new Date());
                this.started = '';
                this.finished = '';
            },
            onModalHide(event) {
                if (event.target !== this.$refs.modal) {
                    return;
                }
                this.reset();
            },
        },
        async created() {
            jQuery(document).on('hidden.bs.modal', this.onModalHide);
            const [ projects, activities ] = await Promise.all([
                axios.get(this.$root.route('api.projects.index')),
                axios.get(this.$root.route('api.activities.index')),
            ]);
            if (projects.data) {
                this.projects = projects.data;
            }
            if (activities.data) {
                this.activities = activities.data;
            }
        },
        beforeDestroyed() {
            jQuery(document).off('hidden.bs.modal', this.onModalHide);
        },
    }
</script>
