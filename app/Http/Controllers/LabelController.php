<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LabelController extends Controller
{
    //
    public function index()
    {
        return response()->json(Label::all(), 200);
    }
    public function show($id) {
        $label = Label::find($id);
        if (!$label) {
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json(['data' => $label], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'desc' => 'nullable|string',
            'pic' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('pic');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        // Simpan ke direktori: public/assets
        $file->move(public_path('assets'), $nama_file);
        $label = Label::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'pic' => 'assets/' . $nama_file,
        ]);
        return response()->json(['message' => 'Berhasil!', 'data' => $label], 201);
    }
    
    // Update Data
    public function update(Request $request, $id) {
        $label = Label::find($id);
        if(!$label) return response()->json(['message' => 'Tidak ditemukan'], 404);

        $validated = $request->validate([
            'name' => 'required|string',
            'desc' => 'nullable|string',
            'pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('pic')) {
            // Hapus gambar lama jika ada
            File::delete(public_path($label->pic));
            $file = $request->file('pic');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('assets'), $nama_file);
            $label->pic = 'assets/' . $nama_file;
        }

        $label->update([
            'name' => $request->name ?? $label->name,
            'desc' => $request->desc ?? $label->desc,
            'pic' => $request->pic ?? $label->pic,
        ]);

        return response()->json(['message' => 'Berhasil Update!', 'data' => $label, 'put' => $request->all()]);
    }
    // Hapus Data
    public function destroy($id) {
        $label = label::find($id);
        if($label) {
            File::delete(public_path($label->pic));
            $label->delete();
            return response()->json(['message' => 'Terhapus!']);
        }
        return response()->json(['message' => 'Gagal'], 404);
    }
}
