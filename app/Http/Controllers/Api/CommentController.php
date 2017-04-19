<?php
namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Models\Comment;

/*
*	Comment API for javascript calls
*/

class CommentController extends Controller
{
    public function index()
    {
        return response()->json( Comment::getComments() );
    }

    public function store( Request $request )
    {
    	$this->validate( $request, Comment::$rules );

    	$data = Comment::sanitize( $request->all() );

    	try
    	{
    		$comment = Comment::create( $data );
    	}
    	catch ( \Exception $e )
		{
			return response()->json([ 
				'status' => 'error', 
				'message' => $e->getMessage()//'comment could not be saved' 
			]);
                
		}
    	
		return response()->json([ 
			'status' => 'success', 
			'data' => $comment->toArray() 
		]);
    }
}
