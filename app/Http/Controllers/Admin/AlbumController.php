<?php

namespace App\Http\Controllers\Admin;

use App\Album;
use App\Song;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class AlbumController extends Controller
{
    /*
     * 按歌手id获取专辑列表
     * artist_id
     */
    public function album(Request $request){
        $artist_id = $request->get('id');
        $albums = Album::where('artist_id',$artist_id)->get();
        return view('admin.album.album',['albums'=>$albums,'artist_id'=>$artist_id]);
    }
    public function add(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            $rule = [
                'artist_id' => 'required|integer',
                'name' => 'required|min:2',
                'public_time'=>'required',
            ];
            $validator = Validator::make($data, $rule);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $result['StateCode'] = 201;
                $result['message'] = $errors->first();
                return response() -> json($result);
            }
            $album = Album::create($data);
            if($album){
                $result['StateCode'] = 100;
                $result['album_id'] = $album->id;
            }else{
                $result['StateCode'] = 200;
            }
            return response() -> json($result);
        }

        $artist_id = $request->get('id');
        $tags = (new Tag())->tree();
        return view('admin.album.album-add',['tags'=>$tags,'artist_id'=>$artist_id]);
    }

    /*
     * 获取专辑
     * album_id
     */
    public function detail(Request $request){
        $album = Album::find($request->get('id'));
        return view('admin.album.album-detail',['album'=>$album]);
    }

    /*
     * 获取专辑歌曲
     * album_id
     */
    public function song(Request $request){
        $songs = Song::where('album_id',$request->get('album_id'))->get();

        return response()->json(array(
            'code'=>0,
            'msg'=>"",
            'count'=> 1,
            'data' => $songs,
        ));
    }

    public function update(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rule = [
                'id' => 'required|integer',
                'name' => 'required|min:2',
            ];
            $validator = Validator::make($data, $rule);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $result['StateCode'] = 201;
                $result['message'] = $errors->first();
                return response() -> json($result);
            }

            if(Album::where('id',$data['id'])->update($data)){
                Song::where('album_id',$data['id'])->update(['tags'=>$data['tags']]);
                $result['StateCode'] = 100;
            }else{
                $result['StateCode'] = 200;
            }
            return response() -> json($result);

        }
        $album = Album::find($request->get('id'));
        $tags = (new Tag())->tree();
        return view('admin.album.album-update',['album'=>$album,'tags'=>$tags]);
    }

    public function cover(Request $request){
        $data = $request->all();
        $rule = [
            'id' => 'required|integer',
            'cover' => 'required',
        ];
        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $result['StateCode'] = 201;
            $result['message'] = $errors->first();
            return response() -> json($result);
        }
        if(Album::where('id',$data['id'])->update($data)){
            Song::where('album_id',$data['id'])->update(['cover'=>$data['cover']]);
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response() -> json($result);
    }

    public function del(Request $request){
        $id = $request->get('id');
        if(Album::destroy($id)){
            Song::where('album_id',$id)->delete();
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response() -> json($result);
    }

}
