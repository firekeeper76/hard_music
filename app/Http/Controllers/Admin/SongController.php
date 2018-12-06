<?php

namespace App\Http\Controllers\Admin;

use App\Album;
use App\Category;
use App\Song;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class SongController extends Controller
{
    public function song(Request $request)
    {
        $artist_id = $request->get('artist_id');
        return view('admin.song.song', ['artist_id' => $artist_id]);
    }

    public function getSong(Request $request)
    {
        $artist_id = $request->get('artist_id');
        $name = $request->get('name');
        if ($name) {
            $songs = Song::where('artist_id', $artist_id)->where('name', 'like', "%$name%")->get();
        } else {
            $songs = Song::where('artist_id', $artist_id)->get();
        }

        foreach ($songs as $key => $value) {
            if ($value->album_id) {
                $songs[$key]['album_name'] = $value->album->name;
            }
        }
        return response()->json(array(
            'code' => 0,
            'msg' => "",
            'count' => 1,
            'data' => $songs,
        ));
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (Song::where('id', $data['id'])->update($data)) {
                $result['StateCode'] = 100;
            } else {
                $result['StateCode'] = 200;
            }
            return response()->json($result);

        }
        $song = Song::find($request->get('id'));
        $albums = Album::where('artist_id', $song->artist_id)->get();
        $tags = (new Tag())->tree();
        return view('admin.song.song-update', ['song' => $song, 'tags' => $tags, 'albums' => $albums]);
    }


    public function upload(Request $request)
    {
        $data = $request->except('song');
//        $song = $request->file('song');
//        $song = $request->file('song')->store('/public/uploads/music/' . date('Ymd') );
//        $check = Storage::url($song);
        $song = $request->file('song');
        $data['name'] = explode('.', $song->getClientOriginalName())[0];
        $oname = $song->getClientOriginalExtension();
        $full_name = md5(uniqid()) . '.' . $oname;
        $path = "uploads/music/" . date('Ymd');
        $song->move(base_path() . '/public/' . $path, $full_name);
        $data['file_src'] = $path . '/' . $full_name;
        if (Song::create($data)) {
            $result['code'] = 0;
        }

        return response()->json($result);
    }

    public function del(Request $request)
    {
        if (Song::destroy($request->get('id'))) {
            $result['StateCode'] = 100;
        } else {
            $result['StateCode'] = 200;
        }
        return response()->json($result);
    }


}
