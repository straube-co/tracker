<template>
    <input type="text" ref="input" :value="date" @keypress="onKey" @input="onInput" placeholder="YYYY-MM-DD" />
</template>

<script>
    export default {
        props: [
            'value'
        ],
        data() {
            return {
                date: this.format(this.value),
            };
        },
        methods: {
            format(value) {
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
                this.date = this.format(this.$refs.input.value);
                this.$emit('input', this.date);
            },
        },
    }
</script>
