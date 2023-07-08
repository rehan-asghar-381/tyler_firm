<?php
// function transportinvoice()
// {

//     $data = array();
//     $ORDER_NUMBER = $this
//         ->input
//         ->post('ORDER_IDS');
//     require_once (APPPATH . 'libraries/tcpdf/html2pdf.class.php');
//     if ((!empty($ORDER_NUMBER)) && ($_POST))
//     {

//         $this
//             ->db
//             ->select(' OS.ORDER_NUMBER,RP.ORDER_PRODUCT_ID,RP.ORDER_SUMMARY_ID,RP.PRODUCT_ID,RP.PRODUCT_NAME,OSS.PRODUCT_CODE,RP.ITEM_TYPE_ID,RP.QUANTITY,RP.DETAILS_1,RP.DETAILS_2,RP.WIDTH,RP.DEPTH,RP.HEIGHT,RP.TOTAL_METER,RP.PRODUCT_DELIVERY_ADDRESS,RP.PROD_ADDRESS_1,RP.PROD_ADDRESS_2,RP.PROD_CITY_ID,RP.PROD_STATE_ID,RP.PROD_SUBURB,RP.PROD_POST_CODE,RP.PROD_PHONE,RP.PROD_EMAIL,RP.PRODUCT_CONTACT_DETAILS,RP.TIMBER_CARCASS_ID,RP.TIMBER_DOOR_ID,RP.TIMBER_BASE_ID,RP.FINISH_CARCASS_ID,RP.FINISH_DOOR_ID,RP.FINISH_BASE_ID,RP.DRAWINGS, 	RP.SHELVES ,RP.CUTOUTS ,RP.MARBLE,RP.FABRIC ,RP.PAINT_IDS,RP.ORDER_ID,RP.PRODUCT_ORDER_NUMBER,RP.ORDER_NUMBER_COUNT,RP.PRODUCT_QUANTITY_NUMBER,RP.PRODUCT_STATUS,RP.UPDATED_DATE,RP.UPDATED_BY,RP.SPLIT_DATE,RP.SPLIT_BY,OS.DELIVERY_DATE,RP.DELIVERY_NOTES,RP.DELIVERED_BY,RP.STATUS_BEFORE_DELIVERY,OS.DUE_DATE,C.CITY,S.STATE,CL.NAME as CLNAME,P.PRODUCT_NAME,Cs.CARCASS as Timber,CC.CARCASS as Finish,D.DOOR as TIMBERDOOR,DD.DOOR as FINISHDOOR,B.BASE as TIMBEBASE,BB.BASE as FINISHBASE,OS.NOTES,P.SOLID,T.NAME AS TNAME,T.PHONE as TPHONE,T.FAX as TFAX,T.EMAIL as TEMAIL,RP.TransportSheet,OS.ADDRESS_1,OS.ADDRESS_2,OS.SUBURB,OS.POST_CODE,OS.EMAIL,OS.PHONE,CL.CLIENT_ID,OS.CONTACT_ADDRESS');
//         $this
//             ->db
//             ->from('order_summary AS OSS');
//         $this
//             ->db
//             ->join('order_products as RP', 'RP.ORDER_SUMMARY_ID=OSS.ORDER_SUMMARY_ID');
//         $this
//             ->db
//             ->join('orders AS OS', 'OS.ORDER_NUMBER  = RP.PRODUCT_ORDER_NUMBER');
//         $this
//             ->db
//             ->join('cities AS C', 'C.CITY_ID = OS.CITY_ID', 'left');
//         $this
//             ->db
//             ->join('states AS S', 'S.STATE_ID = OS.STATE_ID', 'left');
//         $this
//             ->db
//             ->join('clients AS CL', 'CL.CLIENT_ID = OS.CLIENT_ID', 'left');
//         $this
//             ->db
//             ->join('products AS P', 'P.PRODUCT_ID = RP.PRODUCT_ID', 'left');
//         $this
//             ->db
//             ->join('carcasses AS Cs', 'Cs.CARCASS_ID = RP.TIMBER_CARCASS_ID', 'left');
//         $this
//             ->db
//             ->join('carcasses AS CC', 'CC.CARCASS_ID = RP.FINISH_CARCASS_ID', 'left');
//         $this
//             ->db
//             ->join('doors AS D', 'D.DOOR_ID = RP.TIMBER_DOOR_ID', 'left');
//         $this
//             ->db
//             ->join('doors AS DD', 'DD.DOOR_ID = RP.FINISH_DOOR_ID', 'left');
//         $this
//             ->db
//             ->join('bases AS B', 'B.BASE_ID = RP.TIMBER_BASE_ID', 'left');
//         $this
//             ->db
//             ->join('bases AS BB', 'BB.BASE_ID = RP.FINISH_BASE_ID', 'left');
//         $this
//             ->db
//             ->join('transporters AS T', 'T.TRANSPORTER_ID = OS.TRANSPORTER_ID');

