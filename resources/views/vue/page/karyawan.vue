<template>
    <div class="container position-relative overflow-hidden py-4 px-5">
        <div class="h2 mb-4">
            <i class="fa fa-th-large me-2 text-success" aria-hidden="true"></i>
            Data karyawan
        </div>
        <div
            class="row p-3 rounded bg-white"
            style="box-shadow: rgb(234 232 232) -1px 3px 17px; height: 85vh"
        >
            <div class="row align-content-center position-relative">
                <div class="col-3 align-self-center">
                    <div class="d-grid">
                        <router-link
                            class="p-4 btn btn-outline-primary"
                            to="karyawan/tambah"
                        >
                            <i class="fa fa-plus me-2" aria-hidden="true"></i>
                            Tambah Karyawan
                        </router-link>
                    </div>
                </div>
                <div class="col">
                    <div class="border p-2 rounded">
                        <div class="row">
                            <div class="col text-center">
                                <label for="">Karyawan</label>
                                <div class="h4 fw-bold">
                                    <i
                                        class="fa fa-users me-2 text-primary"
                                        aria-hidden="true"
                                    ></i>
                                    {{ totalKarywanAll }}
                                </div>
                            </div>
                            <div class="col text-center">
                                <label for="">Admin</label>
                                <div class="h4 fw-bold">
                                    {{ totalKaryawanAdmin }}
                                </div>
                            </div>

                            <div class="col text-center">
                                <label for="">User</label>
                                <div class="h4 fw-bold">
                                    {{ totalKaryawanUsers }}
                                </div>
                            </div>

                            <div class="col-6 align-self-center">
                                <form @submit.prevent="pencarian">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            placeholder="Nama Karyawan"
                                            class="form-control"
                                            v-model="formPencarian.pencarian"
                                        />
                                        <button
                                            type="submit"
                                            class="btn btn-primary input-group-text btn-submit-data"
                                        >
                                            <i
                                                class="fa fa-search me-2"
                                                aria-hidden="true"
                                            ></i>
                                        </button>

                                        <button
                                            @click="loadIndexKaryawan()"
                                            type="button"
                                            class="btn btn-outline-primary ms-2"
                                        >
                                            Semua
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-relative">
                <div
                    class="border rounded table-responsive"
                    style="height: 33em"
                >
                    <table class="table align-middle">
                        <thead class="sticky-top top-0 bg-light">
                            <tr class="text-capitalize text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-if="
                                    in_karyawan.length == 0 &&
                                    loading_in_karyawan == false
                                "
                            >
                                <td colspan="5" style="height: 25em">
                                    <DataNull></DataNull>
                                </td>
                            </tr>

                            <tr v-if="loading_in_karyawan == true">
                                <td colspan="5" style="height: 25em">
                                    <dataLoading></dataLoading>
                                </td>
                            </tr>
                            <tr
                                v-for="(karyawan, index) in in_karyawan"
                                :key="index"
                                class="text-center"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ karyawan.name }}</td>
                                <td>{{ karyawan.username }}</td>
                                <td>
                                    <span
                                        v-html="
                                            $options.filters.status_karyawan(
                                                karyawan.status
                                            )
                                        "
                                    ></span>
                                </td>
                                <td>
                                    <span
                                        v-html="
                                            $options.filters.role_status(
                                                karyawan.role
                                            )
                                        "
                                    ></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Form } from "vform";
import DataNull from "../component/utils/dataNull.vue";
import DataLoading from "../component/utils/dataLoading.vue";

export default {
    components: {
        DataNull,
        DataLoading,
    },
    data() {
        return {
            loading_in_karyawan: false,
            in_karyawan: {},
            totalKaryawanAdmin: 0,
            totalKaryawanUsers: 0,
            totalKarywanAll: 0,
            modalFilterByDate: null,
            formPencarian: new Form({
                pencarian: "",
            }),
        };
    },
    mounted() {
        this.loadIndexKaryawan();
    },
    methods: {
        showModalFormFilterByDate() {
            this.modalFilterByDate.show();
        },

        loadingData(argLoading) {
            if (argLoading) {
                this.loading_in_karyawan = true;
                this.in_karyawan = {};
            } else {
                this.loading_in_karyawan = false;
            }
        },

        pencarian() {
            this.$toast.df102("Melakukan Pencarian");
            this.formPencarian
                .get("/api/karyawan")
                .then((response) => {
                    this.$toast.df200();
                    let responseData = response.data.data;
                    this.in_karyawan = responseData.in_karyawan;
                    this.totalKaryawanAdmin = responseData.totalKaryawanAdmin;
                    this.totalKaryawanUsers = responseData.totalKaryawanUsers;
                    this.totalKarywanAll = responseData.totalKarywanAll;
                })
                .catch((e) => {
                    this.$toast.df500();
                    console.log(e);
                });
        },
        loadIndexKaryawan() {
            this.in_karyawan = {};
            this.loading_in_karyawan = true;
            axios
                .get("/api/karyawan")
                .then((response) => {
                    this.loading_in_karyawan = false;
                    let responseData = response.data.data;
                    this.in_karyawan = responseData.in_karyawan;

                    this.totalKaryawanAdmin = responseData.totalKaryawanAdmin;
                    this.totalKaryawanUsers = responseData.totalKaryawanUsers;
                    this.totalKarywanAll = responseData.totalKarywanAll;
                })
                .catch((e) => {
                    this.loading_in_karyawan = false;
                    console.log(e);
                });
        },
    },
};
</script>
