<template>
    <div>
        <form @submit.prevent="saveDataParkir">
            <div class="form-group">
                <label for="">Jenis Kendaraan</label>
                <select
                    v-model="form.jenis_kendaraan"
                    class="form-control text-capitalize bg-white"
                >
                    <option selected>Pilih Jenis Kendaraan</option>
                    <option value="mobil">Mobil</option>
                    <option value="motor">Motor</option>
                    <option value="bus">Bus</option>
                    <option value="lainya">lainya</option>
                </select>
                <div
                    class="text-danger"
                    v-if="form.errors.has('jenis_kendaraan')"
                    v-html="form.errors.get('jenis_kendaraan')"
                />
            </div>
            <div class="form-group my-3">
                <label for="">Nomor Polisi</label>
                <div class="row">
                    <div class="col">
                        <label for="" class="small">Huruf Awal</label>
                        <input
                            type="text"
                            v-model="no_polisi.huruf_awal"
                            class="form-control bg-white trans-to-uppercase text-center"
                            autocapitalize=""
                            maxlength="4"
                            required
                        />
                    </div>

                    <div class="col">
                        <label for="" class="small">Angka</label>
                        <input
                            type="number"
                            v-model="no_polisi.angka"
                            class="form-control bg-white trans-to-uppercase text-center"
                            required
                        />
                    </div>

                    <div class="col">
                        <label for="" class="small">Huruf Akhir</label>
                        <input
                            type="text"
                            v-model="no_polisi.huruf_akhir"
                            class="form-control bg-white trans-to-uppercase text-center"
                            autocapitalize=""
                            maxlength="4"
                            required
                        />
                    </div>
                </div>
            </div>

            <div
                class="text-danger"
                v-if="form.errors.has('no_polisi')"
                v-html="form.errors.get('no_polisi')"
            />

            <div class="border p-2 rounded">
                <label for="">Nomor Polisi</label>

                <div class="h4 fw-bold text-uppercase text-center">
                    <span>
                        <span
                            v-if="no_polisi.huruf_awal == ''"
                            class="text-secondary"
                        >
                            XXX
                        </span>
                        <span v-else>
                            {{ no_polisi.huruf_awal }}
                        </span>
                    </span>
                    <span>
                        <span
                            v-if="no_polisi.angka == ''"
                            class="text-secondary"
                        >
                            XXXX
                        </span>
                        <span v-else>
                            {{ no_polisi.angka }}
                        </span>
                    </span>
                    <span>
                        <span
                            v-if="no_polisi.huruf_akhir == ''"
                            class="text-secondary"
                        >
                            XXX
                        </span>
                        <span v-else>
                            {{ no_polisi.huruf_akhir }}
                        </span>
                    </span>
                </div>
            </div>

            <div class="form-group my-3">
                <label for="">Tarif Kendaraan</label>
                <money
                    readonly
                    class="form-control"
                    v-model="form.tarif"
                ></money>
            </div>

            <div class="form-group mt-5">
                <div class="d-grid">
                    <button
                        class="btn btn-primary btn-submit-data"
                        id="submit-parking-in"
                    >
                        <i class="fa fa-sign-in me-2" aria-hidden="true"></i>
                        Submit Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            no_polisi: {
                huruf_awal: "",
                angka: "",
                huruf_akhir: "",
            },
            form: new Form({
                tarif: 3000,
                no_polisi: "",
                jenis_kendaraan: "",
            }),
        };
    },
    mounted() {},
    methods: {
        saveDataParkir() {
            let pattern = /[0-9]+/gm;
            if (pattern.test(this.no_polisi.huruf_awal)) {
                return this.$toast.df500("Huruf awal tidak valid");
            }

            if (pattern.test(this.no_polisi.huruf_akhir)) {
                return this.$toast.df500("Huruf akhir tidak valid");
            }

            this.$toast.df102();
            let data = Object.values(this.no_polisi);
            this.form.no_polisi = data.join("").toUpperCase();
            this.form
                .post("/api/parkir")
                .then((resp) => {
                    this.$emitUtils.reloadIndexParking(true);
                    this.$toast.df200();
                })
                .catch((err) => {
                    this.$toast.df500();
                });
        },
    },
};
</script>
