<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style type="text/css">
    span {
      margin-left: 80px;
    }

    table,
    th,
    tr,
    td {
      border: 2px solid black;
    }

    td {
      padding-left: 5px;
    }

    .a1 {
      padding-top: 100px;
    }

    img {
      float: left;
      width: 60px;
      margin: 0 0 0 5px;
    }

    .a3 {
      font-size: 25px;
      margin-right: 70px;
      margin-top: 10px;

    }

    .a4 {
      padding: 95px 0 0 152px;
    }

    .netam {
      padding-left: 143px;
    }

    .page {
      margin: -55px 0 0 600px;
    }

    .a2 {
      padding-bottom: 65px;
    }

    .rupees {
      color: grey;
      margin: -20px 0 0 120px;
    }
  </style>
</head>

<body>
  <center>
    <table border="5" style="width: 800px; border-collapse:collapse;">
      <tr class="row1">
        <th colspan="4">
          <img src="<?=base_url()?>assets/frontend/images/logo.png" alt="logo">
          <p class="a3">TAX INVOICE</p>
          <p class="page">Page No:1</p>
        </th>

      </tr>
      <tr>
        <td><b>Name of supplier: </b>TUSHAR GLOBAL SERVICES <br><br>
          <b>Address: </b> FIRST FLOOR, 4/282,SFS, GARWAL FARM, MANSAROVAR<br><br>
          <b>State: </b>Rajasthan <span><b>State Code: </b>8</span><br><br><b>Email id: </b>tushaar.jain28@gmail.com <br><br><b>Mobile No: </b>00919818310203<br><br><b>GSTIN: </b>08BGSPJ4568H1ZS
        </td>
        <td><b>Invoice No: </b><?=$order1_data->invoice?><br><br><b>Date: </b>
          <?
         date_default_timezone_set("Asia/Calcutta");
         $cur_date=date("d-m-Y"); echo $cur_date;?><br><br><b>Reverse Charge: </b>0 <br><br><b>Place of supply: </b>Gujrat <span><b>State Code: </b>8</span><br><br> <b>Notes: </b>
        </td>



      </tr>
      <tr>
        <th>Details of receiver(Bill to)</th>
        <th>Details of consignee(Ship to)</th>
      </tr>
      <tr>
        <td><b>Name: </b><?=$order1_data->name?><br><br> <b>Address: </b><?=$order1_data->address?><br><br><b>State: </b><?=$order1_data->state?><br><br> <b>GSTIN: </b><?=$order1_data->gstin?><span><b>Pincode: </b><?=$order1_data->pincode?></span></td>
        <td><b>Name: </b><?=$order1_data->name?><br> <br><b>Address: </b><?=$order1_data->address?><br><br><b>State: </b><?=$order1_data->state?><br><br><b>GSTIN: </b><?=$order1_data->gstin?><span><b>Pincode: </b><?=$order1_data->pincode?></span><br><br>
        </td>
      </tr>
      <input type="hidden" id="tot_amnt" value="<? $final = round($order1_data->final_amount); echo $final;?>">
      <table border="1" style="width: 800px; border-collapse: collapse;">
        <tr>
          <th rowspan="2">S.NO.</th>
          <th rowspan="2">Goods and<br> services</th>
          <th rowspan="2">HSN</th>
          <th rowspan="2">QTY</th>
          <th rowspan="2">UOM</th>
          <th rowspan="2">Unit Price</th>
          <th rowspan="2">Gross</th>
          <th rowspan="2">Taxable Value</th>
          <th style="padding:3px;" colspan="2">C/S/IGST</th>
          <th rowspan="2">Total</th>
        </tr>
        <tr>
          <td>Rate</td>
          <td>Amount</td>
        </tr>
        <?$i=1;foreach($order2_data->result() as $data){?>
        <tr style="text-align: center;">
          <td><?=$i;?></td>
          <td><?$this->db->select('*');
          $this->db->from('tbl_product');
          $this->db->where('id', $data->product_id);
          $pro= $this->db->get()->row();
          if(!empty($pro)){echo $pro->name;}else{
            $data->product_name;
          }
          ?></td>
          <td><?if(!empty($pro)){echo $pro->hsn;}?></td>
          <td><?=$data->quantity?></td>
          <td><?if(!empty($pro)){echo $pro->uom;}?></td>
          <td>₹<?=$data->selling_price?></td>
          <td>₹<?=$data->selling_price?></td>
          <td><? $taxable = $data->spgst - $data->selling_price; echo "₹".$taxable;?></td>
          <td><?=$data->gst?>%</td>
          <td><? $taxable = $data->spgst - $data->selling_price; echo "₹".$taxable;?></td>
          <td>₹<?=$data->total_amount;?></td>
        </tr>
          <?$i++;}?>
        <tr>
        <tr>
          <td class="a1"></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th colspan="7"></th>
          <th colspan="3">Total Gross Value: </th>
          <td>₹<? $gross=0;foreach($order2_data->result() as $order2){ $gross = $order2->selling_price*$order2->quantity + $gross;} echo $gross;?></td>
        </tr>
        <tr>
          <td colspan="7" class="a2"><b>Bank Details</b></td>
          <td colspan="3"><b>Total CGST: <br>Total SGST: <br>Total IGST: <br>Total CESS: </b></td>
          <td><?if($order1_data->state=='Rajasthan [RJ]'){ $igst=0;  foreach($order2_data->result() as $order2){ $igst = ($order2->gst/100)*$order2->selling_price*$order2->quantity + $igst;} $igst = $igst/2; echo "₹".$igst; }else{echo "₹0.00";}?><br><?if($order1_data->state=='Rajasthan [RJ]'){ echo "₹".$igst;}else{echo "₹0.00";}?><br><?if($order1_data->state!='Rajasthan [RJ]'){ $igst = 0; foreach($order2_data->result() as $order2){ $igst = ($order2->gst/100)*$order2->selling_price*$order2->quantity + $igst;} echo "₹".$igst; }else{echo "₹0.00";}?><br>₹0.00</td>
        </tr>
        <tr>
          <td colspan="5"><b>Value In Words: </b><span>
              <p class="rupees" id="checks123">A</p>
            </span></td>
          <td colspan="5" class="netam"><b>Total Net Amount: </b></td><td>₹<?=$order1_data->final_amount?></td>
        </tr>
        <tr>
          <td colspan="5" style="padding-bottom: 0px;"><b>Terms and conditions: </b><br /><br />Subject to Jaipur Jurisdiction only.
            Amount paid is non refundable and non adjustable.
            By making payment, it is deemed that the customer has accepted our disclaimer.</td>
          <td colspan="6" style="padding-bottom: 0px;"><b>For</b> <br>
            <p style="color: grey; margin-left: 50px;">Tushar Global Services</p><br>
            <img src="<?=base_url()?>assets/admin/signature.png" style="height: 95px;width: 200px; float:right">
            <p class="a4">(Autharised Signature)</p>
          </td>
        </tr>
        <tr></tr>
      </table>

    </table>
  </center>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

window.onload = function() {

  var unit_mrp = $(".unit_mrp").text();
  var unit_qty = $(".qty").text();
  //var gst_percentage = $("#gst_percentage").val();$(this).val

  var total_unit_mrp = parseInt(unit_mrp) * parseInt(unit_qty);
  //alert(total_gst_price);
  $('.net_unit_mrp').text(total_unit_mrp);

  var total_amount= document.getElementById("tot_amnt").value;
  // alert(total_amount);
  inWords(total_amount);
  window.print();
};



var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

function inWords (num) {
  // alert(num)
      // num.tofixed(0)
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'And ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'Only ' : '';
    //return str;
    // alert(str);
    $("#checks123").text(str);

}
</script>

</html>
