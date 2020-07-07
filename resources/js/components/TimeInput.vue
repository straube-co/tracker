<template>
    <input type="text" ref="input" :value="time" @keypress="onKey" @input="onInput" placeholder="HH:MM" />
</template>

<script>
    export default {
        props: [
            'value'
        ],
        computed: {
            time() {
                return this.format(this.value);
            },
        },
        methods: {
            format(value) {
                return value.replace(/\D+/g, '').substring(0, 4).replace(/^(\d{2})(\d*)$/, '$1:$2');
            },
            onKey(event) {
                if (!event.key.match(/^\d$/) || this.$refs.input.value.length > 4) {
                    event.preventDefault();
                }
            },
            onInput() {
                this.$emit('input', this.format(this.$refs.input.value));
            },
        },
    }
</script>
