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
                return this.pad(Math.floor(this.seconds / 3600));
            },
            minutes() {
                return this.pad(Math.floor((this.seconds % 3600) / 60));
            },
        },
        methods: {
            pad(value, size = 2) {
                return '0'.repeat(size).slice(value.toString().length) + value;
            },
        },
        created() {
            const now = Date.now();
            this.interval = window.setInterval(() => {
                this.seconds = Math.round(parseInt(this.time, 10) + (Date.now() - now) / 1000);
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
