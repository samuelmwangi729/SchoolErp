<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Classes,VoteHead,Fee,CurrentTerm,NextTerm,Student,Stream};
use Session;
use DB;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $class=Classes::all();
        $fees=Fee::all();
        $voteheads=VoteHead::all();
        return view('Fees.Index')
        ->with("classes",$class)
        ->with("fees",$fees)
        ->with("voteheads",$voteheads);
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
            'VoteHead'=>'required',
            'Term'=>'required',
            'Amount'=>'required'
        ]);
        $Year=date('Y');
        Fee::create([
            'Class'=> $request->Class,
            'VoteHead'=> $request->VoteHead,
            'Term'=> $request->Term,
            'Amount'=> $request->Amount,
            'Year'=> $Year
        ]);
        Session::flash('success','Fees Successfully Added');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($class)
    {
        $year=date('Y');
        $fees=Fee::where([
            'Class'=>$class,
            'Year'=>$year
        ])->get();
       return view('Fees.View')->with('fees',$fees);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fee=Fee::find($id);
        if(empty($fee)){
            Session::flash('error','The Fees Does Not Exist');
            return redirect()->back();
        }
        $class=Classes::all();
        $voteheads=VoteHead::all();
        return view('Fees.Edit')
        ->with("classes",$class)
        ->with("fee",$fee)
        ->with("voteheads",$voteheads);
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
            'VoteHead'=>'required',
            'Term'=>'required',
            'Amount'=>'required'
        ]);
        $fee=Fee::find($id);
        if(empty($fee)){
            Session::flash('error','The Fees Does Not Exist');
            return redirect()->back();
        }

        $fee->Class= $request->Class;
        $fee->VoteHead= $request->VoteHead;
        $fee->Term= $request->Term;
        $fee->Amount= $request->Amount;
        $fee->save();
        Session::flash('success','Fees Successfully Updated');
        $class=Classes::all();
        $fees=Fee::all();
        $voteheads=VoteHead::all();
        return redirect(route('fees.index'))
        ->with("classes",$class)
        ->with("fees",$fees)
        ->with("voteheads",$voteheads);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fee=Fee::find($id);
        if(empty($fee)){
            Session::flash('error','The Fees Does Not Exist');
            return redirect()->back();
        }
        $fee->destroy($id);
        Session::flash('success','Fees Successfully Deleted');
        return redirect()->back();
    }
    public function current(Request $request){
        $this->validate($request,[
            'CurrentTerm'=>'required'
        ]);
        $current=CurrentTerm::all()->last();;
        if( is_null($current) || $current->count()==0){
            CurrentTerm::create($request->all());
            Session::flash('success','Current Term Successfully Set');
            return redirect()->back();
        }else{
            $current->CurrentTerm=$request->CurrentTerm;
            $current->save();
            Session::flash('success','Current Term Successfully Updated');
            return redirect()->back();
        }

    }
    public function next(Request $request){
        $this->validate($request,[
            'NextTerm'=>'required'
        ]);
        $next=NextTerm::all()->last();
        if( is_null($next) || $next->count()==0){
            NextTerm::create($request->all());
            Session::flash('success','Next Term Successfully Set');
            return redirect()->back();
        }else{
            $next->NextTerm=$request->NextTerm;
            $next->save();
            Session::flash('success','Next Term Successfully Updated');
            return redirect()->back();
        }

    }
    public function balances(){
        $students=Student::where('Balance','>',0)->get();
        $streams=Stream::all();
        return view('Fees.Balances')
        ->with('streams',$streams)
        ->with('students',$students);
    }
    public function filter(Request $request){
        $filter=$request->Filter;
        if($filter==1){
            //this is the current term
            $term=CurrentTerm::all()->first();
            // dd($term->CurrentTerm);
            $class=Classes::all();
            $fees=Fee::where('Term',$term)->get();
            $voteheads=VoteHead::all();
            if(is_null($term) || empty($term)){
                Session::flash('error','Current Term Not Set. Please update Current Term');
                return back();
            }
            Session::flash('Data',$term->CurrentTerm);
            Session::flash('success','Filter Successfully Applied');
            return redirect()->route('fees.index')
            ->with("classes",$class)
            ->with("fees",$fees)
            ->with("voteheads",$voteheads);
        }
        if($filter==2){
            //view fees by the next term
            $term=NextTerm::all()->first();
            // dd($term->NextTerm);
            $class=Classes::all();
            $fees=Fee::where('Term','=',$term)->get();
            $voteheads=VoteHead::all();
            if(is_null($term) || empty($term)){
                Session::flash('error','Next Term Not Set. Please update Next Term');
                return back();
            }
            Session::flash('Data',$term->NextTerm);
            Session::flash('success','Filter Successfully Applied');
            return redirect()->route('fees.index')
            ->with("classes",$class)
            ->with("fees",$fees)
            ->with("voteheads",$voteheads);
        }
        if($filter==3){
            //view yearly fees
        $class=Classes::all();
        $fees=Fee::all();
        $voteheads=VoteHead::all();
        Session::flash('success','Filter Successfully Applied');
        return redirect()->route('fees.index')
        ->with("classes",$class)
        ->with("fees",$fees)
        ->with("voteheads",$voteheads);
        }
    }
    public function FilterBalances(Request $request){
        $this->validate($request,[
            'Class'=>'required',
            'Stream'=>'required',
            'Amount'=>'required'
        ]);
        if($request->Amount=="1"){
            $query=Student::where([
                ['class','=',$request->Class],
                ['Stream','=',$request->Stream],
                ['Balance','<=',5000]
            ])->get();
            if($query->count()==0){
                Session::flash('error','No Students with the selected fees Balance. Try Again');
                return back();
            }else{
                return view('Fees.Balance')->with('balances',$query);
            }
           }
           if($request->Amount=="2"){
            $query=Student::where([
                ['class','=',$request->Class],
                ['Stream','=',$request->Stream],
                ['Balance','<=',10000]
            ])->get();
            if($query->count()==0){
                Session::flash('error','No Students with the selected fees Balance. Try Again');
                return back();
            }else{
                return view('Fees.Balance')->with('balances',$query);
            }
           }
           if($request->Amount=="3"){
            $query=Student::where([
                ['class','=',$request->Class],
                ['Stream','=',$request->Stream],
                ['Balance','<=',20000]
            ])->get();
            if($query->count()==0){
                Session::flash('error','No Students with the selected fees Balance. Try Again');
                return back();
            }else{
                return view('Fees.Balance')->with('balances',$query);
            }
           }
           if($request->Amount=="4"){
            $query=Student::where([
                ['class','=',$request->Class],
                ['Stream','=',$request->Stream],
                ['Balance','>',20000]
            ])->get();
            if($query->count()==0){
                Session::flash('error','No Students with the selected fees Balance. Try Again');
                return back();
            }else{
                return view('Fees.Balance')->with('balances',$query);
            }
           }
    }
}
