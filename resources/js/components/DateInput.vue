<template>
    <input type="text" ref="input" :value="date" @input="onInput" placeholder="YYYY-MM-DD" />
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
                return value.replace(/\D+/g, '').substring(0, 8).replace(/^(\d{4})(\d{2})?(\d*)$/, '$1-$2-$3');
            },
            onInput() {
                this.date = this.format(this.$refs.input.value);
                this.$emit('input', this.date);
            },
        },
    }
</script>
