<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Cater;
use App\Models\Customer;
use App\Models\Installations;
use App\Models\Settings;
use App\Models\Usage;
use App\Models\User;
use App\Utils\Keuangan;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class UsageController extends Controller
{

    public function index()
    {
        $usages = Usage::with([
            'customers',
            'installation'
        ])->orderBy('created_at', 'DESC')->get();

        $title = 'Data Pemakaian';
        return view('penggunaan.index')->with(compact('title', 'usages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // where('status','A')->
        $customer = Installations::with('customer')->orderBy('id', 'ASC')->get();
        $caters = Cater::all();
        $usages = Usage::all();
        $installasi = Installations::orderBy('id', 'ASC')->get();
        $pilih_customer = 0;

        $title = 'Register Pemakaian';
        return view('penggunaan.create')->with(compact('customer', 'pilih_customer', 'caters', 'title', 'usages'));
    }

    public function store(Request $request)
    {

        $keuangan = new Keuangan;

        $data_id = [];
        $data_customer = [];
        foreach ($request->data as $data) {
            $data_id[] = $data['id'];
            $data_customer[] = $data['customer'];
        }

        $data_installation = [];
        $installations = Installations::whereIn('id', $data_id)->with([
            'package'
        ])->get();
        foreach ($installations as $ins) {
            $data_installation[$ins->id] = $ins->package->harga;
        }

        $created_at = date('Y-m-d H:i:s');
        $setting = Settings::where('business_id', Session::get('business_id'))->first();
        $bisnis = Business::where('id', Session::get('business_id'))->first();
        $logo = $bisnis->logo;
        if (empty($logo)) {
            $gambar = '/storage/logo/1.png';
        } else {
            $gambar = '/storage/logo/' . $logo;
        }

        $customers = Customer::whereIn('id', $data_customer)->get();
        $data_customer = [];
        foreach ($customers as $cs) {
            $data_customer[$cs->id] = $cs;
        }

        $insert = [];
        $tanggal = Tanggal::tglNasional($request->tanggal);
        foreach ($request->data as $data) {
            $harga = json_decode($data_installation[$data['id']], true);

            $result = [];
            $block = json_decode($setting->block, true);
            foreach ($block as $index => $item) {
                preg_match_all('/\d+/', $item['jarak'], $matches);
                $start = (int)$matches[0][0];
                $end = (int)$matches[0][1];

                for ($i = $start; $i <= $end; $i++) {
                    $result[$i] = $index;
                }
            }

            $index_harga = (isset($result[$data['jumlah']])) ? $result[$data['jumlah']] : end($result);

            $insert[] = [
                'business_id' => Session::get('business_id'),
                'customer' => $data['customer'],
                'awal' => $data['awal'],
                'akhir' => $data['akhir'],
                'jumlah' => $data['jumlah'],
                'id_instalasi' => $data['id'],
                'tgl_akhir' => $tanggal,
                'nominal' => $harga[$index_harga],
                'cater' =>  $data['id_cater'],
                'user_id' => auth()->user()->id,
                'created_at' => $created_at,
                'updated_at' => $created_at
            ];
        }

        // Simpan data
        Usage::insert($insert);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'view' => view('penggunaan.partials.cetak_tagihan', ['usages' => (object) $insert, 'data_customer' => $data_customer, 'bisnis' => $bisnis, 'keuangan' => $keuangan, 'gambar' => $gambar])->render(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function carianggota(Request $request)
    {
        $query = $request->input('query');

        $customer = Customer::join('installations', 'customers.id', 'installations.customer_id')
            ->where('customers.nama', 'LIKE', '%' . $query . '%')
            ->orwhere('installations.kode_instalasi', 'LIKE', '%' . $query . '%')->get();

        $data_customer = [];
        foreach ($customer as $cus) {
            $usage = Usage::where('id_instalasi', $cus->id)->orderBy('created_at', 'DESC')->first();

            $data_customer[] = [
                'customer' => $cus,
                'usage' => $usage
            ];
        }


        return response()->json($data_customer);
    }


    public function detailTagihan()
    {
        $keuangan = new Keuangan;
        $usages = Usage::where('status', 'UNPAID')->with([
            'customers',
            'installation'
        ])->get();

        return [
            'label' => '<i class="fas fa-book"></i> ' . 'Detail Pemakaian Dengan Status <b>(UNPAID)</b>',
            'cetak' => view('penggunaan.partials.DetailTagihan', ['usages' => $usages])->render()
        ];
    }

    public function cetak(Request $request)
    {
        $keuangan = new Keuangan;
        $id = $request->cetak;

        $data['bisnis'] = Business::where('id', Session::get('business_id'))->first();
        $data['usage'] = Usage::whereIn('id', $id)->with(
            'customers'
        )->get();

        $logo = $data['bisnis']->logo;
        $data['gambar'] = $logo;
        $data['keuangan'] = $keuangan;

        $view = view('penggunaan.partials.cetak', $data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function show(Usage $usage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usage $usage)
    {
        $usages = Usage::with([
            'customers',
            'installation'
        ])->get();
        $title = 'Data Pemakaian';
        return view('penggunaan.edit')->with(compact('title', 'usage', 'usages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usage $usage)
    {
        $this->validate($request, [

            'tgl_akhir' => 'required|date'
        ]);

        // Mengubah format tanggal dari d/m/Y ke Y-m-d
        $tgl_akhir = \DateTime::createFromFormat('d/m/Y', $request->tgl_akhir)->format('Y-m-d');

        $usage->update([

            'tgl_akhir' => $tgl_akhir
        ]);

        return redirect('/usages')->with('berhasil', 'Usage berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usage $usage)
    {
        $usage->delete();
        return redirect('/usages')->with('success', 'Pemakaian berhasil dihapus');
    }
}
