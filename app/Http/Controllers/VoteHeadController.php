<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VoteHead;
use App\Classes;
use Session;
class VoteHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $voteheads=VoteHead::all();
        $classes=Classes::all();
        return view('Voteheads.Index')
        ->with('classes',$classes)
        ->with('voteheads',$voteheads);
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
        $this->validate($request,[
            'Class'=>'required',
            'VoteHead'=>[
                'required',
                'unique:vote_heads'
            ]
        ]);
        VoteHead::create($request->all());
        Session::flash("success","VoteHead Successfully Added");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $votehead=VoteHead::find($id);
        if(empty($votehead)){
            Session::flash("error","The Votehead Does Not Exist");
            return redirect()->back();
        }
        $classes=Classes::all();
        return view("Voteheads.Edit")
        ->with('classes',$classes)
        ->with('votehead',$votehead);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'Class'=>'required',
            'VoteHead'=>'required'
        ]);
        $votehead=VoteHead::find($id);
        if(empty($votehead)){
            Session::flash("error","The Votehead Does Not Exist");
            return redirect()->back();
        }
        $votehead->Class=$request->Class;
        $votehead->VoteHead=$request->VoteHead;
        $votehead->save();
        Session::flash("success","the votehead successfully Updated");
        return redirect()->route('voteheads');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $votehead=VoteHead::find($id);
        if(empty($votehead)){
            Session::flash("error","The Votehead Does Not Exist");
            return redirect()->back();
        }
        $votehead->destroy($id);
        Session::flash("error","the votehead successfully Deleted");
        return redirect()->back();
    }
    public function suspend($id)
    {
        $votehead=VoteHead::find($id);
        if(empty($votehead)){
            Session::flash("error","The Votehead Does Not Exist");
            return redirect()->back();
        }
        $votehead->Status=1;
        $votehead->save();
        Session::flash("error","the votehead successfully Suspended");
        return redirect()->back();
    }
    public function approve($id)
    {
        $votehead=VoteHead::find($id);
        if(empty($votehead)){
            Session::flash("error","The Votehead Does Not Exist");
            return redirect()->back();
        }
        $votehead->Status=0;
        $votehead->save();
        Session::flash("success","the votehead successfully Approved");
        return redirect()->back();
    }
}