//         if (!empty($ORDER_NUMBER))
//         {

//             foreach ($ORDER_NUMBER as $key => $value)
//             {
//                 if ($key == 0)
//                 {
//                     $this
//                         ->db
//                         ->where('RP.ORDER_PRODUCT_ID', $value);
//                 }
//                 else
//                 {
//                     $this
//                         ->db
//                         ->or_where('RP.ORDER_PRODUCT_ID', $value);

//                 }
//             }
//         }
//         //$this->db->group_by("OS.ORDER_NUMBER");
//         $Details = $this
//             ->db
//             ->get()
//             ->result_array();

//         // echo '<pre>';
//         // print_r($Details);
//         // die();
//         $img_list = array();
//         $img_show = array();

//         $order_product_ids = [];
//         foreach ($Details as $rh_order_detail)
//         {

//             $order_product_ids[] = $rh_order_detail['ORDER_PRODUCT_ID'];

//         }

//         if (!empty($Details))
//         {

//             foreach ($Details as & $img_list)
//             {

//                 $this
//                     ->db
//                     ->select('RRP.PRODUCT_ORDER_NUMBER,C.CITY,S.STATE,S.STATE_ID');
//                 $this
//                     ->db
//                     ->from('states AS S');
//                 $this
//                     ->db
//                     ->join('order_products as RRP', 'RRP.PROD_STATE_ID = S.STATE_ID', 'left');
//                 $this
//                     ->db
//                     ->join('cities AS C', 'C.CITY_ID = RRP.PROD_CITY_ID', 'left');

//                 if (!empty($img_list['STATE_ID']))
//                 {

//                     $this
//                         ->db
//                         ->where('RP.STATE_ID', $img_list['STATE_ID']);
//                 }

//                 if (!empty($img_list['ORDER_NUMBER']))
//                 {

//                     $this
//                         ->db
//                         ->where('RRP.PRODUCT_ORDER_NUMBER', $img_list['ORDER_NUMBER']);
//                 }

//                 $this
//                     ->db
//                     ->group_by("S.STATE_ID");
//                 $img_list['query'] = $this
//                     ->db
//                     ->get()
//                     ->result_array();

//                 if (!empty($img_list['query']))
//                 {

//                     foreach ($img_list['query'] as & $img_show)
//                     {

//                         $this
//                             ->db
//                             ->select('RP.PRODUCT_ORDER_NUMBER as ORDER_NUMBER,RP.ORDER_PRODUCT_ID,RP.ORDER_SUMMARY_ID,RP.PRODUCT_ID,RP.PRODUCT_NAME,RO.PRODUCT_CODE,RO.QUANTITY,RP.DETAILS_1,RP.DETAILS_2,RP.WIDTH,RP.DEPTH,RP.HEIGHT,RP.PRODUCT_DELIVERY_ADDRESS,RP.PROD_ADDRESS_1,RP.PROD_ADDRESS_2,RP.PROD_CITY_ID,RP.PROD_STATE_ID,RP.PROD_SUBURB,RP.PROD_POST_CODE,RP.PROD_PHONE,RP.PROD_EMAIL,RP.PRODUCT_CONTACT_DETAILS,RP.PAINT_IDS,RP.ORDER_ID,RP.STATUS_BEFORE_DELIVERY,C.CITY,S.STATE,P.PRODUCT_NAME,Cs.CARCASS as Timber,CC.CARCASS as Finish,CL.NAME,OS.ADDRESS_1,OS.ADDRESS_2,OS.SUBURB,OS.POST_CODE,OS.EMAIL,OS.PHONE,RP.TOTAL_METER,RP.ORDER_NUMBER_COUNT,OS.CONTACT_ADDRESS');
//                         $this
//                             ->db
//                             ->from('order_products as RP');
//                         $this
//                             ->db
//                             ->join('orders AS OS', 'OS.ORDER_NUMBER  = RP.PRODUCT_ORDER_NUMBER');
//                         $this
//                             ->db
//                             ->join('order_summary AS RO', 'RO.ORDER_SUMMARY_ID = RP.ORDER_SUMMARY_ID', 'left');
//                         $this
//                             ->db
//                             ->join('cities AS C', 'C.CITY_ID = RP.PROD_CITY_ID', 'left');
//                         $this
//                             ->db
//                             ->join('states AS S', 'S.STATE_ID = RP.PROD_STATE_ID', 'left');
//                         $this
//                             ->db
//                             ->join('clients AS CL', 'CL.CLIENT_ID = OS.CLIENT_ID', 'left');
//                         $this
//                             ->db
//                             ->join('products AS P', 'P.PRODUCT_ID = RP.PRODUCT_ID', 'left');
//                         $this
//                             ->db
//                             ->join('carcasses AS Cs', 'Cs.CARCASS_ID = RP.TIMBER_CARCASS_ID', 'left');
//                         $this
//                             ->db
//                             ->join('carcasses AS CC', 'CC.CARCASS_ID = RP.FINISH_CARCASS_ID', 'left');
//                         if (!empty($img_show['PRODUCT_ORDER_NUMBER']))
//                         {
//                             $this
//                                 ->db
//                                 ->where('RP.PRODUCT_ORDER_NUMBER', $img_show['PRODUCT_ORDER_NUMBER']);
//                         }

