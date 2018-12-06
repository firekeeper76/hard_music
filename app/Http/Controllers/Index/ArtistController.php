<?php

namespace App\Http\Controllers\Index;

use App\Album;
use App\Artist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtistController extends Controller
{
    public function artist(Request $request)
    {
        $id = $request->get('id');
        $artist = Artist::findOrFail($id);
        return view('index.artist.index', ['artist' => $artist]);
    }

    public function intro(Request $request)
    {
        $id = $request->get('id');
        $artist = Artist::find($id);
        return view('index.artist.intro', ['artist' => $artist]);
    }

    public function album(Request $request)
    {
        $id = $request->get('id');
        $artist = Artist::find($id);
        $albums = Album::where('artist_id', $id)->paginate(1);
        return view('index.artist.album', ['artist' => $artist, 'albums' => $albums]);
    }

}
