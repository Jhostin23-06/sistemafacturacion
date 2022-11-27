<?php
    SESSION_START();
    
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        $v_usuario=$_SESSION['user'];
        $xIdAlmacen = $_SESSION['IdAlmacen'];        
        include("Conexion.php");  
        $xIdMov   = $_REQUEST['IdMov'];
        #---- Datos Factura ------------------------------
        $StrSql="select * from movta where  IdMov=".$xIdMov;
        
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regMovta= mysqli_fetch_assoc($ResultSet);
        $xIdCaja        = $regMovta['Caja'];
        $xIdTipDoc        = $regMovta['TipDoc'];
        $xFecha         = $regMovta['Fecha'];
        $xSubtotal        = $regMovta['SubTotal'];
        $xDescuento             = $regMovta['Descuento'];
        $xImpuesto              = $regMovta['Impuesto'];
        $xTotal         = $regMovta['Total'];
        $xIdAlmacen       = $regMovta['IdAlmacen'];
        $xIdCliente       = $regMovta['IdCliente'];
        $xFactSri         = $regMovta['FactSri'];
        $xEstado        = $regMovta['Estado'];
        $x_audit_usuario    = $regMovta['aud_usuario_proc'];
        $x_audit_fecha  = $regMovta['aud_fecha_proc'];
        #------- Informacion del cliente ------------------
        $StrSql="select * from clientes where IdCliente=$xIdCliente";
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regCli= mysqli_fetch_assoc($ResultSet);

        $xCedulaCliente   = $regCli['CedulaRUC'];
        $xNombreCliente   = $regCli['Apellidos'].' '.$regCli['Nombres'];
        $xDireccionCliente= $regCli['Direccion'];
        $xTelefonoCliente = $regCli['Telefonos'];
        $xEmailCliente    = $regCli['Email'];
        #------ Informacion de la emoresa ----------------
        $StrSql="select * from systemprofile where IdEmpresa=".$xIdAlmacen;
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regProfile= mysqli_fetch_assoc($ResultSet);

        $xRucEmpresa      = $regProfile['RUC'];
        $xNombreEmpresa   = $regProfile['NombreEmpresa'];
        $xDireccionEmpresa= $regProfile['Direccion'];
        $xTelefonoEmpresa = $regProfile['Telefonos'];
        $xPorcentajeIva   = $regProfile['Iva'];


                    $CodigoHtml="";
                    $CodigoHtml.="<h1>";
                    $CodigoHtml.="    <center>";
                    $CodigoHtml.="        <b>FACTURA</b>";
                    $CodigoHtml.="    </center>";
                    $CodigoHtml.="</h1>";
                    $CodigoHtml.="<table  width=100% >";                    
                    $CodigoHtml.="<tr><td width=15%></td><td style='font-size: 12px;color:#FFFFFF;' width=25%>A</td><td width=15%></td><td width=45%></td></tr>";                       
                    $CodigoHtml.="</table>";                        
                    $CodigoHtml.="<table  width=100% >";
                    $CodigoHtml.="<tr><td width=15%></td><td width=25%></td><td width=15%></td><td width=45%></td></tr>";
                    $CodigoHtml.="<tr><td style='font-size: 10px;'>CÉDULA/RUC:   </td><td style='font-size: 10px;'>".$xCedulaCliente."</td>".
                                     "<td style='font-size: 10px;'>NOMBRE:       </td><td style='font-size: 10px;'>".$xNombreCliente."</td></tr>";
                    $CodigoHtml.="<tr><td style='font-size: 10px;'>FECHA:        </td><td style='font-size: 10px;'>".$x_audit_fecha. "</td>".
                                     "<td style='font-size: 10px;'>TELÉFONOS:    </td><td style='font-size: 10px;'>".$xTelefonoCliente."</td></tr>";
                    $CodigoHtml.="<tr><td style='font-size: 10px;'>EMAIL:        </td><td style='font-size: 10px;'>".$xEmailCliente."</td>".
                                     "<td style='font-size: 10px;'>DIRECCIÓN:    </td><td style='font-size: 10px;'>".$xDireccionCliente."</td></tr>";   
                    $CodigoHtml.="</table>";
                    $CodigoHtml.="<center></center>";    
                    $CodigoHtml.="<table  width=100% >";                    
                    $CodigoHtml.="<tr><td width=15%></td><td style='font-size: 12px;color:#FFFFFF;' width=25%>A</td><td width=15%></td><td width=45%></td></tr>";    

                    $CodigoHtml.="</table>";          
                                                                                        
                    $CodigoHtml.="<table  width=100% >";
                    $CodigoHtml.="<tr><td width=15% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>COD ÍTEM</b></td><td width=40% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>DESCRIPCIÓN</b></td><td width=15% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>CANTIDAD</b></td><td width=15% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>PRECIO UNIT.</b></td><td width=15% ALIGN='CENTER' style='background-color: #000000; color: #FFFFFF;'><b>TOTAL</b></td></tr>";
     
                           
                            #----- Detalle Factura --------------------------------
                             $StrSql = "SELECT * FROM movref WHERE IdMov = $xIdMov";
                             $rs     = mysqli_query($conexion,$StrSql);
                             while($regDetalle= mysqli_fetch_array($rs))
                             {
                              $xIdReferencia     = $regDetalle['IdReferencia'];
                              $xCantidad         = $regDetalle['Cantidad'];
                              $xPrecio           = $regDetalle['Precio'];
                              $xTotalLinea       = $regDetalle['TotalLinea'];
                              $StrSql            = "SELECT DescripcionReferencia FROM referencias WHERE IdReferencia = $xIdReferencia";
                              $rsDetalle         = mysqli_query($conexion,$StrSql);
                              $regReferencia     = mysqli_fetch_assoc($rsDetalle);
                              $xDescripcionItem  = $regReferencia['DescripcionReferencia'];
                              $CodigoHtml.=        "<tr style='font-size: 10px;'>".
                                                      "<td>".str_pad($xIdReferencia,7,'0',STR_PAD_LEFT)."</td>".
                                                      "<td>".substr($xDescripcionItem,0,40)."</td>".
                                                      "<td ALIGN='right'>".number_format($xCantidad,2,'.',',')."</td>".                                                      
                                                      "<td ALIGN='right'>".number_format($xPrecio,2,'.',',')."</td>".
                                                      "<td ALIGN='right'>".number_format(($xCantidad*$xPrecio),2,'.',',')."</td></tr>";


                                        $strSeries="select * from ventasitemsseries where IdMov=$xIdMov".
                                                   " and IdReferencia=$xIdReferencia";
                                        $rsseries = mysqli_query($conexion,$strSeries);
                                        $CodigoHtml.="<tr style='font-size: 10px;'><td colspan='5'><b>Números de Serie : </b>";
                                       // $CodigoHtml.="<tr style='font-size: 10px;'><td colspan='5'>";
                                        $contador=0;
                                        //$contadorRegistros=0;
                                        $cantidadRegistros = $rsseries->num_rows;
                                        while($regcomseries= mysqli_fetch_array($rsseries))
                                        {
                                           // $contadorRegistros++;
                                           $contador++;
                                           if($contador<$cantidadRegistros)
                                               $CodigoHtml.=$regcomseries['IdNumeroSerie']." - ";
                                            else
                                            
                                               $CodigoHtml.=$regcomseries['IdNumeroSerie'];
                                             // $contador=0;
                                             // $CodigoHtml.="<tr style='font-size: 10px;'><td colspan='5'>";
                                            
                                            
                                        }
                                        $CodigoHtml.="</td></tr>";

                             }
                             $CodigoHtml.="<tr></td><td colspan='5'> </td><td style='font-size: 12px;color:#FFFFFF;'>2 </td></tr>";
                             $CodigoHtml.="</table>";  


                             $CodigoHtml.="<table width=100%>
                                             <tr><td width=30% ALIGN='CENTER' ><b>Firma Autorizada</b></td>
                                                 <td width=5% ALIGN='CENTER' ></td>
                                                 <td width=30% ALIGN='CENTER' ><b>Recibí Conforme</b></td>
                                                 <td width=5% ALIGN='CENTER' ></td>
                                                 <td width=15% style='font-size: 10px;'>SUBTOTAL:</td><td width=15% style='font-size: 10px;' ALIGN='right'>$".number_format($xSubtotal,2,'.',',')."</td></tr>";
                            $CodigoHtml.="<tr><td colspan='4'></td><td>DESCUENTO:</td><td style='font-size: 10px;' ALIGN='right'>$".number_format($xDescuento,2,'.',',')."</td></tr>";
                           // $CodigoHtml.="<tr><td colspan='4'></td><td>% IVA:    </td><td style='font-size: 10px;' ALIGN='right'>%".number_format($xPorcentajeIva,2,'.',',')."</td></tr>";
                            $CodigoHtml.="<tr><td colspan='4'></td><td>VALOR IVA 12%:</td><td style='font-size: 10px;' ALIGN='right'>$".number_format($xImpuesto,2,'.',',')."  </td></tr>";
                            $CodigoHtml.="<tr><td ALIGN='CENTER'>-----------------------------------------</td><td></td><td ALIGN='CENTER'>-----------------------------------------</td><td></td><td size: 10px;'>TOTAL:</td><td style='font-size: 10px;' ALIGN='right'>$".number_format($xTotal,2,'.',',')."</td></tr></table>"; 

                            
        
                             $CodigoHtml.="<br>";
                             $CodigoHtml.="<br>";
                             $CodigoHtml.="<div style='width:50%;'>";
                             $CodigoHtml.="<table border=1 >";
                            // $CodigoHtml.="<tr><td width=50%></td><td width=50></td></tr>";
                             $CodigoHtml.="<tr><td colspan='2' ALIGN='CENTER'>FORMAS DE PAGO</td></tr>";
                             #------ Formas de Pago----------------
                             $StrSql = "SELECT * FROM formapagofactura ".
                                      " WHERE IdMovta = $xIdMov ".
                                        " AND IdAlmacen = $xIdAlmacen ".
                                        " AND TipDoc = $xIdTipDoc ";
                                      
                             $rs     = mysqli_query($conexion,$StrSql);
                             while ($regFPago= mysqli_fetch_array($rs))
                             {
                                $xIdFormapago= $regFPago['IdFormaPago'];
                                $xIdTarjeta  = $regFPago['IdTarjetas'];
                                $xIdBanco    = $regFPago['IdBanco'];
                                $xValorFormaPago = $regFPago['Valor'];
                                #-----ontiene nombre forma pago------------------------------
                                $StrSql="select * from formapago where IdFormaPago=$xIdFormapago";
                                $rsFormaPago  = mysqli_query($conexion,$StrSql);
                                $regFormaPagos= mysqli_fetch_assoc($rsFormaPago);
                                $xNombreFormaPago = $regFormaPagos['DescripcionFormaPago'];
                                #-----ontiene nombre bancos------------------------------
                                $StrSql="select * from bancos where IdBanco='$xIdBanco'";
                                $rsBanco  = mysqli_query($conexion,$StrSql);
                                $regBanco= mysqli_fetch_assoc($rsBanco);
                                $xNombreBanco = $regBanco['DescripcionBanco'];
                                #-----ontiene nombre tarjetas------------------------------
                                $StrSql="select * from tarjetas where IdTarjeta='$xIdTarjeta'";
                                $rsTarjetas   = mysqli_query($conexion,$StrSql);
                                $regTarjeta= mysqli_fetch_assoc($rsTarjetas);
                                $xNombreTarjeta = $regTarjeta['DescripcionTarjeta'];     
                                #---------arma String con todo el desglose del pago ----#                           
                                $strFormaPago =$xNombreFormaPago." ".$xNombreTarjeta." ".$xNombreBanco;
                                $CodigoHtml.="<tr><td>$strFormaPago</td><td ALIGN='right'>$".number_format($xValorFormaPago,2,'.',',')."</td></tr>";
                            } 
                            //$CodigoHtml.="<tr><td></td><td></td></tr>
                            $CodigoHtml.="</table></div>";
                            $CodigoHtml.="<br>";
                            $CodigoHtml.="<br>";
                            $CodigoHtml.="<center style='font-size: 10px;font-family: Poppins, sans-serif;'>MUCHAS GRACIAS POR SU COMPRA</center><br>";
                            $CodigoHtml.="<center style='font-size: 10px;font-family: Poppins, sans-serif;'>SALIDA LA MERCADERÍA NO SE ACEPTAN DEVOLUCIONES</center>";                            
                            $CodigoHtml.="<br>";
                            $CodigoHtml.="<div style='display: flex;justify-content:center;'>";
                            $CodigoHtml.="<button onclick=generarPdf(); style='align-item:center;background-color:black;border-radius: 50px;padding: 10px;'>";
                            $CodigoHtml.="<a style='color: white;font-size: 15px;text-decoration: none;' href='javascript:window.print();'>Imprimir</a>";
                            $CodigoHtml.="</button>";
                            $CodigoHtml.="</div>";
                            // $CodigoHtml.="</div>";                         
                            $CodigoHtml.="</body>";
                            $CodigoHtml.="</html>";   


   }
   // echo $CodigoHtml;
   require("dompdf/autoload.inc.php");
   use Dompdf\Dompdf;
   $documentopdf = new Dompdf();
   $documentopdf->loadHtml(utf8_encode($CodigoHtml));
   $documentopdf->setPaper("A4", "portrait");
   $documentopdf->render();
   $documentopdf->stream("ComprobanteVenta".$xIdMov.".pdf", ["Attachment" => true]);
   
   
   