//                         if (count($order_product_ids) > 0)
//                         {

//                             $this
//                                 ->db
//                                 ->where_in('RP.ORDER_PRODUCT_ID', $order_product_ids);
//                         }

//                         if (!empty($img_show['STATE_ID']))
//                         {

//                             $this
//                                 ->db
//                                 ->where('RP.PROD_STATE_ID', $img_show['STATE_ID']);
//                         }
//                         $this
//                             ->db
//                             ->group_by('RP.ORDER_SUMMARY_ID');

//                         $img_show['show'] = $this
//                             ->db
//                             ->get()
//                             ->result_array();

//                     }
//                 }
//             }
//         }
//         $data['products'] = $Details;

//         // echo '<pre>';
//         // print_r($data);
//         // die();
        

//         if (!empty($Details))
//         {
//             foreach ($Details as $pro)
//             {

//                 $query = $this
//                     ->db
//                     ->get_where('order_products', array(
//                     'ORDER_PRODUCT_ID' => $pro['ORDER_PRODUCT_ID'],
//                     'TransportSheet' => 1
//                 ))->row_array();

//                 //
//                 if (empty($query))
//                 {
//                     $datas = array(
//                         'TransportSheet' => 1
//                     );
//                     $this
//                         ->db
//                         ->where('ORDER_PRODUCT_ID', $pro['ORDER_PRODUCT_ID']);
//                     $this
//                         ->db
//                         ->update('order_products', $datas);
//                 }

//             }
//         }

//         // echo '<pre>';
//         // print_r($Details_all);
//         // die();
//         $maincount = 0;
//         if (!empty($Details))
//         {
//             $my_html = '';
//             $weltext = '';
//             $maincountheight = 363;
//             $arraycount = 0;
//             $maincountss = 0;

//             $Details_all = $Details;
//             foreach ($Details_all as $details)
//             {
//                 $nnerhtml = "";
//                 $nnerhtml1 = '';
//                 $originalDate = $details["DELIVERY_DATE"];
//                 $newDate = date("d-m-Y", strtotime($originalDate));
//                 $avalue = "";
//                 if (!empty($details['query']))
//                 {
//                     foreach ($details['query'] as $query)
//                     {
//                         $nnerhtml1 = "";

//                         if ((!empty($pro['STATE'])) && (!empty($query['STATE'])))
//                         {
//                             echo $avalue;
//                             if (($pro['STATE'] == $query['STATE']) && ($avalue != $query['STATE']))
//                             {
//                                 $avalue = $query['STATE'];
//                                 $nnerhtml1 = '<tr style="background: none repeat scroll 0% 0% rgb(204, 204, 204); color: rgb(255, 255, 255); font-weight: bold;"><td colspan="8" class="0thercolorprint" style="border: 1px solid black; padding: 5px;">' . $query["STATE"] . '</td></tr>';
//                             }
//                         }

//                         if (!empty($query['show']))
//                         {
//                             $arraycount = count($query['show']);
//                             foreach ($query['show'] as $show)
//                             {

