<body>
<htmlpageheader name="page-header" style="margin-bottom: 5px;">
    <div style="display:table;width:100%;text-align:right;border-bottom:1px solid #ccc;padding-bottom:5px;">
        IMC Ltd,. Co.
    </div>
</htmlpageheader>

<htmlpagefooter name="page-footer">
    <div style="text-align: center">-{PAGENO}-</div>
</htmlpagefooter>
@section('style')
    <link rel="stylesheet" href="{{ asset("/css/preview-billing-paper.css") }}">
@endsection
<div class="page">
    <div class="header-page">
        <div class="left-part">
            <img src="http://www.jmuc.co.jp/imc/images/imc_logo.jpg">
        </div>
        <div class="right-part">
            <h2>IMC Ltd,. Co.</h2>
            <p>Minato-ku,Tokyo 108-0023 Japan</p>
            <p>Phone: (+8436) 123 356 | Fax: 1234 1454 7453</p>
            <p>http://www.jmuc.co.jp</p>
            <p>Email: imc.ltdco@gmail.com</p>
        </div>
    </div>
    <div class="temp">
        <p>Voice: #####</p>
        <p>Date: {{date('Y/m/d')}}</p>
        <p>Terms: Next 30 Days</p>
    </div>
    <div class="info">
        <div class="left-info">
            <h3>会社</h3>
            <table>
                <tr>
                    <td>{{__('billing.lbl_company_name')}}</td>
                    <td>: AAA株式会社</td>
                </tr>
                <tr>
                    <td>{{__('billing.lbl_company_address')}}</td>
                    <td>: 123 Xyz Street, CDF City</td>
                </tr>
                <tr>
                    <td>{{__('billing.lbl_represent_person')}}</td>
                    <td>: 代表名</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>{{__('billing.lbl_ope_person_name_1')}}</td>
                    <td>: 成子長森</td>
                </tr>
                <tr>
                    <td>{{__('billing.lbl_ope_position_1')}}</td>
                    <td>: 窓口1 役職</td>
                </tr>
                <tr>
                    <td>{{__('billing.lbl_ope_address_1')}}</td>
                    <td>: 窓口1 住所</td>
                </tr>
                <tr>
                    <td>{{__('billing.lbl_ope_phone_1')}}</td>
                    <td>: +84 0956 058 098</td>
                    <td>{{__('billing.lbl_ope_email_1')}}</td>
                    <td>: 窓口1 Eメール</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>{{__('billing.lbl_ope_company_name')}}</td>
                    <td>: 所管会社</td>
                </tr>
                <tr>
                    <td>{{__('billing.lbl_ope_company_short_name')}}</td>
                    <td>: 略称</td>
                </tr>
                <tr>
                    <td>{{__('billing.lbl_ope_address')}}</td>
                    <td>: 住所</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="detail">
        <h3>{{__('billing.lbl_title_detail')}}</h3>
        <div class="currency-usage">
            <div>使用通貨: JPY（円）</div>
        </div>
        <table class="table">
            <tr class="thead">
                <td class="id">船舶ID</td>
                <td class="desc">船名</td>
                <td class="price">発生年月</td>
                <td class="total">請求内容</td>
                <td class="id">標準月額</td>
                <td class="desc">適用値引額</td>
                <td class="price">値引き</td>
                <td class="total">請求額</td>
                <td class="total">小計</td>
            </tr>
            
            @for($i = 1; $i < 7; $i++ )
            <tr>
                <td rowspan="3" class="text-center">{{$i}}</td>
                <td rowspan="3">IMC Star</td>
                <td class="text-center">06/2018</td>
                <td class="text-center">PMS利用料</td>
                <td class="text-right">1.000</td>
                <td class="text-right">10</td>
                <td class="text-center">個別値引</td>
                <td class="text-right">950</td>
                <td rowspan="3" class="text-right">9.050</td>
            </tr>
            <tr>
                <td class="text-center">06/2018</td>
                <td class="text-center">PMS利用料</td>
                <td class="text-right">1.000</td>
                <td class="text-right">10</td>
                <td class="text-center">個別値引</td>
                <td class="text-right">950</td>
            </tr>
            <tr>
                <td class="text-center">06/2018</td>
                <td class="text-center">PMS利用料</td>
                <td class="text-right">1.000</td>
                <td class="text-right">10</td>
                <td class="text-center">個別値引</td>
                <td class="text-right">950</td>
            </tr>
            @endfor

            <tr class="sum">
                <td colspan="7"></td>
                <td>小計</td>
                <td>9.505.954</td>
            </tr>
             <tr class="sum">
                <td colspan="7"></td>
                <td>税金</td>
                <td>8%</td>
            </tr>
             <tr class="sum">
                <td colspan="7"></td>
                <td>合計</td>
                <td>9.505.954</td>
            </tr>
        </table>
    </div>
</div>
<style>
    body{
        font-family: "DejaVu Sans";
        margin: 0;
    }
    .page{
        padding: 10px 0px;
    }
    .header-page{
        clear: both;
        border-bottom: 20px solid #cccccc;
        padding-bottom: 15px;
        margin-bottom: 5px;
    }
    
    .header-page h2{
        margin-top: 0;
        margin-bottom: 10px;
    }
    
    .header-page p{
        margin-top: 0;
        margin-bottom: 5px;
    }
    .left-part{
        float: left;
        width: 30%;
    }
    
    .right-part{
        float: right;
        width: 70%;
        text-align: right;
    }
    .info, .temp{
        clear: both;
    }
    .temp p{
        margin-top: 0;
        margin-right: 30px;
        float: left;
        width: 30%;
    }
    .info h3 {
        border-bottom: 2px solid #cccccc;
    }
    .info p{
        margin: 5px 0px;
    }
    .info .left-part, .info .right-part{width: 50%;}
    
    .detail{
         margin: 20px 0;
         position: relative;
    }
    .detail h3 {
        border-bottom: 2px solid #cccccc;
    }
    .currency-usage div{
        text-align: right;
        width: 100%;
        margin-bottom: 5px;
    }
    .detail table{
        width: 100%;
        border-collapse:collapse;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .table tr td.id {
        text-align: center;
    }
    .detail table .thead td{
        font-weight:bold;background: 
        #ccc;text-align: center;}
    
    .detail table td{
        padding: 5px 7px;
        border: 1px solid #333;
    }

    .detail table .sum td:nth-child(1){border: 0;}
    @page {
        header: page-header;
        footer: page-footer;
    }
</style>
</body>
