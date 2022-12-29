<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Post;
use DB;
use Hash;
use Validator;
use Auth;
use App\Traits\UploadAble;

class PostController extends Controller
{
    use UploadAble;
    
    public function list(){
         return Post::with(['CreatorName'])->orderby('id','desc')->get();
    }
    
    public function store(Request $request){
         $rules = array(
            'description' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {
            $file = null;
            $type = "text";
            if ($request->has('file')) {
                
                
                $file = Input::file('file');;
                $mime = $file->getMimeType();
                
                if(strstr($mime, "video/")){
                    $type  = "video";
                }else if(strstr($mime, "image/")){
                    $type  = "image";
                }
                
                $file = $this->uploadOne($request->file, 'PostAttachment');
            }
            
            $post = new Post();
            $post->title = '$request->title';
            $post->description = $request->description;
            $post->filepath = $file;
            $post->type = $type;
            $post->created_by = auth()->user()->id;
            $post->save();
            
            
            return response()->json(['success' => 1, 'msg' => "Save Successfully"], 200);
            
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }
    }
    
    public function edit($id){
        return Post::find($id);
    }
    public function update(Request $request,$id){
         $rules = array(
            'title' => 'required',
            'description' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {
            
            
            $file = null;
            if ($request->has('file')) {
                $file = $this->uploadOne($request->file, 'PostAttachment');
            }
            
            
            $type = "";
            $post =  Post::find($id);
            $post = $request->title;
            $post = $request->description;
            $post = $file;
            $post = $type;
            $post = auth()->user()->id;
            $post->save();
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }
    }
    
    public function delete($id){
        Post::find($id)->delete();
        return redirect()->back();
    }
    
    
}
