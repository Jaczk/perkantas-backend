<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProcurementController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $id = $request->input('id');
            $goods = $request->input('goods_name');
            $period = $request->input('period');
            $limit = $request->input('limit', 10);

            $procurementQuery = Procurement::with(['user'])->whereHas('user', function ($query) {
                $query->where('user_id', Auth::user()->id);
            });

            //Get Single Procurement data
            if ($id) {
                $procurement = $procurementQuery->find($id);

                if ($procurement) {
                    return ResponseFormatter::success(
                        $procurement,
                        'Data pengadaan berhasil diambil'
                    );
                    return ResponseFormatter::error(
                        null,
                        'Data pengadaan tidak berhasil diambil',
                        404
                    );
                }
            }

            //Get All Procurement data
            $procurements = $procurementQuery;

            if ($goods) {
                $procurements->where('goods_name', $goods);
            }

            if ($period) {
                $procurements->where('period', $period);
            }

            return ResponseFormatter::success(
                $procurements->paginate($limit),
                'Data list pengadaan berhasil diambil'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Pengambilan Data Pengadaan Gagal', 500);
        }
    }

    public function create(Request $request)
    {
        try {
            //Create new Procurement
            $procurement = Procurement::create([
                'user_id' => Auth::user()->id,
                'goods_name' => $request->input('goods_name'),
                'goods_amount' => $request->input('goods_amount'),
                'period' => Carbon::now()->format('Ym'),
                'description' => $request->input('description'),
            ]);

            if (!$procurement) {
                return ResponseFormatter::error(
                    null,
                    'Pembuatan data pengadaan gagal',
                    500
                );
            }

            return ResponseFormatter::success(
                $procurement,
                'Pembuatan data pengadaan berhasil'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Pembuatan Data Pengadaan Gagal', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $procurement = Procurement::find($id);

            $procurement->update(
                [
                    'goods_name' => $request->input('goods_name'),
                    'goods_amount' => $request->input('goods_amount'),
                    'period' => Carbon::now()->format('Ym'), // 'period' => $request->input('period'), // 'period' => '202107
                    'description' => $request->input('description'),
                ]
            );

            if (!$procurement) {
                return ResponseFormatter::error(
                    null,
                    'Data pengadaan tidak ditemukan',
                    404
                );
            }

            return ResponseFormatter::success(
                $procurement,
                'Data pengadaan berhasil diubah'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Pengubahan Data Pengadaan Gagal', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $procurement = Procurement::find($id);

            if (!$procurement) {
                return ResponseFormatter::error(
                    null,
                    'Data pengadaan tidak ditemukan',
                    404
                );
            }

            $procurement->delete();

            return ResponseFormatter::success(
                $procurement,
                'Data pengadaan berhasil dihapus'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Penghapusan Data Pengadaan Gagal', 500);
        }
    }
}
