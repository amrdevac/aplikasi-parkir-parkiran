<template>
    <div>
        <div class="modal fade" id="formVerifikasiPassword" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Verifikasi Password
                        </h5>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="verifyPassword">
                            <div class="form-group">
                                <div class="input-group">
                                    <input
                                        type="password"
                                        v-model="form.password"
                                        class="form-control"
                                        placeholder="Masukan password akun anda"
                                        autocomplete="off"
                                        required
                                    />
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-submit-data"
                                    >
                                        Verifikasi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showUUIDParkir" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Parkir</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">No. Polisi</label>
                            <input
                                readonly
                                type="text"
                                v-model="data_parkir.no_polisi"
                                class="form-control"
                                placeholder=""
                                aria-describedby="helpId"
                            />
                        </div>

                        <div class="form-group">
                            <label for="">Kode Unik</label>
                            <div class="input-group">
                                <input
                                    readonly
                                    type="text"
                                    v-model="data_parkir.uuid_parkir"
                                    class="form-control"
                                    placeholder=""
                                    aria-describedby="helpId"
                                />
                                <button
                                    class="btn btn-primary input-group-text"
                                    @click="copyUUID(data_parkir.uuid_parkir)"
                                >
                                    <i
                                        class="fa fa-file me-2"
                                        aria-hidden="true"
                                    ></i>
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            form: new Form({
                password: "",
                parkir_id: "",
            }),
            data_parkir: {
                no_polisi: "",
                uuid_parkir: "",
            },
        };
    },
    mounted() {
        emitBy.$off(this.$emitUtils.verifyPasswordForUUIDParking())
        emitBy.$on(this.$emitUtils.verifyPasswordForUUIDParking(), (params) => {
            this.showFormVerifyPassword(params);
        });
        this.modalShowUUIDParkir = new bootstrap.Modal(
            document.getElementById("showUUIDParkir")
        );

        this.modalVerifikasiPsasword = new bootstrap.Modal(
            document.getElementById("formVerifikasiPassword")
        );
    },
    methods: {
        copyUUID(argDataUUID) {
            this.$toast.df200("Kode telah di copy !");
            navigator.clipboard.writeText(argDataUUID);
        },

        showFormVerifyPassword(argParamsParkirID) {
            this.form.parkir_id = argParamsParkirID;
            this.modalVerifikasiPsasword.show();
        },

        verifyPassword() {
            this.$toast.df102("Proses Verifikasi Password");
            this.form
                .post("/api/parkir/verify/uuid")
                .then((response) => {
                    this.$toast.df200();
                    this.modalVerifikasiPsasword.hide();
                    this.data_parkir = response.data.data;
                    this.modalShowUUIDParkir.show();
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.df500(error.response.data.message);
                });
        },
    },
};
</script>