//                                 $address = "";
//                                 $address = "<span style='line-height: 14px;text-align: left;'>";

//                                 if (!empty($show['NAME']))
//                                 {
//                                     $address .= strtoupper($show["NAME"]) . '<br>';
//                                 }

//                                 if (!empty($show['ADDRESS_1']))
//                                 {
//                                     $address = $address . $show["ADDRESS_1"] . '<br>';
//                                 }
//                                 if (!empty($show['ADDRESS_2']))
//                                 {
//                                     $address = $address . $show["ADDRESS_2"] . '<br>';
//                                 }

//                                 if (!empty($show['SUBURB']))
//                                 {
//                                     $address = $address . $show["SUBURB"] . '<br>';
//                                 }

//                                 if (!empty($show['POST_CODE']))
//                                 {
//                                     $address = $address . 'Post Code : ' . $show["POST_CODE"] . '<br>';
//                                 }

//                                 if (!empty($show['CONTACT_ADDRESS']))
//                                 {

//                                     $address = $address . '<label style="float: left; width: 100%;">CONTACT ADDRESS</label><br>';
//                                     $address = $address . $show["CONTACT_ADDRESS"] . '<br>';
//                                 }

//                                 if (!empty($show['PROD_PHONE']))
//                                 {
//                                     $address = $address . 'PH: ' . $show["PROD_PHONE"] . '<br>';
//                                 }

//                                 if (!empty($show['PROD_EMAIL']))
//                                 {
//                                     $address = $address . 'Email: ' . $show["PROD_EMAIL"] . '<br>';
//                                 }

//                                 $size = "";
//                                 if (!empty($show['WIDTH']))
//                                 {
//                                     $size = $size . $show["WIDTH"];
//                                 }

//                                 if (!empty($show['DEPTH']))
//                                 {
//                                     $size = $size . ' X ' . $show["DEPTH"];
//                                 }

//                                 if (!empty($show['HEIGHT']))
//                                 {
//                                     $size = $size . ' X ' . $show["HEIGHT"];
//                                 }
//                                 $address .= "</span>";

//                                 if ($maincount == 0)
//                                 {
//                                     $weltext = '<tr>		
//                                     <th style="background: none repeat scroll 0 0 #eee;  text-transform: uppercase;padding: 5px; border: 1px solid black;">
//                                         Order #
//                                     </th>
//                                     <th style="background: none repeat scroll 0 0 #eee; text-transform: uppercase;padding: 5px; border: 1px solid black;">
//                                         Delivery Address	
//                                     </th>
//                                     <th style="background: none repeat scroll 0 0 #eee; text-transform: uppercase;padding: 5px; border: 1px solid black;">
//                                         Description 
//                                     </th>
//                                     <th style="background: none repeat scroll 0 0 #eee; text-transform: uppercase;padding: 5px; border: 1px solid black;">
//                                         Size
//                                     </th>
//                                     <th style="background: none repeat scroll 0 0 #eee; text-transform: uppercase;padding: 5px; border: 1px solid black;">
//                                         Total Meter
//                                     </th>						
//                                     <th style="background: none repeat scroll 0 0 #eee; text-transform: uppercase;padding: 5px; border: 1px solid black;">
//                                         Quantity
//                                     </th>
//                                     <th style="background: none repeat scroll 0 0 #eee; text-transform: uppercase;padding: 5px; border: 1px solid black;">
//                                         Timber
//                                     </th>
//                                     <th style="background: none repeat scroll 0 0 #eee; text-transform: uppercase;padding: 5px; border: 1px solid black;">
//                                         Finish
//                                     </th>
//                                 </tr>';
//                                 }
//                                 else
//                                 {
//                                     $weltext = '';
//                                 }

