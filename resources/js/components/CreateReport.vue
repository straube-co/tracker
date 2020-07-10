<template>
    <div class="modal fade" ref="modal" id="create-project" tabindex="-1" role="dialog" aria-labelledby="create-project-label" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit.prevent="onSubmit">
                <div class="modal-header">
                    <h5 class="modal-title" id="create-project-label">New Report</h5>
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
                    <span v-if="error('filter')" class="invalid-feedback d-block" role="alert">
                        {{ error('filter') }}
                    </span>
                    <span v-for="error in filterErrors()" class="invalid-feedback d-block" role="alert">
                        {{ error }}
                    </span>
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
                name: '',
                filters: {},
            }
        },
        methods: {
            reset() {
                this.isSubmitting = false;
                this.errors = {};

                this.name = '';
                this.filters = {};
            },
            error(name) {
                if (!this.errors || !this.errors[name]) {
                    return null;
                }
                return this.errors[name].join(' ');
            },
            filterErrors() {
                const errors = [];
                Object.keys(this.errors).filter((name) => !!name.match(/^filter\./)).forEach((name) => {
                    errors.push(this.error(name));
                });
                return errors;
            },
            fieldsToObject(form) {
                return Array.from(form.elements).reduce((data, element) => {
                    if (!element.value) {
                        return data;
                    }
                    const name = element.name.replace(/^.*\[(.+)\]$/, '$1');
                    return Object.assign(data, { [name] : element.value });
                }, {});
            },
            onCreate(form) {
                this.reset();

                this.filters = this.fieldsToObject(form);

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
                            filter: this.filters,
                        };
                        const report = await axios.post(this.$root.route('api.reports.store'), data);
                        this.isSubmitting = false;
                        jQuery(this.$refs.modal).modal('hide');
                        location = report.data.url;
                    } catch (e) {
                        console.error(e);
                        this.isSubmitting = false;
                        if (e.response && e.response.data && e.response.data.errors) {
                            this.errors = e.response.data.errors;
                            return;
                        }
                        this.$root.alert('Something went wrong while saving the report. Please check the info you provided and try again.');
                    }
                })();
            },
        },
        created() {
            jQuery(document).on('hidden.bs.modal', this.reset);
            this.$root.$on('create-report', this.onCreate);
        },
        beforeDestroyed() {
            jQuery(document).off('hidden.bs.modal', this.reset);
        },
    }
</script>
