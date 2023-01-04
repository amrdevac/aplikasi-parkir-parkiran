<template>
    <div>
        <vue-sidebar-menu-akahon
            :menuItems="dataMenu"
            :menuTitle="'Parking App'"
            :menuIcon="'bxs-car-garage'"
            :isSearch="false"
            :bgColor="'#212529'"
            :iconsColor="'#0d6efd'"
            :profileName="userData.name"
            :isExitButton="false"
        ></vue-sidebar-menu-akahon>
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
            dataMenu: [
                {
                    link: "#",
                    name: "Dashboard",
                    tooltip: "Dashboard",
                    icon: "bx-grid-alt",
                },
            ],
            userData: [],
        };
    },

    mounted() {
        this.loadMenu();
    },
    methods: {
        logout() {
            alert();
        },

        loadMenu() {
            this.userData = window.user;
            this.dataMenu = JSON.parse(localStorage.getItem("userMenu"));
        },
    },
};
</script>