//                                     $nnerhtml = $nnerhtml . '<table style="width:1500px;clear: both; font-family: arial; font-size: 11px; font-weight: bold; border: 0px none; border-collapse: collapse;">' . $weltext . $nnerhtml1 . '<tr>					
//                                     <td style="width: 50px; border: 1px solid black; padding: 5px; text-align: center; text-transform: uppercase;">' . $details["ORDER_NUMBER"] . '</td>
//                                     <td style="width: 230px; border: 1px solid black; padding: 5px; text-align: center;text-align: left;">' . $address . '</td>
//                                     <td style="width: 230px; border: 1px solid black; padding: 5px; text-align: center; text-transform: uppercase;">' . $show["DETAILS_1"] . '</td>								 
//                                     <td style="width: 120px; border: 1px solid black; padding: 5px; text-align: center; text-transform: uppercase;">' . @$size . '</td>
//                                     <td style="width: 100px; border: 1px solid black; padding: 5px; text-align: center; text-transform: uppercase;">' . $show["TOTAL_METER"] . '</td>					  
//                                     <td style="width: 50px; border: 1px solid black; padding: 5px; text-align: center; text-transform: uppercase;">' . $show["QUANTITY"] . '</td>
//                                     <td style="width: 50px; border: 1px solid black; padding: 5px; text-align: center; text-transform: uppercase;">' . $show["Timber"] . '</td>
//                                     <td style="width: 50px; border: 1px solid black; padding: 5px; text-align: center; text-transform: uppercase;">' . $show["Finish"] . '</td>
//                                     </tr></table>';

//                                 $maincount++;
//                                 $nnerhtml1 = "";
//                             }

//                         }

//                         if ($maincount > 7)
//                         {
//                             $maincountheight = 363 * 2;
//                         }
//                         else
//                         {
//                             $maincountheight = 363;
//                         }

//                         $maincount = 0;

//                     }

//                     $curraddress = "";

//                     if (!empty($details['CLNAME']))
//                     {
//                         // $curraddress=$details["CLNAME"].',<br>Thomastown 3095';
                        
//                     }
//                     /*				  if(!empty($details['ADDRESS_1'])){
//                     $curraddress=' 10 – 12 Centofanti Place '.',<br>';
//                     }
                    
//                     if(!empty($details['ADDRESS_2'])){
//                     $curraddress=$curraddress.$details["ADDRESS_2"].',<br>';
//                     }
                    
                    
//                     if(!empty($details['SUBURB'])){
//                     $curraddress=$curraddress.$details["SUBURB"].',<br>';
//                     }
                    
//                     if(!empty($details['POST_CODE'])){
//                     $curraddress=$curraddress.$details["POST_CODE"].',<br>';
//                     }
                    
//                     if(!empty($details['PHONE'])){
//                     $curraddress=$curraddress.$details["PHONE"].',<br>';
//                     }
                    
//                     if(!empty($details['EMAIL'])){
//                     $curraddress=$curraddress.$details["EMAIL"].'<br>';
//                     }
                    
                    
                    
//                     */

//                     $curraddress = $curraddress . "Zuster Manufacturing<br>THOMASTOWN 3095<br> 10-12 CENTOFANTI PLACE<br> PHONE:0394654700 <br> Email:<label style=' text-transform: lowercase;'>tj@zuster.com.au</label>";
//                     $headerpage = "";
//                     $footerpage = "";
//                     if ($arraycount <= 3)
//                     {
//                         $headerpage = '<page backcolor="#FEFEFE" backimg="" backimgx="center" backimgy="top" backimgw="100%" backtop="3mm" backbottom="0mm" backleft="0mm" backright="0mm" footer="date;heure;page" style="font-size: 12pt"><page_footer> 
//                         <span><b>Item received and accepted by : ....................................................................... Date : .................</b><br><label style="font-size:11px;">Please sign this form as an acknowledgment of having received and accepted your items in good condition</label></span>          
//                         </page_footer>';

//                         $footerpage = '</page>';

//                     }
//                     else
//                     {

//                         $headerpage = '<page backcolor="#FEFEFE" backimg="" backimgx="center" backimgy="top" backimgw="100%" backtop="3mm" backbottom="0mm" backleft="0mm" backright="0mm" footer="date;heure;page" style="font-size: 12pt"><page_footer> 
//                         <span><b>Item received and accepted by : ....................................................................... Date : .................</b><br><label style="font-size:11px;">Please sign this form as an acknowledgment of having received and accepted your items in good condition</label></span>          
//                         </page_footer>';

//                         $footerpage = '</page>';

//                     }

//                     // echo 'Yes';
//                     // echo $nnerhtml;
//                     // echo $my_html;
//                     // die();
//                     // $my_html=$my_html.$headerpage.'
//                     $my_html = $my_html . $headerpage . '			
//                     <table style="width:1500px;">		   
//                     <tr>
//                         <td>
//                             <table>
                                
//                                 <tr> 
//                                 <td style="width:900px">&nbsp;
                                                    
//                                 </td>
                                
//                                 <td style="width:150px">
//                                             <img id="image" src="https://zustermanufacturing.com.au/images/logo.jpg" style="width: 150px;" alt="logo" />				   
                                                            
