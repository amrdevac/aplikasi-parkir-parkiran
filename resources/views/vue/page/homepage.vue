<template>
    <div class="container-fluid position-relative overflow-hidden">
        <div class="row">
            <div class="col">
                <div class="container">
                    <div
                        class="row"
                        style="
                            height: 100vh;
                            padding-left: 15em;
                            padding-right: 15em;
                        "
                    >
                        <div class="col-12 mt-5">
                            <h2 style="font-weight: bolder">
                                Welcome to Parking Ticket
                            </h2>
                            <p class="text-secondary mt-3">
                                Selamat datang kembali , <br />
                                silahkan login menggunakan akun milikmu
                            </p>
                        </div>
                        <div class="col-12">
                            <formLoginComponent></formLoginComponent>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
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
                    <div class="col-12 align-self-start text-end">
                        <div class="mt-5">
                            <img
                                src="/image/sapiens.png"
                                class=""
                                style="width: 50px"
                            />
                            <span class="text-white fw-bolder"
                                >Parking Ticket App</span
                            >
                        </div>
                    </div>
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
import formLoginComponent from "../component/formInput/formLoginComponent.vue";
export default {
    components: {
        formLoginComponent,
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        show_password() {
            this.typeInput = !this.typeInput;
            let password = document.getElementById("password");
            if (this.typeInput) {
                password.setAttribute("type", "text");
            } else {
                password.setAttribute("type", "password");
            }
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
