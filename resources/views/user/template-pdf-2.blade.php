<body>
<htmlpageheader name="page-header">
    <div style="display:table;width:100%;text-align:right;border-bottom:1px solid #ccc;padding-bottom:5px;">
        CMAXS System 関す情報IMC Ltd., Co. 各システムの
    </div>
</htmlpageheader>

<htmlpagefooter name="page-footer">
    <div style="text-align: center">-{PAGENO}-</div>
</htmlpagefooter>
<div class="page">
    <div class="headdd">
        <div class="left-part">
            <img src="http://www.jmuc.co.jp/imc/images/imc_logo.jpg">
        </div>
        <div class="right-part">
            <h2>IMC Ltd,. Co.</h2>
            <p>Minato-ku,Tokyo 108-0023 Japan</p>
            <p>Phone: (+8436) 123 356 | Fax: 1234 1454 7453</p>
            <p>http://www.jmuc.co.jp</p>
            <p>E: imc.ltdco@gmail.com</p>
        </div>
    </div>
    <div class="temp">
        <p>Voice: #####</p>
        <p>Date: {{date('Y/m/d')}}</p>
        <p>Terms: Net 30 Days</p>
    </div>
    <div class="info">
        <div class="left-part">
            <h3>Bill to:</h3>
            <p>ABC Company</p>
            <p>Shimada Naruto</p>
            <p>123 Xyz Street, CDF City, 203444</p>
            <p>Phone: (+1)234 124 567 | Fax: 123 456 755</p>
            <p>Website: abc.com.jp</p>
            <p>info@abc.com</p>
        </div>
        <div class="right-part">
            <h3>Bill to:</h3>
            <p>ABC Company</p>
            <p>Shimada Naruto</p>
            <p>123 Xyz Street, CDF City, 203444</p>
            <p>Phone: (+1)234 124 567 | Fax: 123 456 755</p>
            <p>Website: abc.com.jp</p>
            <p>info@abc.com</p>
        </div>
    </div>
    <div class="detail">
        <table>
            <tr class="thead">
                <td class="qty">Qty</td>
                <td class="desc">Description</td>
                <td class="price">Unit Price</td>
                <td class="total">Total</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>$0.00</td>
            </tr>
            <tr class="sum">
                <td colspan="2"></td>
                <td>Subtotal</td>
                <td>$0.00</td>
            </tr>
             <tr class="sum">
                <td colspan="2"></td>
                <td>Tax:</td>
                <td>$0.00</td>
            </tr>
             <tr class="sum">
                <td colspan="2"></td>
                <td>Toatal</td>
                <td>$0.00</td>
            </tr>
             <tr class="sum">
                <td colspan="2"></td>
                <td>Amount Due</td>
                <td>$0.00</td>
            </tr>
        </table>
        <ul class="notes">
            <li>Note: Inclue any special instruction or miscellaneous charges</li>
            <li>Payment Options: Tell the customer how to pay this invoice; mail, phone, online, etc...</li>
            <li>I agree to pay COMPANY NAME the total amount due within the terms specified on the invoice X____________</li>
        </ul>
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
    .headdd{
        clear: both;
        border-bottom: 20px solid #cccccc;
        padding-bottom: 15px;
        margin-bottom: 5px;
    }
    
    .headdd h2{
        margin-top: 0;
        margin-bottom: 10px;
    }
    
    .headdd p{
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
    .info p{
        margin: 5px 0px;
    }
    .info .left-part, .info .right-part{width: 50%;}
    
    .detail{margin: 20px 0;position: relative;}
    .detail table{width: 100%; border-collapse:collapse;}
    .detail table .thead td{font-weight:bold;background: #ccc;text-align: center;}
    
    .detail table td{
       padding: 5px 7px;
        border: 1px solid #333;
    }
    .detail table .qty{width: 10%;}
    .detail table .desc{width: 58%;}
    .detail table .price{width: 17%;}
    .detail table .total{width: 15%;}
    .detail table .sum td:nth-child(1){border: 0;}
    .detail .notes{list-style:none;padding:0;margin:0; margin-top: -80px;}
    .detail .notes li{
        padding: 5px;
        border: 1px solid #333333;
        margin-bottom: 20px;
        width: 65%;
    }
    @page {
        header: page-header;
        footer: page-footer;
    }
</style>
</body>
