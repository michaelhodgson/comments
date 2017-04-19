<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Models\Comment;

class PageController extends Controller
{

    public function index()
    {
//             $data=Comment::getComments();
// dd($data);
        return view( 
            'page.index',
            [
                'comments' => Comment::getComments()
            ]
        );
    }
}
