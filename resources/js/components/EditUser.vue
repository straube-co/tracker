<template>
    <div class="modal fade" ref="modal" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="edit-user-label" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit.prevent="onSubmit">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-user-label">Edit User</h5>
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
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Email</label>
                            <input :class="{ 'form-control': true, 'is-invalid': error('email') }" type="email" v-model="email" />
                            <span v-if="error('email')" class="invalid-feedback" role="alert">
                                {{ error('email') }}
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Timezone</label>
                            <select :class="{ 'custom-select': true, 'is-invalid': error('timezone') }" v-model="timezone">
                                <option :value="null">Select</option>
                                <option disabled>--</option>
                                <option v-for="timezone in timezones" :value="timezone">{{ timezone.replace(/_/g, ' ') }}</option>
                            </select>
                            <span v-if="error('timezone')" class="invalid-feedback" role="alert">
                                {{ error('timezone') }}
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
                timezones: [],

                // Form
                id: null,
                name: '',
                email: '',
                timezone: '',
            }
        },
        methods: {
            reset() {
                this.isSubmitting = false;
                this.errors = {};

                this.id = null;
                this.name = '';
                this.email = '';
                this.timezone = '';
            },
            error(name) {
                if (!this.errors || !this.errors[name]) {
                    return null;
                }
                return this.errors[name].join(' ');
            },
            onEdit(user) {
                this.reset();

                this.id = user.id;
                this.name = user.name;
                this.email = user.email;
                this.timezone = user.timezone;

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
                            email: this.email,
                            timezone: this.timezone,
                        };
                        await axios.put(this.$root.route('api.users.update', this.id), data);
                        this.isSubmitting = false;
                        jQuery(this.$refs.modal).modal('hide');
                        location.reload();
                    } catch (e) {
                        this.isSubmitting = false;
                        if (e.response && e.response.data && e.response.data.errors) {
                            this.errors = e.response.data.errors;
                            return;
                        }
                        this.$root.alert('Something went wrong while saving the user. Please check the info you provided and try again.');
                    }
                })();
            },
        },
        async created() {
            jQuery(document).on('hidden.bs.modal', this.reset);
            this.$root.$on('user-edit', this.onEdit);
            const timezones = await axios.get(this.$root.route('api.timezones.index'));
            if (timezones.data) {
                this.timezones = timezones.data;
            }
        },
        beforeDestroyed() {
            jQuery(document).off('hidden.bs.modal', this.reset);
        },
    }
</script>
