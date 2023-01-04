import Swal from "sweetalert2";

// Deletion Component
const konfirmasiPembayaran = Swal.mixin({
    title: "Terima Pembayaran",
    text: "Pastikan jumlah uang yang diterima telah sesuai",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#0d6efd",
    cancelButtonColor: "#6c757d",
    confirmButtonText: "Terima pembayaran",
    cancelButtonText: "Batal"
});

export default konfirmasiPembayaran;
// =====