//                                 </td>
//                                 </tr>
                            
//                             </table>
                        
//                         </td>
//                     </tr>
//                     </table>
                    

                    
//                     <table style="width:1500px;margin-top:20px;clear: both; font-family: arial; font-size: 11px; font-weight: bold; border: 0px none; border-collapse: collapse;">
//                         <tr>
//                                 <td style="width: 710px;">
                                
//                                         <div id="customer">
//                                             <table style="float: left; margin-top: 1px; width: 300px;border-collapse: collapse;margin-bottom: 35px; border-collapse: collapse; font-family: arial;font-size: 12px; font-weight: bold;line-height: 18px; text-transform: uppercase;">
//                                                 <tr><td style="width: 300px; vertical-align: top; background: none repeat scroll 0% 0% rgb(238, 238, 238); padding:10px;">Pick up Address </td>
//                                                 </tr>
//                                                 <tr>
//                                                 <td style="width: 300px; vertical-align: top; border: 1px solid #EDEDED; padding: 7px;">' . $curraddress . '</td></tr>  
//                                             </table>
//                                         </div>
//                                     </td>

//                                     <td style="width: 500px;clear: both; font-family: arial; font-size: 11px; font-weight: bold; border: 0px none; border-collapse: collapse;">
//                                     <div id="customer">
//                                             <table style="float: left; margin-top: 1px; width: 300px;border-collapse: collapse;margin-bottom: 35px; border-collapse: collapse; font-family: arial;font-size: 12px; font-weight: bold;line-height: 21px; text-transform: uppercase;">
//                                                     <tr><td style="width: 300px; vertical-align: top; background: none repeat scroll 0% 0% rgb(238, 238, 238); padding:10px;">Company Details  </td>
//                                                     </tr>
//                                                     <tr>
//                                                     <td style="width: 300px; vertical-align: top; border: 1px solid #EDEDED; padding: 7px;">Company : ' . $details["TNAME"] . ' <br>Company Phone : ' . $details["TPHONE"] . '<br>Company Fax : ' . $details["TFAX"] . '<br>Collection Date : ' . $newDate . '<br>
//                                                     </td>
//                                                     </tr>  
//                                         </table>
//                                         </div>					
//                                     </td>					

//                         </tr>		   
                    
//                         </table><br><br>' . $nnerhtml . $footerpage;

//                 }
//                 // echo $my_html;
//                 $maincountss = 0;
//             }

//             // $my_html = $headerpage.$nnerhtml.$footerpage;
//             // echo $my_html;
//             // die();
            

//             $width_in_inches = 3;
//             $height_in_inches = 16.54;
//             $width_in_mm = $width_in_inches * 20;
//             $height_in_mm = $height_in_inches * 25.4;

//             $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(
//                 5,
//                 5,
//                 5,
//                 5
//             ));
//             $html2pdf
//                 ->pdf
//                 ->SetDisplayMode('fullpage');
//             $html2pdf
//                 ->pdf
//                 ->SetAuthor('LAST-NAME Frist-Name');
//             $html2pdf
//                 ->pdf
//                 ->SetTitle('HTML2PDF Wiki Example');
//             $html2pdf
//                 ->pdf
//                 ->SetSubject('HTML2PDF Wiki');
//             $html2pdf
//                 ->pdf
//                 ->SetKeywords('HTML2PDF, TCPDF, example, wiki');

//             //       $html2pdf->setModeDebug();
//             $html2pdf->setDefaultFont('Arial');
//             $html2pdf->writeHTML($my_html);
//             $html2pdf->Output('exemple00.pdf');
//             /*
//             exit();
//             $pdf_options = array(
//             "source_type" => 'html',
//             "source" => $my_html,
//             "action" => 'view',
//             "save_directory" => '',
//             "file_name" => 'transportreportnow.pdf',
//             "footer" => '');
            
//             $this->phptopdf($pdf_options);*/

//         }

//         if (!empty($data['products']))
//         {
//             header('Location: https://zustermanufacturing.com.au/transportreportnow.pdf');
//             exit;
//         }
//         else
//         {
//             redirect("order_product/transport");
//         }

//         if (empty($Details))
//         {
//             redirect("order_product/transport");

//         }

//         $this
//             ->load
//             ->view('invoice/transportlabelinvoice1', $data);

//     }
//     else
//     {
//         redirect("order_product/transport");

//     }

// }

?>
