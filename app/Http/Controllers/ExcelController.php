<?php

namespace App\Http\Controllers;

use App\Imports\CustomImport;
use App\Models\Customer;
use App\Models\Installations;
use App\Models\Package;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index()
    {
        $path = storage_path('app/public/migrasi/pamsides');

        $files = [];
        if (is_dir($path)) {
            $files = array_diff(scandir($path), ['..', '.']);
        }

        $filePath = [];
        foreach ($files as $file) {
            $filePath[pathinfo($file, PATHINFO_FILENAME)] = './storage/migrasi/pamsides/' . $file;
        }

        $filename = 'usages';
        $businessId = 1;
        $excelData = Excel::toArray(new CustomImport, $filePath[$filename])[0];

        $this->$filename($businessId, $excelData);
    }

    public function customers($businessId, $excelData)
    {
        $now = date('Y-m-d H:i:s');
        $dataKey = $excelData[0];

        foreach ($excelData as $index => $data) {
            $queryInsert = "";
            if ($index == 0) {
                $queryInsert .= "DELETE FROM customers WHERE business_id='$businessId'; \n";
            } else {
                $data = array_combine($dataKey, $data);
                $copyData = $data;

                if (is_int($data['tgl_lahir'])) {
                    $timestamp = ($data['tgl_lahir'] - 25569) * 86400;
                    $data['tgl_lahir'] = gmdate("Y-m-d", $timestamp);
                }

                $data['id'] = null;
                $data['foto'] = $copyData['id'];
                $data['business_id'] = $businessId;
                $data['created_at'] = $now;
                $data['updated_at'] = $now;

                $queryInsert = $this->queryBuild($queryInsert, $data, 'customers');
            }

            echo $queryInsert . "\n";
        }
    }

    public function installations($businessId, $excelData)
    {
        $now = date('Y-m-d H:i:s');
        $dataKey = $excelData[0];

        $customers = Customer::where('business_id', $businessId)->pluck('id', 'foto')->toArray();
        $package = Package::where('business_id', $businessId)->pluck('id', 'abodemen')->toArray();
        foreach ($excelData as $index => $data) {
            $queryInsert = "";
            if ($index == 0) {
                $queryInsert .= "DELETE FROM installations WHERE business_id='$businessId'; \n";
            } else {
                $data = array_combine($dataKey, $data);
                $copyData = $data;

                if (is_int($data['order'])) {
                    $timestamp = ($data['order'] - 25569) * 86400;
                    $data['order'] = gmdate("Y-m-d", $timestamp);
                }

                if (is_int($data['pasang'])) {
                    $timestamp = ($data['pasang'] - 25569) * 86400;
                    $data['pasang'] = gmdate("Y-m-d", $timestamp);
                }

                if (is_int($data['aktif'])) {
                    $timestamp = ($data['aktif'] - 25569) * 86400;
                    $data['aktif'] = gmdate("Y-m-d", $timestamp);
                }

                if (is_int($data['blokir'])) {
                    $timestamp = ($data['blokir'] - 25569) * 86400;
                    $data['blokir'] = gmdate("Y-m-d", $timestamp);
                }

                if (is_int($data['cabut'])) {
                    $timestamp = ($data['cabut'] - 25569) * 86400;
                    $data['cabut'] = gmdate("Y-m-d", $timestamp);
                }

                $data['id'] = null;
                $data['koordinate'] = $copyData['id'];
                $data['customer_id'] = (isset($customers[$copyData['customer_id']])) ? $customers[$copyData['customer_id']] : null;
                $data['package_id'] = (isset($package[$copyData['package_id']])) ? $package[$copyData['package_id']] : 1;
                $data['pasang'] = (isset($copyData['pasang'])) ? $data['pasang'] : $data['order'];
                $data['aktif'] = (isset($copyData['aktif'])) ? $data['aktif'] : $data['pasang'];
                $data['blokir'] = (isset($copyData['blokir'])) ? $data['blokir'] : $data['aktif'];
                $data['cabut'] = (isset($copyData['cabut'])) ? $data['cabut'] : $data['blokir'];
                $data['business_id'] = $businessId;
                $data['created_at'] = $now;
                $data['updated_at'] = $now;

                $queryInsert = $this->queryBuild($queryInsert, $data, 'installations');
            }

            echo $queryInsert . "\n";
        }
    }

    public function usages($businessId, $excelData)
    {
        $now = date('Y-m-d H:i:s');
        $dataKey = $excelData[0];

        $installations = Installations::where('business_id', $businessId)->pluck('id', 'koordinate')->toArray();
        $customers = Installations::where('business_id', $businessId)->pluck('customer_id', 'koordinate')->toArray();
        foreach ($excelData as $index => $data) {
            $queryInsert = "";
            if ($index == 0) {
                $queryInsert .= "DELETE FROM usages WHERE business_id='$businessId'; \n";
            } else {
                $data = array_combine($dataKey, $data);
                $copyData = $data;

                if (is_int($data['tgl_pemakaian'])) {
                    $timestamp = ($data['tgl_pemakaian'] - 25569) * 86400;
                    $data['tgl_pemakaian'] = gmdate("Y-m-d", $timestamp);
                }

                if (is_int($data['tgl_akhir'])) {
                    $timestamp = ($data['tgl_akhir'] - 25569) * 86400;
                    $data['tgl_akhir'] = gmdate("Y-m-d", $timestamp);
                }

                $data['id'] = null;
                $data['id_instalasi'] = (isset($installations[$copyData['id_instalasi']])) ? $installations[$copyData['id_instalasi']] : null;
                $data['customer'] = (isset($customers[$copyData['id_instalasi']])) ? $customers[$copyData['id_instalasi']] : null;
                $data['business_id'] = $businessId;
                $data['created_at'] = $now;
                $data['updated_at'] = $now;

                $queryInsert .= $this->queryBuild($queryInsert, $data, 'usages');
            }

            echo $queryInsert . "\n";
        }
    }

    function queryBuild($queryInsert, $data, $tb)
    {
        $queryInsert = "INSERT INTO $tb (" . implode(', ', array_map(function ($value) {
            return "`" . $value . "`";
        }, array_keys($data))) . ") VALUES (" .
            implode(', ', array_map(function ($value) {
                return "'" . $value . "'";
            }, $data)) . "); ";
        $queryInsert = str_replace("''", 'NULL', $queryInsert);
        $queryInsert = str_replace("'NULL'", 'NULL', $queryInsert);

        return $queryInsert;
    }
}
