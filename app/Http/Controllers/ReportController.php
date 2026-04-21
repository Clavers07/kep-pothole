<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    //
    public function index()
    {
        return response()->json(Report::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pic' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jalan' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'priority' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:issued,processed,finished',
            'user_id' => 'required|integer|exists:users,id',
            'desc' => 'nullable|string'
        ]);

        $file = $request->file('pic');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        // Simpan ke direktori: public/assets
        $file->move(public_path('assets'), $nama_file);
        $report = Report::create([
            'pic' => 'assets/' . $nama_file,
            'jalan' => $request->jalan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'priority' => $request->priority,
            'status' => $request->status,
            'user_id' => $request->user_id,
            'desc' => $request->desc,
        ]);
        return response()->json(['message' => 'Berhasil!', 'data' => $report], 201);
    }
    
    // Update Data
    public function update(Request $request, $id) {
        $report = Report::find($id);
        if(!$report) return response()->json(['message' => 'Tidak ditemukan'], 404);

        $validated = $request->validate([
            'pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jalan' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'priority' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:issued,processed,finished',
            'user_id' => 'required|integer|exists:users,id',
            'desc' => 'nullable|string'
        ]);

        if ($request->hasFile('pic')) {
            // Hapus gambar lama jika ada
            File::delete(public_path($report->pic));
            $file = $request->file('pic');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('assets'), $nama_file);
            $report->pic = 'assets/' . $nama_file;
        }

        $report->update([
            'pic' => $request->pic ?? $report->pic,
            'jalan' => $request->jalan ?? $report->jalan,
            'latitude' => $request->latitude ?? $report->latitude,
            'longitude' => $request->longitude ?? $report->longitude,
            'priority' => $request->priority ?? $report->priority,
            'status' => $request->status ?? $report->status,
            'user_id' => $request->user_id ?? $report->user_id,
            'desc' => $request->desc ?? $report->desc,
        ]);

        return response()->json(['message' => 'Berhasil Update!', 'data' => $report, 'put' => $request->all()]);
    }
    // Hapus Data
    public function destroy($id) {
        $report = report::find($id);
        if($report) {
            File::delete(public_path($report->pic));
            $report->delete();
            return response()->json(['message' => 'Terhapus!']);
        }
        return response()->json(['message' => 'Gagal'], 404);
    }
}
