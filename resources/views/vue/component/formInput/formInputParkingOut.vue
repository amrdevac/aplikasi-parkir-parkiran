<template>
    <div>
        <form @submit.prevent="checkoutDataParkir">
            <div class="form-group my-3">
                <label for="">Masukan Kode Unik</label>
                <div class="input-group">
                    <input
                        type="text"
                        v-model="form.kode_unik"
                        class="form-control bg-white"
                    />
                    <button
                        class="btn btn-primary btn-submit-data input-group-text"
                    >
                        <i class="fa fa-sign-in me-2" aria-hidden="true"></i>
                        Submit
                    </button>
                </div>
                <div
                    class="text-danger"
                    v-if="form.errors.has('kode_unik')"
                    v-html="form.errors.get('kode_unik')"
                />
            </div>
        </form>
        <div class="border p-3 rounded">
            <span class="h5">Detail Parkir</span>
            <div
                v-if="data_parkir == null"
                class="text-center align-middle d-flex align-items-center justify-content-center"
                style="max-height: 23.4em; height: 23.4em"
            >
                <div class="d-block text-secondary">
                    <i class="fa fa-cube fa-3x" aria-hidden="true"></i>
                    <div class="fst-italic mt-2">Tidak Terdapat Data</div>
                </div>
            </div>
            <div v-else class="d-grid gap-2">
                <div class="form-group">
                    <label for="">Nomor Polisi</label>
                    <div class="h4 text-center">
                        {{ data_parkir.no_polisi }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Sejak</label>
                    <div class="h4 border border-success p-2 rounded">
                        {{
                            $date(data_parkir.created_at).format(
                                "DD, MMM YY HH:mm"
                            )
                        }}
                        <span class="fst-italic"
                            >({{ this.formPayment.hours }} Jam)</span
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Total Pembayaran</label>
                    <div class="h1 p-2 rounded">
                        Rp {{ this.formPayment.total_amount | number_format }}
                    </div>
                </div>

                <div class="d-grid mt-1">
                    <button
                        class="btn btn-lg btn-success py-3 fs-4 btn-submit-data"
                        @click="terimaPembayaran"
                    >
                        Terima Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Form } from "vform";

export default {
    data() {
        return {
            form: new Form({
                kode_unik: "",
            }),

            hours: "",
            total_amount: "",
            data_parkir: null,

            formPayment: new Form({
                uuid_parkir: "",
                hours: "",
                total_amount: "",
            }),
        };
    },
    mounted() {},
    methods: {
        checkoutDataParkir() {
            this.$toast.df102("Memuat data kendaraan");
            this.form
                .post("/api/parkir/detail")
                .then((response) => {
                    this.$toast.df200();
                    this.data_parkir = response.data.data.parkir;
                    this.formPayment.hours = response.data.data.hours;
                    this.formPayment.total_amount =
                        response.data.data.totalAmount;
                    this.formPayment.uuid_parkir = this.form.kode_unik;
                })
                .catch((error) => {
                    this.$toast.df500(error.response.data.message);
                });
        },
        terimaPembayaran() {
            konfirmasiPembayaran.fire().then((result) => {
                if (result.isConfirmed) {
                    this.$toast.df102();
                    this.formPayment
                        .post("/api/parkir/payment/cash")
                        .then((response) => {
                            this.$toast.df200(response.data.message);
                            this.data_parkir = null;
                            this.form.kode_unik = "";
                            this.$emitUtils.reloadIndexParking(true);
                        })
                        .catch((e) => {
                            this.$error.catch();
                        });
                }
            });
        },
    },
};
</script>
