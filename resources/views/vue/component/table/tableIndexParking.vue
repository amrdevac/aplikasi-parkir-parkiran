<template>
    <div>
        <FormVerifyShowUUIDParkir></FormVerifyShowUUIDParkir>

        <h5 class="mx-1 mb-3">
            <i class="fa fa-clock-o me-2" aria-hidden="true"></i>
            History Parkir
        </h5>
        <div class="border rounded p-2 table-responsive" style="height: 33em">
            <table class="table align-middle">
                <thead>
                    <tr class="text-capitalize text-center">
                        <th>No</th>
                        <th>No. Polisi</th>
                        <th>Jenis</th>
                        <th>Total</th>
                        <th>status</th>
                        <th>kode unik</th>
                        <th>petugas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="in_parkir.length == 0">
                        <td colspan="7">
                            <DataNull></DataNull>
                        </td>
                    </tr>
                    <tr
                        v-for="(parkir, index) in in_parkir"
                        :key="index"
                        class="text-center"
                    >
                        <td>{{ index + 1 }}</td>
                        <td class="text-uppercase">{{ parkir.no_polisi }}</td>

                        <td class="text-capitalize">
                            {{ parkir.jenis_kendaraan }}
                        </td>
                        <td style="align-self: center">
                            IDR {{ parkir.total | number_format }}
                        </td>
                        <td class="align-self-center">
                            <span
                                v-html="
                                    $options.filters.parking_status(
                                        parkir.status
                                    )
                                "
                            ></span>
                        </td>
                        <td class="text-center">
                            <button
                                v-if="parkir.status == 0"
                                class="btn btn-sm btn-outline-primary"
                                @click="showFormVerifyPassword(parkir.id)"
                            >
                                <i
                                    class="fa fa-eye me-2"
                                    aria-hidden="true"
                                ></i>
                                Lihat
                            </button>
                            <span v-else>-</span>
                        </td>
                        <td>{{ parkir.name.substring(0, 10) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import FormVerifyShowUUIDParkir from "../formInput/formVerifyShowUUIDParkir.vue";
import DataNull from "../utils/dataNull.vue";

export default {
    data() {
        return {
            in_parkir: {},
        };
    },
    mounted() {
        this.loadIndexParkir();
        emitBy.$off(this.$emitUtils.reloadIndexParking());
        emitBy.$on(this.$emitUtils.reloadIndexParking(), () => {
            this.loadIndexParkir();
        });
    },
    methods: {
        showFormVerifyPassword(id) {
            this.$emitUtils.verifyPasswordForUUIDParking(true, id);
        },
        loadIndexParkir() {
            axios
                .get("/api/parkir/with-limit")
                .then((response) => {
                    this.in_parkir = response.data.data;
                })
                .catch((e) => {
                    console.log(e);
                });
        },
    },
    components: { FormVerifyShowUUIDParkir, DataNull },
};
</script>
