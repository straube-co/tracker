<template>
    <div class="modal fade" ref="modal" id="edit-activity" tabindex="-1" role="dialog" aria-labelledby="edit-activity-label" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit.prevent="onSubmit">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-activity-label">Edit Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Name</label>
                            <input :class="{ 'form-control': true, 'is-invalid': error('name') }" type="text" v-model="name" />
                            <span v-if="error('name')" class="invalid-feedback" role="alert">
                                {{ error('name') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" :disabled="isSubmitting">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isSubmitting: false,
                errors: {},

                // Form
                id: null,
                name: '',
            }
        },
        methods: {
            reset() {
                this.isSubmitting = false;
                this.errors = {};

                this.id = null;
                this.name = '';
            },
            error(name) {
                if (!this.errors || !this.errors[name]) {
                    return null;
                }
                return this.errors[name].join(' ');
            },
            onEdit(activity) {
                this.reset();

                this.id = activity.id;
                this.name = activity.name;

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
                            name: this.name,
                        };
                        await axios.put(this.$root.route('api.activities.update', this.id), data);
                        this.isSubmitting = false;
                        jQuery(this.$refs.modal).modal('hide');
                        location.reload();
                    } catch (e) {
                        this.isSubmitting = false;
                        if (e.response && e.response.data && e.response.data.errors) {
                            this.errors = e.response.data.errors;
                            return;
                        }
                        this.$root.alert('Something went wrong while saving the activity. Please check the info you provided and try again.');
                    }
                })();
            },
        },
        created() {
            jQuery(document).on('hidden.bs.modal', this.reset);
            this.$root.$on('activity-edit', this.onEdit);
        },
        beforeDestroyed() {
            jQuery(document).off('hidden.bs.modal', this.reset);
        },
    }
</script>
