import Swal from "sweetalert2";

export default class toast {
    df102(message = "Dalam Proses .. ") {
        window.btn_kelola(true);
        Swal.mixin({
            title: message,
            icon: "info",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timerProgressBar: false,
            showCloseButton: true,
        }).fire();
    }

    df200(message = "Proses Berhasil .. ") {
        window.btn_kelola(false);
        Swal.mixin({
            title: message,
            icon: "success",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        }).fire();
    }

    df500(message = "Terjadi Kelas Server .. ") {
        window.btn_kelola(false);
        Swal.mixin({
            title: message,
            icon: "warning",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        }).fire();
    }
}
