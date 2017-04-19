<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [	
        'parent_id',
        'depth',
        'name',
        'comment'     
    ];


    public static $rules = [
        'name' => 'required|max:255',
        'comment' => 'required',
        'depth' => 'required'
    ];

    public static $statuses = [
        'active' => 1,
        'pending' => 2,
        'deleted' => 3
    ];


    public static function getComments()
    {
    	$comments = Comment::orderBy( 'depth', 'ASC' )
            ->orderBy( 'created_at', 'ASC')
    		->get();

        // Sort results into a comment tree structure
        $parents = array();
        $children = array();
        $return = array();
        foreach( $comments AS $comment )
        {
            if( $comment->parent_id > 0 )
            {
                $children[ $comment->parent_id ][] = $comment->toArray();
            }
            else
            {
                $parents[] = $comment->toArray();
            }

        }

        foreach( $parents AS $parent )
        {
            $return[] = $parent;
            $return = Comment::getChildren( $children, $return, $parent['id'] );
        }

        return $return;
    }

    public static function sanitize( $data )
    {
        // This function could be easily altered to have a more complex sanitization, but for 
        // the purposes of preventing javascript injection in this exercise this will do.
        // 
        // Also, in a production environment this would be located in a more globalized location 
        // so it would be accessible to all models.

        $sanitized = array();

        foreach( $data AS $key => $value )
        {
            $sanitized[ $key ] = strip_tags( $value );
        }

        return $sanitized;
    }

    public static function getChildren( Array $children, Array $return, $id )
    {
        if( isset( $children[ $id ] ) )
        {
            foreach( $children[ $id ] AS $child )
            {
                $return[] = $child;
                $return = Comment::getChildren( $children, $return, $child['id'] );
            }
        }

        return $return;
    }
}
