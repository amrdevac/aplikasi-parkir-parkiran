<template>
    <div class="container position-relative overflow-hidden py-4 px-5">
        <div class="h2 mb-4">
            <i class="fa fa-th-large me-2 text-success" aria-hidden="true"></i>
            Laporan Parkir
        </div>
        <div
            class="row p-3 rounded bg-white"
            style="box-shadow: rgb(234 232 232) -1px 3px 17px; height: 85vh"
        >
            <div class="row align-content-center position-relative">
                <div class="col-2 align-self-center">
                    <div class="d-grid">
                        <div
                            class="p-4 btn btn-outline-success"
                            @click="exportToExcel()"
                        >
                            <i
                                class="fa fa-file-excel-o me-2"
                                aria-hidden="true"
                            ></i>
                            Export Excel
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="border p-2 rounded">
                        <div class="row">
                            <div class="col text-center">
                                <label for="">Masuk</label>
                                <div class="h4 fw-bold">
                                    <i
                                        class="fa fa-arrow-circle-o-right text-primary me-2"
                                        aria-hidden="true"
                                    ></i
                                    >{{ totalAktifParkirKAll }}
                                </div>
                            </div>
                            <div class="col text-center">
                                <label for="">Keluar</label>

                                <div class="h4 fw-bold">
                                    <i
                                        class="fa fa-arrow-circle-o-left text-success me-2"
                                        aria-hidden="true"
                                    ></i
                                    >{{ totalParkirKeluarAll }}
                                </div>
                            </div>

                            <div class="col text-center">
                                <label for="">Pendapatan</label>

                                <div class="h4 fw-bold">
                                    Rp {{ totalPendapatanAll | number_format }}
                                </div>
                            </div>

                            <div class="col-6 align-self-center">
                                <form @submit.prevent="cariKendaran">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            placeholder="Nomor Polisi"
                                            class="form-control"
                                            v-model="formPencarian.no_polisi"
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
                                            @click="loadIndexParkir()"
                                            type="button"
                                            class="btn btn-outline-primary ms-2"
                                        >
                                            Semua
                                        </button>

                                        <button
                                            @click="showModalFormFilterByDate()"
                                            type="button"
                                            class="btn btn-outline-primary ms-2"
                                        >
                                            <i
                                                class="fa fa-filter me-2"
                                                aria-hidden="true"
                                            ></i>
                                            Filter Lanjutan
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
                                <th>No. Polisi</th>
                                <th>Jenis</th>
                                <th>Tarif</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Waktu</th>
                                <th>Pembayaran</th>
                                <th>status</th>
                                <th>petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-if="
                                    in_parkir.length == 0 &&
                                    loading_in_parkir == false
                                "
                            >
                                <td colspan="10" style="height: 25em">
                                    <DataNull></DataNull>
                                </td>
                            </tr>

                            <tr v-if="loading_in_parkir == true">
                                <td colspan="10" style="height: 25em">
                                    <dataLoading></dataLoading>
                                </td>
                            </tr>
                            <tr
                                v-for="(parkir, index) in in_parkir"
                                :key="index"
                                class="text-center"
                            >
                                <td>{{ index + 1 }}</td>
                                <td class="text-uppercase">
                                    {{ parkir.no_polisi }}
                                </td>

                                <td class="text-capitalize">
                                    {{ parkir.jenis_kendaraan }}
                                </td>

                                <td style="align-self: center">
                                    IDR {{ parkir.total | number_format }}
                                </td>

                                <td style="align-self: center">
                                    {{
                                        $date(parkir.created_at).format(
                                            "DD, MMM HH:mm"
                                        )
                                    }}
                                </td>
                                <td style="align-self: center">
                                    <span v-if="parkir.status == 1">
                                        {{
                                            $date(
                                                parkir.waktu_pembayaran
                                            ).format("DD, MMM HH:mm")
                                        }}
                                    </span>
                                    <span v-else> - </span>
                                </td>
                                <td style="align-self: center">
                                    <span v-if="parkir.status == 1">
                                        {{ parkir.total_waktu }} Jam
                                    </span>
                                    <span v-else> - </span>
                                </td>

                                <td style="align-self: center">
                                    <span v-if="parkir.status == 1">
                                        IDR
                                        {{
                                            parkir.total_pembayaran
                                                | number_format
                                        }}
                                    </span>
                                    <span v-else> - </span>
                                </td>
                                <td class="align-self-center">
                                    <span
                                        v-html="
                                            $options.filters.parking_status(
                                                parkir.status
                                            )
                                        "
                                    ></span>
                                </td>

                                <td>{{ parkir.name.substring(0, 10) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalFormFilterByDate" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Berdasarkan Tanggal</h5>
                    </div>
                    <div class="modal-body">
                        <form
                            @submit.prevent="advanceFilter"
                            class="d-grid gap-3"
                        >
                            <div class="form-group">
                                <label for="">Status Parkir</label>
                                <select
                                    v-model="formFilter.status_parkir"
                                    id=""
                                    class="form-control"
                                >
                                    <option value="">Semua</option>
                                    <option value="0">Aktif</option>
                                    <option value="1">Keluar</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Sejak Tanggal</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="formFilter.sejak_tgl"
                                />
                            </div>

                            <div class="form-group">
                                <label for="">Hingga Tanggal</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="formFilter.hingga_tgl"
                                />
                            </div>

                            <div class="form-group d-grid">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-submit-data"
                                >
                                    <i
                                        class="fa fa-filter me-2"
                                        aria-hidden="true"
                                    ></i>
                                    Submit Filter
                                </button>
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
            loading_in_parkir: false,
            in_parkir: {},
            totalAktifParkirKAll: 0,
            totalParkirKeluarAll: 0,
            totalPendapatanAll: 0,
            modalFilterByDate: null,
            formPencarian: new Form({
                no_polisi: "",
            }),
            formFilter: new Form({
                status_parkir: "",
                sejak_tgl: "",
                hingga_tgl: "",
            }),
        };
    },
    mounted() {
        this.loadIndexParkir();
        this.modalFilterByDate = new bootstrap.Modal(
            document.getElementById("modalFormFilterByDate")
        );
    },
    methods: {
        exportToExcel() {
            this.$toast.df102();
            axios
                .post("/api/parkir/export/excel", {
                    dataFilter: this.formFilter,
                    dataListParkir: this.in_parkir,
                    dataListParkir: this.in_parkir,
                    totalAktifParkirKAll: this.totalAktifParkirKAll,
                    totalParkirKeluarAll: this.totalParkirKeluarAll,
                    totalPendapatanAll: this.totalPendapatanAll,
                })
                .then((response) => {
                    window.location = response.data.data;
                    this.$toast.df200();
                })
                .catch((e) => {
                    this.$toast.df500();
                });
        },
        showModalFormFilterByDate() {
            this.modalFilterByDate.show();
        },

        loadingData(argLoading) {
            if (argLoading) {
                this.loading_in_parkir = true;
                this.in_parkir = {};
            } else {
                this.loading_in_parkir = false;
            }
        },

        advanceFilter() {
            this.loadingData(true);
            this.modalFilterByDate.hide();
            this.$toast.df102("Proses filter");
            this.formFilter
                .get("/api/parkir")
                .then((response) => {
                    this.loadingData(false);
                    this.$toast.df200();
                    let responseData = response.data.data;
                    this.in_parkir = responseData.in_parkir.data;
                    this.totalAktifParkirKAll =
                        responseData.totalAktifParkirKAll;
                    this.totalParkirKeluarAll =
                        responseData.totalParkirKeluarAll;
                    this.totalPendapatanAll = responseData.totalPendapatanAll;
                })
                .catch((e) => {
                    this.loadingData(false);
                    this.$toast.df500();
                    console.log(e);
                });
        },
        cariKendaran() {
            this.$toast.df102("Melakukan Pencarian");
            this.formPencarian
                .get("/api/parkir")
                .then((response) => {
                    this.$toast.df200();
                    let responseData = response.data.data;
                    this.in_parkir = responseData.in_parkir.data;
                    this.totalAktifParkirKAll =
                        responseData.totalAktifParkirKAll;
                    this.totalParkirKeluarAll =
                        responseData.totalParkirKeluarAll;
                    this.totalPendapatanAll = responseData.totalPendapatanAll;
                })
                .catch((e) => {
                    this.$toast.df500();
                    console.log(e);
                });
        },
        loadIndexParkir() {
            this.formFilter.reset();

            this.in_parkir = {};
            this.loading_in_parkir = true;
            axios
                .get("/api/parkir")
                .then((response) => {
                    this.loading_in_parkir = false;
                    let responseData = response.data.data;
                    this.in_parkir = responseData.in_parkir.data;

                    this.totalAktifParkirKAll =
                        responseData.totalAktifParkirKAll;
                    this.totalParkirKeluarAll =
                        responseData.totalParkirKeluarAll;
                    this.totalPendapatanAll = responseData.totalPendapatanAll;
                })
                .catch((e) => {
                    this.loading_in_parkir = false;
                    console.log(e);
                });
        },
    },
};
</script>
