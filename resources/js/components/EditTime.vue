<template>
    <div class="modal fade" ref="modal" id="edit-time" tabindex="-1" role="dialog" aria-labelledby="edit-time-label" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit.prevent="onSubmit">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-time-label">Edit Time Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Project</label>
                            <select :class="{ 'custom-select': true, 'is-invalid': error('project_id') }" v-model="project_id">
                                <option :value="null">Select</option>
                                <option disabled>--</option>
                                <option v-for="project in projects" :value="project.id">{{ project.name }}</option>
                            </select>
                            <span v-if="error('project_id')" class="invalid-feedback" role="alert">
                                {{ error('project_id') }}
                            </span>
                        </div>
                        <div class="form-group col">
                            <label>Activity</label>
                            <select :class="{ 'custom-select': true, 'is-invalid': error('activity_id') }" v-model="activity_id">
                                <option :value="null">Select</option>
                                <option disabled>--</option>
                                <option v-for="activity in activities" :value="activity.id">{{ activity.name }}</option>
                            </select>
                            <span v-if="error('activity_id')" class="invalid-feedback" role="alert">
                                {{ error('activity_id') }}
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Task description</label>
                            <textarea :class="{ 'form-control': true, 'is-invalid': error('description') }" v-model="description" @keyup="filterDescription" @keydown.enter.prevent="() => {}"></textarea>
                            <span v-if="error('description')" class="invalid-feedback" role="alert">
                                {{ error('description') }}
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Date</label>
                            <date-input :class="{ 'form-control': true, 'is-invalid': error('date') }" v-model="date" />
                            <span v-if="error('date')" class="invalid-feedback" role="alert">
                                {{ error('date') }}
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Started at</label>
                            <time-input :class="{ 'form-control': true, 'is-invalid': error('started') }" v-model="started" />
                            <span v-if="error('started')" class="invalid-feedback" role="alert">
                                {{ error('started') }}
                            </span>
                        </div>
                        <div class="form-group col">
                            <label>Finished at</label>
                            <time-input :class="{ 'form-control': true, 'is-invalid': error('finished') }" v-model="finished" />
                            <span v-if="error('finished')" class="invalid-feedback" role="alert">
                                {{ error('finished') }}
                            </span>
                        </div>
                    </div>
                    <span v-if="error('error')" class="invalid-feedback d-block" role="alert">
                        {{ error('error') }}
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-auto" :disabled="isSubmitting" @click="onDelete">Delete</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" :disabled="isSubmitting">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    const moment = require('moment');

    export default {
        data() {
            return {
                isSubmitting: false,
                errors: {},
                projects: [],
                activities: [],

                // Form
                id: null,
                project_id: null,
                activity_id: null,
                description: '',
                date: moment().format('YYYY-MM-DD'),
                started: '',
                finished: '',
            }
        },
        methods: {
            filterDescription() {
                this.description = this.description.replace(/[\r\n]+/g, ' ');
            },
            reset() {
                this.isSubmitting = false;
                this.errors = {};

                this.id = null;
                this.project_id = null;
                this.activity_id = null;
                this.description = '';
                this.date = moment().format('YYYY-MM-DD');
                this.started = '';
                this.finished = '';
            },
            error(name) {
                if (!this.errors || !this.errors[name]) {
                    return null;
                }
                return this.errors[name].join(' ');
            },
            onEdit(time) {
                this.reset();

                const started = new Date(time.started);
                const finished = new Date(time.finished);

                this.id = time.id;
                this.project_id = time.project_id;
                this.activity_id = time.activity_id;
                this.description = time.description;
                this.date = moment(started).format('YYYY-MM-DD');
                this.started = moment(started).format('HH:mm');
                this.finished = moment(finished).format('HH:mm');

                jQuery(this.$refs.modal).modal('show');
            },
            onModalHide(event) {
                if (event.target !== this.$refs.modal) {
                    return;
                }
                this.reset();
            },
            onSubmit() {
                this.isSubmitting = true;
                this.errors = {};
                (async () => {
                    try {
                        const data = {
                            project_id: this.project_id,
                            activity_id: this.activity_id,
                            description: this.description,
                            date: this.date,
                            started: this.started,
                            finished: this.finished,
                        }
                        await axios.put(this.$root.route('api.times.update', this.id), data);
                        this.isSubmitting = false;
                        jQuery(this.$refs.modal).modal('hide');
                        location.reload();
                    } catch (e) {
                        this.isSubmitting = false;
                        if (e.response && e.response.data && e.response.data.errors) {
                            this.errors = e.response.data.errors;
                            return;
                        }
                        this.$root.alert('Something went wrong while saving the time entry. Please check the info you provided and try again.');
                    }
                })();
            },
            onDelete() {
                if (!window.confirm('Do you really want to delete this time entry. This action cannot be undone.')) {
                    return;
                }
                this.isSubmitting = true;
                (async () => {
                    try {
                        await axios.delete(this.$root.route('api.times.destroy', this.id));
                        this.isSubmitting = false;
                        jQuery(this.$refs.modal).modal('hide');
                        location.reload();
                    } catch (e) {
                        this.isSubmitting = false;
                        this.$root.alert('Something went wrong while deleting the time entry. Please try again.');
                    }
                })();
            },
        },
        async created() {
            jQuery(document).on('hidden.bs.modal', this.onModalHide);
            this.$root.$on('time-edit', this.onEdit);
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
