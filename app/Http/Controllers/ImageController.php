<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\UploadedFile;

class ImageController extends Controller
{

  public function getImageInput(){
    return view('posts.image_input');
  }

  public function postImageConfirm(Request $request){
    // dd($request);
    $post_data = $request->except('imagefile');
    $imagefile = $request->file('imagefile');

    $temp_path = $imagefile->store('public/temp');
    $read_temp_path = str_replace('public/', 'storage/img/public/', $temp_path);//
    $product_name = $post_data['product_name'];
// dd($read_temp_path);
    $data = array(
        'temp_path' => $temp_path,
        'read_temp_path' => $read_temp_path, //追加
        'product_name' => $product_name,
    );
    $request->session()->put('data', $data);
    return view('posts.image_confirm', compact('data') );
  }

  public function postImageComplete(Request $request) {
    $data = $request->session()->get('data');
    $temp_path = $data['temp_path'];
    $read_temp_path = $data['read_temp_path'];
    $filename = str_replace('public/temp/', '', $temp_path);
    //ファイル名は$temp_pathから"public/temp/"を除いたもの
    $storage_path = 'public/productimage/'.$filename;
    //画像を保存するパスは"public/productimage/xxx.jpeg"

    $request->session()->forget('data');

    Storage::move($temp_path, $storage_path);
    //Storageファサードのmoveメソッドで、第一引数->第二引数へファイルを移動

    $read_path = str_replace('public/', 'storage/img/public/', $storage_path);
    //商品一覧画面から画像を読み込むときのパスはstorage/productimage/xxx.jpeg"
    $product_name = $data['product_name'];
    // dd($read_path);
    $post = new Post();
    $post->imageurl = $read_path;
    $post->title = '';
    $post->body = '';
    $post->save();
    // $this->productcontroller->path = $read_path;
    // $this->productcontroller->product_name = $product_name;
    // $this->productcontroller->save();
    return view('posts.image_complete')->with('path',$read_path);
    // return view('posts.index');
  }
}
