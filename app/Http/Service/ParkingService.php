<?php

namespace App\Http\Service;

use App\Exceptions\FailException;
use App\Http\Util\DefaultValue;
use Illuminate\Support\Str;
use App\Http\Util\ResponseUtil;
use App\Models\Parkir;
use Illuminate\Support\Facades\DB;

class ParkingService
{
    public function getAllDataParkir($argRequest)
    {
        $parkingPaymentColumn = [
            "parking_payments.created_at as waktu_pembayaran",
            "parking_payments.total_pembayaran",
            "parking_payments.total_waktu",
        ];

        $selectedColumn =  array_merge(Parkir::$selectColumnParkirDefault, $parkingPaymentColumn);
        $queryInParkir = Parkir::queryGetAllDataParkir($parkingPaymentColumn, $argRequest, true);
        $in_parkir =  $queryInParkir->simplePaginate(9999);

        $totalAktifParkirKAll  = Parkir::queryGetAllDataParkir(
            $parkingPaymentColumn,
            $argRequest,
            true
        )->where("parkirs.status", 0)->count();

        $totalParkirKeluarAll  = Parkir::queryGetAllDataParkir(
            $parkingPaymentColumn,
            $argRequest,
            true
        )->where("parkirs.status", 1)->count();

        $totalPendapatanAll  = Parkir::queryGetAllDataParkir(
            $parkingPaymentColumn,
            $argRequest,
            true
        )->sum("total_pembayaran");

        $responseData = compact(
            "in_parkir",
            "totalAktifParkirKAll",
            "totalParkirKeluarAll",
            "totalPendapatanAll"
        );
        return ResponseUtil::successArray(null, $responseData);
    }

    public function getLatestDataParkirWithLimit($argLimit = 10)
    {
        $in_parkir = DB::table('parkirs')
            ->join("users", "users.id", "=", "parkirs.id_user")
            ->select(Parkir::$selectColumnParkirDefault)
            ->orderBy("created_at", "DESC")
            ->limit($argLimit)->get();
        return ResponseUtil::successArray(null, $in_parkir);
    }

    public function findDataById($argParamsIdParkir)
    {
        $parkir = DB::table('parkirs')
            ->where("id", $argParamsIdParkir)
            ->first();

        return ResponseUtil::successArray(null, $parkir);
    }


    public function paymentCash($argParamsPembayaran)
    {
        $insertToParkingPayment = [
            "total_pembayaran" => $argParamsPembayaran->total_amount,
            "total_waktu" => $argParamsPembayaran->hours,
            "metode_pembayaran" => "cash",
            "uuid_parkir" => $argParamsPembayaran->uuid_parkir,
            "id_user" => auth()->user()->id,
        ];
        $insertToParkingPayment  = array_merge(DefaultValue::arrTimestamps(), $insertToParkingPayment);
        DB::beginTransaction();
        DB::table('parkirs')
            ->updateOrInsert(
                ["uuid_parkir" => $argParamsPembayaran->uuid_parkir],
                ["status" => 1, "updated_at" => date("Y-m-d H:i:s")],
            );
        DB::table('parking_payments')
            ->insert($insertToParkingPayment);
        DB::commit();
        return ResponseUtil::successArray("Berhasil menerima pembayaran", []);
    }

    public function findDataByUUID($argParamsUUIDParkir)
    {
        $parkir = DB::table('parkirs')
            ->where("uuid_parkir", $argParamsUUIDParkir)
            ->first();

        if (empty($parkir)) {
            throw new FailException(
                ResponseUtil::failArray(
                    "Gagal mendapatkan data",
                    [],
                    400
                )
            );
        };

        return ResponseUtil::successArray("Berhasil", compact("parkir"));
    }

    public function saveSingleDataParkir($argRequestDataParkir)
    {

        $dataParkir = [
            "uuid_parkir" => Str::uuid(),
            "no_polisi" => $argRequestDataParkir->no_polisi,
            "jenis_kendaraan" => $argRequestDataParkir->jenis_kendaraan,
            "total" => 3000,
            "status" => 0,
            "id_user" => auth()->user()->id,
        ];
        $dataParkir = array_merge($dataParkir, DefaultValue::arrTimestamps());
        $in_parkir = DB::table('parkirs')->insert($dataParkir);
        return ResponseUtil::successArray("Berhasil menyimpan data", $in_parkir, 201);
    }
}
