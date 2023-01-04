<template>
    <div class="container position-relative overflow-hidden py-4 px-5">
        <div class="h2 mb-4">
            <i class="fa fa-th-large me-2 text-success" aria-hidden="true"></i>
            Tambah karyawan
        </div>
        <div
            class="p-3 rounded bg-white"
            style="box-shadow: rgb(234 232 232) -1px 3px 17px; height: 85vh"
        >
            <router-link to="/karyawan" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2" aria-hidden="true"></i>
                Kembali
            </router-link>

            <form @submit.prevent="tambahKaryawan" class="">
                <h5 class="mt-3">Form Tambah Karyawan</h5>
                <div class="form-group mb-4">
                    <label for="" class="text-capitalize my-2">name</label>
                    <input
                        type="text"
                        v-model="form.name"
                        class="form-control"
                    />
                    <div
                        class="text-danger"
                        v-if="form.errors.has('name')"
                        v-html="form.errors.get('name')"
                    />
                </div>
                <div class="form-group my-4">
                    <labe class="text-capitalize my-2" l for="">username</labe>
                    <input
                        type="text"
                        v-model="form.username"
                        class="form-control"
                    />
                    <div
                        class="text-danger"
                        v-if="form.errors.has('username')"
                        v-html="form.errors.get('username')"
                    />
                </div>
                <div class="form-group my-4">
                    <label fo class="text-capitalize my-2" r="">status</label>
                    <select v-model="form.status" class="form-control">
                        <option value="" selected>Pilih Status</option>
                        <option value="0">Suspend</option>
                        <option value="1">Aktif</option>
                    </select>
                    <div
                        class="text-danger"
                        v-if="form.errors.has('status')"
                        v-html="form.errors.get('status')"
                    />
                </div>
                <div class="form-group my-4">
                    <label for="" class="text-capitalize my-2">role</label>
                    <select v-model="form.role" class="form-control">
                        <option value="" selected>Pilih Role</option>
                        <option value="0">Users</option>
                        <option value="1">Admin</option>
                    </select>
                    <div
                        class="text-danger"
                        v-if="form.errors.has('role')"
                        v-html="form.errors.get('role')"
                    />
                </div>
                <button type="submit" class="btn btn-primary">
                    <i
                        class="fa fa-plus me-2 btn-submit-data"
                        aria-hidden="true"
                    ></i>
                    Tambah Karyawan
                </button>
            </form>
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
            form: new Form({
                name: "",
                username: "",
                status: "",
                role: "",
            }),
        };
    },
    mounted() {
        this.loadIndexKaryawan();
    },
    methods: {
        tambahKaryawan() {
            this.$toast.df102();
            this.form
                .post("/api/karyawan")
                .then((response) => {
                    this.$toast.df200();
                    this.form.reset();
                })
                .catch((e) => {
                    this.$toast.df500();
                });
        },
    },
};
</script>
