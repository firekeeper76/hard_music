<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'setPlay',
        'collection_playlist',
        'comment',
        'getPlayListSong',
        'getAlbumSong',
        'getComment',
        'like',
        'collection',
        'create_playlist',
        'del_playlist_song',
        'del_playlist',
        'del_collection',
        'update_playlist',
        'test1',
        'ddpay'
    ];
}
