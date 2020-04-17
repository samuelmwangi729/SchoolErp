<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Club;

class ClubsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $clubs=Club::all();
     return view('Clubs.Index')->with('clubs',$clubs);   
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
            'Club'=>[
                'required',
                'unique:clubs'
            ]
        ]);
        Club::create($request->all());
        Session::flash('success','the Club has been successfully added');
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
        $club=Club::find($id);
        if(empty($club)){
            Session::flash('error',"the Club Does Not exist");
            return redirect()->back();
        }
        return view("Clubs.Edit")->with('club',$club);
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
        $club=Club::find($id);
        if(empty($club)){
            Session::flash('error',"the Club Does Not exist");
            return redirect()->back();
        }
        $club->Club=$request->Club;
        $club->save();
        Session::flash('success','The Club Has been Updated');
        return redirect()->route('clubs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        $club=Club::find($id);
        if(empty($club)){
            Session::flash('error',"the Club Does Not exist");
            return redirect()->back();
        }
        $club->Status=0;
        $club->save();
        Session::flash('success','The Club Has been Updated');
        return redirect()->route('clubs.index');
    }
    public function approve($id)
    {
        $club=Club::find($id);
        if(empty($club)){
            Session::flash('error',"the Club Does Not exist");
            return redirect()->back();
        }
        $club->Status=1;
        $club->save();
        Session::flash('success','The Club Has been Updated');
        return redirect()->route('clubs.index');
    }
}
