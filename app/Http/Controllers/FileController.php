<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    private $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';

    public function index()
    {
        $uploads = Upload::all();
        return view('index', compact('uploads'));
    }

    public function create()
    {
        return view('uploadfile');
    }
    public function storeMedia(Request $request)
    {
        // validate
        request()->validate(
            [
                'name' => 'required',
                'file' => 'required|max:1000',//a required, max 10000kb, doc or docx file
            ],
            [
                'file.required' => 'You have to choose the file!',
                'name.required' => 'You have to choose valid file name!'
            ]
        );

        // rename
        $path = 'tmp/uploads/' . auth()->user()->id;
        $path = storage_path($path);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $name = $request->name . '.' . $request->file->extension();

        // encrypt
        $fileContent = file_get_contents($request->file->getRealPath());

        $encrypted_code = $this->my_encrypt($fileContent, $this->key);

        // store in location
        file_put_contents($path . '/' . $name, $encrypted_code);

        // save in database

        if ($request->file()) {
            $file = $request->file;
            $size = filesize($path);
            $extension = $file->extension();

            $file = Upload::create([
                'user_id' => auth()->user()->id,
                'name' => $name,
                'path' => 'tmp/uploads/' . auth()->user()->id,
                'size' => $size,
                'extension' => $extension,
            ]);

            return redirect('/upload');
        }
    }

    public function download($id)
    {
        $file_name = Upload::find($id)->name;
        $file_path = auth()->user()->id . '/' . $file_name;

        $fileContent = file_get_contents(storage_path('tmp/uploads/' . $file_path));
        $originalData = $this->my_decrypt($fileContent, $this->key);

        $downloadPath = storage_path('tmp/downloads/' . $file_name);

        if (!file_exists(storage_path('tmp/downloads/'))) {
            mkdir(storage_path('tmp/downloads/'), 0777, true);
        }

        file_put_contents($downloadPath, $originalData);

        return response()->download($downloadPath, $file_name)->deleteFileAfterSend(true);;

    }

    public function my_encrypt($data, $key)
    {
        $encryption_key = base64_decode($key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public function my_decrypt($data, $key)
    {
        $encryption_key = base64_decode($key);
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }
}