<template>
    <input type="text" ref="input" :value="date_ !== null ? date_ : date" @keypress="onKey" @input="onInput" placeholder="YYYY-MM-DD" />
</template>

<script>
    export default {
        props: [
            'value'
        ],
        data() {
            return {
                date_: null,
            };
        },
        computed: {
            date() {
                return this.format(this.value);
            },
        },
        methods: {
            format(value) {
                if (!value) {
                    return '';
                }
                value = value.replace(/\D+/g, '').substring(0, 8);
                const parts = value.match(/\d{1,2}/g);
                if (!parts) {
                    return '';
                }
                let format = '';
                while (parts.length > 0) {
                    const separator = parts.length > 1 && format.length > 0 ? '-' : '';
                    format = parts.pop() + separator + format;
                }
                return format;
            },
            onKey(event) {
                if (!event.key.match(/^\d$/) || this.$refs.input.value.length > 9) {
                    event.preventDefault();
                }
            },
            onInput() {
                const value = this.format(this.$refs.input.value);
                // It's likely using v-model
                if (this.$listeners.input) {
                    this.$emit('input', value);
                    return;
                }
                this.date_ = value;
            },
        },
    }
</script>
