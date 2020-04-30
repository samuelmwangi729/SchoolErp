<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Payment,Student};
use Session;
use Str;
use Auth;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions=Payment::orderBy('id','desc')->get();
        return view('Payments.Index')->with('transactions',$transactions);
    }
    public function all(){
        $all=Payment::all();
        $fileName="Statement.pdf";
        $mpdf=new \Mpdf\Mpdf([
            'margin_left'=>10,
            'margin_top'=>21,
            'margin_right'=>10,
            'margin_bottom'=>50,
            'margin_header'=>10,
            'margin_footer'=>10,
        ]);
        $html= \View::make('Payments.All')->with('payments',$all);
        $html=$html->render();
        //  $mpdf->Image('img/logo.png',30,0,90,210);
        // $mpdf->SetWatermarkText(config('app.name'));
        // $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->SetHeader('SChool System  {PAGENO}');
        // $mpdf->SetFooter('{PAGENO}');
        $stylesheet=file_get_contents('css/bootstrap.css');
        $mpdf->WriteHTML($stylesheet,3);

        $mpdf->WriteHTML($html,0);
        $mpdf->Output($fileName,'I');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Payments.Create')->with('students',Student::all());
    }

    public function receipt(){

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
            'StudentAdmission'=>'required',
            'Amount'=>'required',
            'PaymentMethod'=>'required',
            'PaidBy'=>'required'
        ]);
        $student=Student::where('AdmissionNumber','=',$request->StudentAdmission)->get()->first();
        if(is_null($student) || empty($student)){
            Session::flash('error','Student Does Not Exist, Please enter the correct Admission Number');
            return back();
        }
        $balance=$student->Balance;
        $newBalance=$balance-$request->Amount;
        $student->Balance=$newBalance;
        $student->save();
        Payment::create([
            'PaymentCode'=>Str::random(6),
            'StudentAdmission'=>$request->StudentAdmission,
            'Amount'=>$request->Amount,
            'PaymentMethod'=>$request->PaymentMethod,
            'PaidBy'=>$request->PaidBy,
            'ReceivedBy'=>Auth::user()->name
        ]);
        //print the pdf of the receipt
        Session::flash('success','Payment Successfully Recorded');
        return redirect()->route('payments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $last=Payment::find($id);
        if(is_null($last) || empty($last)){
            Session::flash('error','Transaction Not Found');
            return back();
        }
        // // dd(url('/css/adminlte.min.css'));
        // $fileName="Receipt.pdf";
        // $mpdf=new \Mpdf\Mpdf([
        //     'margin_left'=>10,
        //     'margin_top'=>21,
        //     'margin_right'=>10,
        //     'margin_bottom'=>50,
        //     'margin_header'=>10,
        //     'margin_footer'=>10,
        // ]);
        // $html= \View::make('Payments.receipt')->with('last',$last);
        // $$html=$html->render();
        // // $mpdf->Image('/img/logo.jpg',90,210);
        // $mpdf->SetWatermarkText(config('app.name'));
        // $mpdf->watermark_font = 'DejaVuSansCondensed';
        // $mpdf->SetHeader('VirtualSchool  {PAGENO}');
        // // $mpdf->SetFooter('{PAGENO}');
        // $stylesheet=file_get_contents('css/adminlte.css');
        // $mpdf->WriteHTML($stylesheet,2);
        // $mpdf->WriteHTML($html,1);
        // $mpdf->Output($fileName,'I');
        return view('Payments.receipt')->with('last',$last);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment=Payment::find($id);
        if(is_null($payment) || empty($payment)){
            Session::flash('error','Transaction does not exist');
            return back();
        }
        return view("Payments.Edit")
        ->with('students',Student::all())
        ->with('payment',$payment);
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
            'StudentAdmission'=>'required',
            'Amount'=>'required',
            'PaymentMethod'=>'required',
            'PaidBy'=>'required'
        ]);
        $student=Student::where('AdmissionNumber','=',$request->StudentAdmission)->get()->first();
        if(is_null($student) || empty($student)){
            Session::flash('error','Student Does Not Exist, Please enter the correct Admission Number');
            return back();
        }
        $balance=$student->Balance;
        $newBalance=$balance-$request->Amount;
        $student->Balance=$newBalance;
        $student->save();
        $payment=Payment::find($id);
        if(is_null($payment) || empty($payment)){
            Session::flash('error','No Such Transaction Available');
            return back();
        }
            $payment->StudentAdmission=$request->StudentAdmission;
            $payment->Amount=$request->Amount;
            $payment->PaymentMethod=$request->PaymentMethod;
            $payment->PaidBy=$request->PaidBy;
            $payment->save();
        Session::flash('success','Payment Successfully Updated');
        return redirect()->route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
