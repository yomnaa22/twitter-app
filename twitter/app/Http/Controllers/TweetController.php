<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class TweetController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tweets = Tweet::get();
        return response()->json($tweets,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validation($request);
        if($validation instanceof Response){
            return $validation;
        }
        $user=User::find($request->user_id);
        if($user){
            $tweet = Tweet::create([
                'user_id'=>$request->user_id,
                'description'=>$request->description,
                'tag'=>$request->tag,
                'img'=>$request->img,
                
            ]);
            return response()->json($tweet,201);
        }
        else{
            return response()->json(['message'=>'user not found'],404);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tweet = Tweet::find($id);
        return response()->json($tweet,200);
    }


    public function showByUser($u_id)
    {
        $tweets = Tweet::where('user_id',$u_id)->get();
        return response()->json($tweets,200);
    }

    public function userWithtweet($t_id)
    {
        $data = DB::table('users')
     
        ->join('tweets','users.id' , '=','tweets.user_id')
        ->where('tweets.id', '=', $t_id)
        ->select( 'users.fname','users.username','users.img','tweets.*',)
       ->get();
       return response()->json($data,200);
    }

    public function followingsTweet($u_id)
    {
        $followingTweet = DB::table('follows')
      
        ->join('tweets','follows.following_user_id' , '=','tweets.user_id')
        ->join('users', 'users.id', '=', 'follows.following_user_id')
        ->where('follows.user_id', '=', $u_id)
        ->select( 'tweets.*','users.fname','users.username')
       ->get();
       return response()->json($followingTweet,200);
    }

//     $exam = DB::table('exams')
//     ->join('courses', 'courses.id', '=', 'exams.course_id')
//     ->join('questions','exams.id' , '=','questions.exam_id')
//     ->where('courses.id', '=', $c_id)
//     ->select( 'exams.*','questions.*',)
//    ->get();
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tweet $tweet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tweet = Tweet::find($id);
        if($tweet){
            $tweet->delete();
            return response()->json(['message'=>'deleted'],200);
        }
        else{
            return response()->json(['message'=>'not found'],404);
        }
    }

    public function validation($request){
        return $this->apiValidation($request, [
            'description' => 'required|string|max:255',
            'tag' => 'string|max:30',
            'likes' => 'integer',
            'retweets' => 'integer',
            'img' => 'image|mimes:jpeg,png',
            'Is_bookmarked' => 'boolean',
            'Is_liked' => 'boolean',
            'Is_retweeted' => 'boolean',
            'user_id' => 'required|integer|exists:users,id',
        ]);
    }
}
