<?php

namespace App\Common;

use Mpdf;

class RenderPDF 
{
    // Set file name of
    public static $pdfFileName = 'CMAXS';
    
    // Config method after create pdf
    const METHODS = [
        'stream'        => Mpdf\Output\Destination::INLINE,
        'download'      => Mpdf\Output\Destination::DOWNLOAD,
        'save'          => Mpdf\Output\Destination::FILE,
        'string'        => Mpdf\Output\Destination::STRING_RETURN
    ];

    /**
     * Config default for template Mpdf
     * Source: https://mpdf.github.io/reference/mpdf-variables/overview.html
     * ----------------------------------------------------
     * SetTitle                 => "This is title"
     * SetAuthor                => "Your Name"
     * SetDisplayMode           => fullpage | fullwidth | real | default
     * SetWatermarkText         => "CMAXS System Managment IMC Ltd,. Co"
     * showWatermarkText        => true
     * ...
     */
    const CONFIGS = [
        'useAdobeCJK'               => true,
        'allow_charset_conversion'  => false,
        'autoScriptToLang'          => true,
        'autoLangToFont'            => true,
        'SetWatermarkText'          => "CMAXS System Managment IMC Ltd,. Co",
        'showWatermarkText'         => true,
        'SetTitle'                  => "This is title",
    ]; 
    
    /**
     * Handle export PDF with HTML from view
     * 
     * @param Illuminate\Support\Facades\View $view
     * @param Array $data
     * @param String $method
     * @return Mpf\Mpdf\Ouput
     */
    public static function exportPDFWithView($view = 'demo.template', $data = [], $method = 'download' ) {
        $pdf = new Mpdf\Mpdf();

        RenderPDF::configUTF8Japanese($pdf, self::CONFIGS);
        
        // If user want to pass data into view
        if(count($data) > 0){
            $html = view($view, $data)->render();
        }else{
            $html = view($view)->render();
        }
        
        // Add content HTML to pdf page
        $pdf->WriteHTML($html);
        
        // Output pdf with method 
        return $pdf->Output(
                self::$pdfFileName.'.pdf', 
                isset($method) && isset(self::METHODS[$method])?self::METHODS[$method]:self::METHODS['stream']
            );
    }
    
    /**
     * Set config utf8 for japanese
     * 
     * @param Mpdf\Mpdf $pdfObj
     * @param const $configs
     * @return void
     */
    public static function configUTF8Japanese($pdfObj = null, $configs = []) {
        
        // $pdf->useAdobeCJK = true;
        // $pdf->allow_charset_conversion = false;
        // $pdf->autoScriptToLang = true;
        // $pdf->autoLangToFont = true;
        // Set UTF-8 content
        if(count($configs) > 0){
            foreach($configs as $conf => $value){
                if(preg_match('/^Set+/', $conf)){
                    $pdfObj->{$conf}($value);
                }else{
                    $pdfObj->{$conf} = $value;
                }
            }
        }
        
        // Set UTF-8 File Name
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/MSIE|Internet Explorer|Trident|Edge/', $userAgent)){
            $fileName = date('YmdHis').urlencode(self::$pdfFileName);
        }else{
            $fileName = date('YmdHis').self::$pdfFileName;
        }
    }
    
}
