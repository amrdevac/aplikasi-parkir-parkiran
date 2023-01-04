<template>
    <div class="container position-relative overflow-hidden py-4 px-5">
        <div class="h2 mb-4">
            <i class="fa fa-arrow-circle-o-right me-2 text-primary" aria-hidden="true"></i>
            Masuk Parkir
        </div>
        <div
            class="row p-3 rounded bg-white"
            style="box-shadow: rgb(234 232 232) -1px 3px 17px; height: 85vh"
        >
            <div class="col">
                <section class="py-4 rounded my-3">
                    <span class="h5"> Waktu</span>
                    <realtimeClock></realtimeClock>
                </section>
                <section>
                    <div class="h5 mb-2 fw-bold">
                        <i class="fa fa-th-large me-2" aria-hidden="true"></i>
                        Form Input Parkir Masuk
                    </div>
                    <formInputParkingIn></formInputParkingIn>
                </section>
            </div>
            <div class="col-8">
                <div class="border border-1 py-4 px-3 rounded my-3">
                    <tableIndexParking></tableIndexParking>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import formInputParkingIn from "../component/formInput/formInputParkingIn.vue";
import tableIndexParking from "../component/table/tableIndexParking.vue";
import realtimeClock from "../component/utils/realtimeClock.vue";

export default {
    components: {
        formInputParkingIn,
        tableIndexParking,
        realtimeClock,
    },
    data() {
        return {};
    },
    mounted() {},
    methods: {},
};
</script>
