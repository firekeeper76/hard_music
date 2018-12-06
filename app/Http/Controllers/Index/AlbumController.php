<?php

namespace App\Http\Controllers\Index;

use App\Album;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlbumController extends Controller
{
    public function album(Request $request)
    {
        $id = $request->get('id');
        $album = Album::findOrFail($id);
        $comments_count = Comment::where('topic_type', 2)->where('topic_id', $id)->count();
        $other_album = Album::where('artist_id', $album->artist_id)->get();
        return view('index.album.album', ['album' => $album, 'comments_count' => $comments_count, 'other_album' => $other_album]);
    }
}
