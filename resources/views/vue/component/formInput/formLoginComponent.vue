<template>
    <div>
        <form @submit.prevent="login" class="d-grid gap-3 h-4">
            <div class="form-group">
                <label for="">ID Karyawan</label>
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
            <div class="form-group">
                <label for="">Password</label>
                <input
                    type="password"
                    autocomplete=""
                    v-model="form.password"
                    class="form-control"
                />
                <div
                    class="text-danger"
                    v-if="form.errors.has('password')"
                    v-html="form.errors.get('password')"
                />
                <div class="float-end text-primary py-2 cursor">
                    Lupa password
                </div>
            </div>
            <div class="row gap-2">
                <div class="col-12 d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <div class="col-12 d-grid">
                    <button type="button" class="btn btn-outline-primary">
                        Hubungi tim IT
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
            registrasi: false,
            telah_registrasi: false,
            typeInput: false,
            public_registration: false,
            form: new Form({
                username: "",
                password: "",
            }),
        };
    },
    methods: {
        login() {
            const Toast = this.$swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timerProgressBar: false,
            });
            Toast.fire({
                icon: "info",
                title: "Proses Autentikasi",
            });

            this.form
                .post("/login")
                .then((resp) => {
                    Toast.fire({
                        icon: "success",
                        title: "Berhasil Login",
                    });
                    window.location = "/dashboard";
                })
                .catch((err) => {
                    Toast.fire({
                        icon: "error",
                        title: err.response.data.message,
                    });
                });
        },
    },
};
</script>
