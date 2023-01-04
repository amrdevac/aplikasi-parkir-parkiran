<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Http\Util\ResponseUtil;
use App\Http\Service\VerifyService;
use App\Http\Service\ParkingService;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ParkingController extends Controller
{

    private ParkingService $parkirService;
    private VerifyService $verifyService;

    public function __construct()
    {
        $this->parkirService = new ParkingService;
        $this->verifyService = new VerifyService;
    }

    public function index(Request $request)
    {
        $result = $this->parkirService->getAllDataParkir($request);
        return ResponseUtil::applyJson($result);
    }

    public function indexWithLimit(Request $request)
    {
        $result = $this->parkirService->getLatestDataParkirWithLimit(10);
        return ResponseUtil::applyJson($result);
    }

    public function detail(Request $request)
    {
        $this->validate($request, [
            "kode_unik" => "required",
        ]);
        $result = $this->parkirService->findDataByUUID($request->kode_unik);
        $objectDataParkir =  $result["data"]["parkir"];

        $parkingSince =  new DateTime($objectDataParkir->created_at);
        $now = new DateTime();
        $date_tiff = $now->diff($parkingSince, true);

        $total_days = $date_tiff->days;
        $hours      = $date_tiff->h;
        if ($total_days !== FALSE) {
            $hours += 24 * $total_days;
        }
        $minutes    = $date_tiff->i;

        if ($minutes > 0) {
            $hours += 1;
        }
        $totalAmount = $hours *  $objectDataParkir->total;
        $result["data"] = array_merge($result["data"], compact("totalAmount", "hours"));
        return ResponseUtil::applyJson($result);
    }

    public function showUniqueUUID(Request $request)
    {
        VerifyService::byPassword($request);
        $dataParkir = $this->parkirService->findDataById($request->parkir_id);
        return ResponseUtil::applyJson($dataParkir);
    }

    public function paymentCash(Request $request)
    {
        $dataParkir = $this->parkirService->paymentCash($request);
        return ResponseUtil::applyJson($dataParkir);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "tarif" => "required",
            "no_polisi" => "required",
            "jenis_kendaraan" => "required",
        ]);

        $result = $this->parkirService->saveSingleDataParkir($request);
        return ResponseUtil::applyJson($result);
    }

    public function exportExcel(Request $request)
    {

        $styleFontBold = [
            'font' => [
                'bold' => true,
            ],
        ];

        $styleBorderFull = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        $vhCentered = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        $spreadsheet = new Spreadsheet();;
        foreach (range("A", "Z") as $value) {
            $spreadsheet->getActiveSheet()->getColumnDimension($value)->setAutoSize(true);
        }

        $spreadsheet->getActiveSheet()->mergeCells('B2:O3');
        $spreadsheet->getActiveSheet()->mergeCells('B5:D5');

        $spreadsheet->getActiveSheet()->mergeCells('B9:D9');

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('B2', 'LAPORAN DATA PARKIR');

        $sheet->setCellValue('B5', 'Filter Aktif');
        $sheet->setCellValue('B6', 'Periode Dari');
        $sheet->setCellValue('B7', $request["dataFilter"]["sejak_tgl"] ?? "-");


        $sheet->setCellValue('C6', 'Periode Hingga');
        $sheet->setCellValue('C7', $request["dataFilter"]["hingga_tgl"] ?? "-");


        $sheet->setCellValue('D6', 'Status Parkir');
        $sheet->setCellValue('D7', $request["dataFilter"]["status_parkir"] ?? "-");


        $sheet->setCellValue('B9', 'Jumlah Total');
        $sheet->setCellValue('B10', 'Pendapatan');
        $sheet->setCellValue('B11', $request["totalPendapatanAll"] ?? "-");

        $sheet->setCellValue('C10', 'Aktif Parkir');
        $sheet->setCellValue('C11', $request["totalAktifParkirKAll"] ?? "-");

        $sheet->setCellValue('D10', 'Keluar Parkir');
        $sheet->setCellValue('D11', $request["totalParkirKeluarAll"] ?? "-");


        $sheet->setCellValue('F5', 'No');
        $sheet->setCellValue('G5', 'Nomor Polisi');
        $sheet->setCellValue('H5', 'Jenis');
        $sheet->setCellValue('I5', 'Tarif');
        $sheet->setCellValue('J5', 'In');
        $sheet->setCellValue('K5', 'Out');
        $sheet->setCellValue('L5', 'Waktu');
        $sheet->setCellValue('M5', 'Pembayaran');
        $sheet->setCellValue('N5', 'Status');
        $sheet->setCellValue('O5', 'Petugas');




        $startFrom = 6;
        $number = 1;


        foreach ($request->dataListParkir as $key => $value) {
            $sheet->setCellValue('F' . ($startFrom + $key), $number + intval($key));
            $sheet->setCellValue('G' . ($startFrom + $key), $value["no_polisi"]);
            $sheet->setCellValue('H' . ($startFrom + $key), $value["jenis_kendaraan"]);
            $sheet->setCellValue('I' . ($startFrom + $key), $value["total"]);
            $sheet->setCellValue('J' . ($startFrom + $key), $value["created_at"]);
            $sheet->setCellValue('K' . ($startFrom + $key), $value["waktu_pembayaran"] ?? "-");
            $sheet->setCellValue('L' . ($startFrom + $key), $value["total_waktu"]  ?? " - ");
            $sheet->setCellValue('M' . ($startFrom + $key), $value["total_pembayaran"] ?? 0);
            $sheet->setCellValue('N' . ($startFrom + $key), $value["status"]);
            $sheet->setCellValue('O' . ($startFrom + $key), $value["name"]);
        }


        $spreadsheet->getActiveSheet()->getStyle('B5:D7')->applyFromArray(array_merge(
            $styleBorderFull,
            $vhCentered,
        ));


        $spreadsheet->getActiveSheet()->getStyle('F5:O5')->applyFromArray(array_merge(
            $styleFontBold,
            $vhCentered,
        ));


        $spreadsheet->getActiveSheet()->getStyle('F6:O100')->applyFromArray(array_merge(
            $vhCentered,
        ));


        $spreadsheet->getActiveSheet()->getStyle('B9:D11')->applyFromArray(array_merge(
            $styleBorderFull,
            $vhCentered,
        ));



        $styleFontBold["font"]["size"] = 15;
        $spreadsheet->getActiveSheet()->getStyle('B2')->applyFromArray(array_merge(
            $styleFontBold,
            $vhCentered,
        ));


        $writer = new Xlsx($spreadsheet);
        $namaFile = "exportFiles/laporan_data_parking" . date("Y-m-d") . ".xlsx";
        $writer->save($namaFile);
        return ResponseUtil::applyJson(ResponseUtil::successArray("Berhasil Export", $namaFile));
    }
}
