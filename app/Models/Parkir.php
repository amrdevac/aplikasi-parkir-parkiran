<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parkir extends Model
{
    use HasFactory;

    public static $selectColumnParkirDefault = [
        "parkirs.id",
        "parkirs.no_polisi",
        "parkirs.jenis_kendaraan",
        "parkirs.total",
        "parkirs.status",
        "parkirs.id_user",
        "parkirs.created_at",
        "parkirs.updated_at",
        "users.name",
    ];


    public static function queryGetAllDataParkir(
        $argAdditionalSelectedColumn = [],
        $argRequest,
        $withFitler = false
    ) {
        $selectedColumn =  self::$selectColumnParkirDefault;
        if (!empty($argAdditionalSelectedColumn)) {
            $selectedColumn =  array_merge($selectedColumn, $argAdditionalSelectedColumn);
        }

        $queryInParkir =   DB::table('parkirs')
            ->join("users", "users.id", "=", "parkirs.id_user")
            ->leftJoin("parking_payments", "parkirs.uuid_parkir", "=", "parking_payments.uuid_parkir")
            ->select($selectedColumn)
            ->orderBy("created_at", "DESC");

        if ($withFitler) {

            if ($argRequest->no_polisi) {
                $queryInParkir->where("no_polisi", $argRequest->no_polisi);
            }

            if ($argRequest->status_parkir != "") {
                $queryInParkir->where("status", $argRequest->status_parkir);
            }

            if ($argRequest->sejak_tgl) {
                $queryInParkir->whereDate('parkirs.created_at', '>=', $argRequest->sejak_tgl)
                    ->whereDate('parkirs.created_at', '<=', $argRequest->hingga_tgl);
            }
        }
        return $queryInParkir;
    }
}
