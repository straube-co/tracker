<template>
    <span>
        {{ hours }}{{ blink ? ':' : ' ' }}{{ minutes }}
    </span>
</template>

<script>
    export default {
        props: [
            'time',
        ],
        data() {
            return {
                interval: null,
                blink: true,
                seconds: parseInt(this.time, 10),
            }
        },
        computed: {
            hours() {
                return this.pad(Math.floor(this.seconds / (60 * 60)));
            },
            minutes() {
                return this.pad(Math.floor(this.seconds / 60));
            },
        },
        methods: {
            pad(value, size = 2) {
                return '0'.repeat(size).slice(value.toString().length) + value;
            },
        },
        created() {
            this.interval = window.setInterval(() => {
                this.seconds++;
                window.requestAnimationFrame(() => {
                    this.blink = !this.blink;
                });
            }, 1000);
        },
        beforeDestroyed() {
            window.clearInterval(this.interval);
        },
    }
</script>
