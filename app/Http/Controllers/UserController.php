<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\RenderPDF as PDFRender;

class UserController extends Controller
{
    protected $userRepo;
    
    public function __construct() 
    {
        //$this->userRepo = $userRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $users = $this->userRepo->getAll();
        return view('user.list');
    }
    
    /**
     * SHow pdf template 
     *
     * @return \Mpdf\Mpdf\OutPut
     */
    public function previewPDF()
    {
        return view('user.preview-pdf');
    }
    
    /**
     * SHow pdf template 
     *
     * @return \Mpdf\Mpdf\OutPut
     */
    public function printPDF()
    {
        PDFRender::$pdfFileName = "関する基CMAXS";
        return PDFRender::exportPDFWithView('user.print-pdf', ['user' => 'DungLV'], 'download');
    }

    /**
     * SHow pdf template 
     *
     * @return \Mpdf\Mpdf\OutPut
     */
    public function displayBrownserPDF()
    {
        PDFRender::$pdfFileName = "関する基CMAXS";
        return PDFRender::exportPDFWithView('user.print-pdf', ['user' => 'DungLV'], 'stream');
    }

     /**
     * SHow pdf template 
     *
     * @return \Mpdf\Mpdf\OutPut
     */
    public function displayBrownserPDF_2()
    {
        PDFRender::$pdfFileName = "関する基CMAXS";
        return PDFRender::exportPDFWithView('user.template-pdf-2', ['user' => 'DungLV'], 'stream');
    }
    
    /**
     * SHow pdf template 
     *
     * @return \Mpdf\Mpdf\OutPut
     */
    public function displayBrownserPDF_3()
    {
        PDFRender::$pdfFileName = "関する基CMAXS";
        return PDFRender::exportPDFWithView('user.template-pdf-3', ['user' => 'DungLV'], 'stream');
//        return view('user.template-pdf-3')->with('user', 'DUngLV');
    }
    
    /**
     * 
     */
    public function createChartImages($data = []) {
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
