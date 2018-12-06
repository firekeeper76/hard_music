<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Artist;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;

class ArtistController extends Controller
{
    public function artist(Request $request)
    {
        $category_id = $request->get('category_id');
        $keyword = $request->get('keyword');
        if ($keyword) {
            $artists = Artist::where('name', 'like', "%$keyword%")->paginate(20);
            $count = Artist::where('name', 'like', "%$keyword%")->count();
        } else {
            if ($category_id) {
                $artists = Artist::where('category_id', $category_id)->paginate(20);
                $count = Artist::where('category_id', $category_id)->count();
            } else {
                $artists = Artist::paginate(20);
                $count = Artist::count();
            }
        }


        $categorys = (new Category())->tree();
        return view('admin.artist.artist', ['categorys' => $categorys, 'artists' => $artists, 'count' => $count]);
    }

    public function getArtist(Request $request)
    {
        $result['artist'] = Artist::paginate(20);
        $result['count'] = Artist::count();
        return response()->json($result);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rule = [
                'name' => 'required|min:2|max:11|unique:artist',
                'category_id' => 'required|integer',
            ];
            $validator = Validator::make($data, $rule);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $result['StateCode'] = 201;
                $result['message'] = $errors->first();
                return response()->json($result);
            }

            if (Artist::create($data)) {
                $result = 100;
            } else {
                $result = 200;
            }
            return response()->json($result);
        }

        $categorys = (new Category())->tree();
        return view('admin.artist.artist-add', ['categorys' => $categorys]);
    }

    public function cover(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rule = [
                'name' => 'required|min:2|max:11|unique:artist',
                'category_id' => 'required|integer',
            ];
            $validator = Validator::make($data, $rule);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $result['StateCode'] = 201;
                $result['message'] = $errors->first();
                return response()->json($result);
            }

            if (Artist::create($data)) {
                $result = 100;
            } else {
                $result = 200;
            }
            return response()->json($result);
        }
        $artist = Artist::find($request->get('id'));
        return view('admin.artist.artist-cover', ['artist' => $artist]);
    }

    public function deleted(Request $request)
    {
        $category_id = $request->get('category_id');
        $keyword = $request->get('keyword');
        if ($keyword) {
            $artists = Artist::onlyTrashed()->where('name', 'like', "%$keyword%")->paginate(20);
            $count = Artist::onlyTrashed()->where('name', 'like', "%$keyword%")->count();
        } else {
            if ($category_id) {
                $artists = Artist::onlyTrashed()->where('category_id', $category_id)->paginate(20);
                $count = Artist::onlyTrashed()->where('category_id', $category_id)->count();
            } else {
                $artists = Artist::onlyTrashed()->paginate(20);
                $count = Artist::onlyTrashed()->count();
            }
        }

        $categorys = (new Category())->tree();
        return view('admin.artist.artist-deleted', ['categorys' => $categorys, 'artists' => $artists, 'count' => $count]);
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (Artist::where('id', $data['id'])->update($data)) {
                $result = 100;
            } else {
                $result = 200;
            }
            return response()->json($result);
        }
        $categorys = (new Category())->tree();
        $artist = Artist::find($request->get('id'));
        return view('admin.artist.artist-update', ['categorys' => $categorys, 'artist' => $artist]);
    }

    public function delCover(Request $request)
    {
        $cover = $request->get('cover');
        $avatar = $request->get('avatar');
        if (Storage::disk('local')->exists('public/' . $cover)) {//判断图片是否存在
            Storage::disk('local')->delete('public/' . $cover);
        }
        if (Storage::disk('local')->exists('public/' . $avatar)) {//判断图片是否存在
            Storage::disk('local')->delete('public/' . $avatar);
        }
    }

    public function del(Request $request)
    {
        if (Artist::destroy($request->get('id'))) {
            $result = 100;
        } else {
            $result = 200;
        }
        return response()->json($result);
    }

    public function restore(Request $request)
    {
        if (Artist::withTrashed()->find($request->get('id'))->restore()) {
            $result = 100;
        } else {
            $result = 200;
        }
        return response()->json($result);
    }

    public function forceDelete(Request $request)
    {
        $artist = Artist::withTrashed()->find($request->get('id'));
        $cover = $artist->cover;
        $avatar = $artist->avatar;
        if ($artist->forceDelete()) {
            if (Storage::disk('local')->exists('public/' . $cover)) {//判断图片是否存在
                Storage::disk('local')->delete('public/' . $cover);
            }
            if (Storage::disk('local')->exists('public/' . $avatar)) {//判断图片是否存在
                Storage::disk('local')->delete('public/' . $avatar);
            }
            $result = 100;
        } else {
            $result = 200;
        }
        return response()->json($result);
    }

    public function detail(Request $request)
    {
        $artist = Artist::find($request->get('id'));
        return view('admin.artist.detail', ['artist' => $artist]);
    }


}
