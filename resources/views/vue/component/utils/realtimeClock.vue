<template>
    <div >
        <div class="">
            <span id="realtimeClock" class="h3"></span>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        this.realtimeClock();
    },
    methods: {
        realtimeClock() {
            this.$utils.currentTime();
            let nv = this;
            setTimeout(function () {
                nv.realtimeClock();
            }, 1000);
        },
    },
};
</script>
