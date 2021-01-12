<?php

namespace App\Http\Controllers;

use App\Item;
use App\Rules\Base64Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:256',
            'harga' => 'required|integer',
            'filename' => 'required|string|max:256',
            'photofile' => ['required', 'string', new Base64Image(8192)]
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => "error", 'message' => $validator->errors()], 401);
        }

        $judul = $request->input('judul');
        $harga = $request->input('harga');
        $filename = $request->input('filename');
        $photofile = $request->input('photofile');

        Storage::put('public/items/' . $filename, base64_decode($photofile));
        // $request->file('photofile')->storeAs('public/photos', $filename);
        Item::create([
            'user_id' => 1,
            'judul' => $judul,
            'harga' => $harga,
            'filename' => $filename,
            'path' => 'storage/items/' . $filename
        ]);
        return response()->json(['status' => "success", 'message' => "Item tersimpan"], 201);
    }

    public function show($id)
    {
        $data = Item::find($id);
        return response()->json(['status' => "success", 'data' => $data], 200);
    }

    public function list()
    {
        $data = Item::all();
        return response()->json(['status' => "success", 'data' => $data], 200);
    }

    public function toko($id)
    {
        $data = Item::where('user_id', $id)->get();
        return response()->json(['status' => "success", 'data' => $data], 200);
    }
}
