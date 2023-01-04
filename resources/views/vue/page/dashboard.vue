<template>
    <div class="position-relative overflow-hidden">
        <div class="row">
            <div class="col">
                <div class="container">
                    <div class="row" style="height: 100vh">
                        <div class="col-12 mt-5">
                            <h2 style="font-weight: bolder">
                                Welcome to Parking Ticket
                            </h2>
                            <h3>{{ user.name }}</h3>
                            <p class="text-secondary mt-3">
                                Selamat datang kembali , <br />
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <img
                    src="/image/wave.png"
                    class="w-100"
                    style="
                        rotate: -90deg;
                        position: absolute;
                        right: -29.5%;
                        z-index: -1;
                    "
                />
                <div class="row p-5" style="height: 100vh">
                    <div class="col-12 align-self-end">
                        <img
                            src="/image/sapiens.png"
                            class="w-100"
                            style="filter: drop-shadow(-3px 2px 4px #248)"
                        />
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
            user: [],
        };
    },
    mounted() {
        this.loadUser();
    },
    methods: {
        loadUser() {
            this.user = window.user;
        },
        logout() {
            axios.post("/logout").then(() => {
                window.location = "/";
            });
        },
        onCaptchaVerified(recaptchaToken) {
            this.captcha = true;
        },
        onCaptchaExpired(recaptchaToken) {
            this.captcha = false;
        },
    },
};
</script>
