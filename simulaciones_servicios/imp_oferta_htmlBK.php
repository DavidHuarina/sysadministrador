<?php
session_start();
$dbh = new Conexion();
$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();
if(isset($_GET['cod'])){
  $codigo=$_GET['cod'];
}else{
  $codigo=0;
}
$usd=6.96;

$nombreClienteX=obtenerNombreClienteSimulacion($codigo);

$stmt1 = $dbh->prepare("SELECT sc.*,es.nombre as estado from simulaciones_servicios sc join estados_simulaciones es on sc.cod_estadosimulacion=es.codigo where sc.cod_estadoreferencial=1 and sc.codigo='$codigo'");
      $stmt1->execute();
      $stmt1->bindColumn('codigo', $codigoX);
            $stmt1->bindColumn('nombre', $nombreX);
            $stmt1->bindColumn('fecha', $fechaX);
            $stmt1->bindColumn('cod_responsable', $codResponsableX);
            $stmt1->bindColumn('estado', $estadoX);
            $stmt1->bindColumn('cod_plantillaservicio', $codigoPlan);
            $stmt1->bindColumn('dias_auditoria', $diasSimulacion);
            $stmt1->bindColumn('utilidad_minima', $utilidadIbnorcaX);
            $stmt1->bindColumn('productos', $productosX);
            $stmt1->bindColumn('sitios', $sitiosX);
            $stmt1->bindColumn('anios', $anioX);
            $stmt1->bindColumn('porcentaje_fijo', $porcentajeFijoX);
            $stmt1->bindColumn('afnor', $afnorX);
            $stmt1->bindColumn('porcentaje_afnor', $porcentajeAfnorX);
            $stmt1->bindColumn('id_tiposervicio', $idTipoServicioX);
            $stmt1->bindColumn('alcance_propuesta', $alcanceSimulacionX);
            $stmt1->bindColumn('descripcion_servicio', $descripcionServSimulacionX);

      while ($row1 = $stmt1->fetch(PDO::FETCH_BOUND)) {
        $descripcionServSimulacionX=$descripcionServSimulacionX;
        $anioX=$anioX;
        $anioLetra=strtolower(CifrasEnLetras::convertirNumeroEnLetras($anioX));

        $gestionInicio=(int)strftime('%Y',strtotime($fechaX));
      }
/*                        archivo HTML                      */

?>
<!-- formato cabeza fija para pdf-->
<html><head>
    <link href="../assets/libraries/plantillaPDFOfertaPropuesta.css" rel="stylesheet" />
   </head><body>
   <header class="header">            
            <div id="header_titulo_texto"><center><label class="text-muted font-weight-bold">
              <small><small><i><u><?=obtenerValorOferta($codOferta,1,$default,1)?></u></i></small></small>
              <b><br>REGISTRO<br><?=obtenerValorOferta($codOferta,2,$default,1)?></b>
            </label></center>
          </div>
          <img class="imagen-logo-der" src="../assets/img/ibnorca2.jpg">
    </header>
    <footer class="footer">
        <table class="table" style="height:30px;width:100%;">
          <tr class="text-muted s-8 font-weight-bold">
            <td width="25%"></td>
            <td class="s-10 text-center" width="15%" style="border-right:1px solid #9c9c9c;padding:2px;">IBNORCA ??</td>
            <td class="text-center" width="30%" style="border-right:1px solid #9c9c9c;padding:2px;">C??digo: REG-PRO-TCS-03-05_02</td>
            <td class="text-center" width="15%" style="border-right:1px solid #9c9c9c;padding:2px;">V: 2019-11-06</td>
            <td class="text-center" width="15%" style="padding:2px;"></td>
          </tr>
       </table>
     </footer>

  <div class="pagina">
    <div class="container" style="width:100% !important;">
       <div class="float-left pl-6 pt-2">
         <div class="s-9 text-left"><label class="">Nuestra Fecha</label><br> <?=obtenerValorOferta($codOferta,4,$default,1)?></div>
       </div> 
       <div class="float-left pl-20 pt-2">
         <div class="s-9 text-left"><label class="">Nuestra Referencia</label><br> <?=obtenerValorOferta($codOferta,5,$default,1)?></div>  
       </div> 
    </div>

    <div class="pt-8 s-10 pl-6">
        <div class="">Se??ores: </div>
        <div class=""><?=$nombreClienteX?></div>
        <div class="">Ciudad | Bolivia.- </div>
        
    </div>
    <!--<div class="pt-2 s-10 pl-6 font-weight-bold">
        <div class="">Atn.: &nbsp;Nombre</div>
        <div class="pl-6">Cargo</div>
        
    </div>-->
    <div class="pt-2">
        <div class="s-11 font-weight-bold text-justificar text-right">Ref: <u><?=strtoupper($descripcionServSimulacionX)?></u></div>
    </div>
    <div class="pt-2 pl-6 pr-6 text-justificar s-9">
        <p class="pb-2 s-9">De nuestra consideraci??n:</p>
        <p><?=obtenerValorOferta($codOferta,8,$default,1)?> <?=$descripcionServSimulacionX?>.</p>
        <p><?=obtenerValorOferta($codOferta,8,$default,2)?></p>
        <p><?=obtenerValorOferta($codOferta,8,$default,3)?></p>
        <p class="pt-2"><?=obtenerValorOferta($codOferta,8,$default,4)?></p>
        <p class="pt-2 text-right">Saluda a usted muy atentamente,</p>

        <p class="pt-8 text-right"><?=ucfirst(namePersonalCompleto(obtenerValorConfiguracion(68)));?><br>
           DIRECTOR NACIONAL DE EVALAUCI??N<br> 
           DE LA CONFORMIDAD
        </p>
    </div>
    <div class="saltopagina"></div>
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,1);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">1. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <p class="font-weight-bold">1.1. &nbsp;&nbsp;Quienes somos</p>
          <table>
          <tr>
            <td width="30%"><div class="card-imagen"><img src="../assets/img/ibnorca2.jpg" alt="NONE" width="200px" height="150px"></div></td>
            <td class="text-justificar"><p><?=str_replace("\n", "</p><p>",obtenerValorOferta($codOferta,10,$default,1))?></p></td>
          </tr>
        </table>
    </div>

    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold">1.2. &nbsp;&nbsp;Proceso de Certificaci??n</p>
        <table>
          <tr>
            <td width="38%"><div class="card-imagen"><img src="../assets/libraries/img/logos_oferta/certificacion.jpg" alt="NONE" width="200px" height="100px"></div></td>
            <td class="text-justificar"><p><?=str_replace("\n", "</p><p>",obtenerValorOferta($codOferta,11,$default,1))?></p></td>
          </tr>
        </table>
        <br>
        <div class="pl-6 pr-6 text-justificar">
            <p class="text-danger">COMERCIAL</p>
            <img src="../assets/libraries/img/logos_oferta/cert.jpg" alt="NONE" width="100%" height="150px">
            <p class="text-danger">CERTIFICACI??N ??? Ciclo de certificaci??n (<?=$anioX?> a??os)</p>
        </div>
        <table class="table pt-4">
                <tr class="s-12 text-white bg-plomo">
                    <td width="35%">CONCEPTO</td>
                    <td width="65%">DESCRIPCI??N</td>
                </tr>
                <tr>
                    <td class="border-b">
                       <div class="card">
                           <div class="card-imagen"><img src="../assets/libraries/img/logos_oferta/1.jpg" alt="NONE"></div>
                           <div class="card-titulo font-weight-bold">AUDITORIA DE CERTIFICACION DE PRODUCTO CON SELLO IBNORCA / EVALUACION DE CONFORMIDAD DE PRODUCTO SEG??N REGLAMENTO T??CNICO </div>
                       </div>   
                    </td>
                    <td class="border-b">
                        <p>Proceso mediante el cual se eval??a la conformidad del producto y el proceso de producci??n en base a los criterios establecidos en la norma t??cnica, Especificaci??n T??cnica Disponible o Reglamento T??cnico.  Las actividades a realizar son:</p>
                        <div class="pl-4">
                            <div>-  Evaluaci??n de materias primas y materiales</div>
                            <div>-  Evaluaci??n del registro hist??rico</div>
                            <div>-  Toma de muestras de planta y mercado</div>
                            <div>-  Realizaci??n de ensayos en laboratorio designado/acreditado</div>
                            <div>-   Evaluaci??n del Sistema de Gesti??n conforme a la Especificaci??n    ESP-TCP-04A_00.</div>
                        </div>
                        <p>Resultado del proceso:  Informe de auditor??a</p>
                    </td>
                </tr>
                <tr>
                    <td class="border-b">
                       <div class="card">
                           <div class="card-imagen"><img src="../assets/libraries/img/logos_oferta/2.jpg" alt="NONE"></div>
                           <div class="card-titulo font-weight-bold">DECISI??N DE LA CERTIFICACION DE PRODUCTO CON SELLO IBNORCA / OTORGAMIENTO DEL DOCUMENTO DE CONFORMIDAD DE PRODUCTO SEG??N REGLAMENTO T??CNICO </div>
                       </div>   
                    </td>
                    <td class="border-b">
                        <p>El informe de auditor??a, es presentado al Consejo Rector de Certificaci??n para su evaluaci??n y recomendaci??n a la Direcci??n Ejecutiva de IBNORCA, instancia que aprueba y otorga:</p>
                        <div class="pl-4">
                            <div>-  La certificaci??n de producto con SELLO IBNORCA. Resultado: Certificado, Resoluci??n administrativa y Contrato de Autorizaci??n de Uso del Sello.</div>
                            <div>-  La conformidad del producto seg??n Reglamento T??cnico. Resultado: Documento de conformidad de producto. </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border-b">
                       <div class="card">
                           <div class="card-imagen"><img src="../assets/libraries/img/logos_oferta/3.jpg" alt="NONE"></div>
                           <div class="card-titulo font-weight-bold">MANTENIMIENTO DE LA CERTIFICACION DE PRODUCTO CON SELLO IBNORCA / EVALUACION DE CONFORMIDAD SEG??N REGLAMENTO T??CNICO </div>
                       </div>   
                    </td>
                    <td class="border-b">
                        <p>El certificado de producto con Sello IBNORCA / documento de conformidad de producto es v??lida por tres a??os, durante este periodo se realizar?? auditorias de seguimiento como m??nimo una vez al a??o para asegurar el mantenimiento de la conformidad del producto y del sistema de gesti??n. Estas auditor??as siguen las mismas actividades que una auditoria de <b class="text-danger">certificaci??n/renovaci??n<b>. </p>
                        <p>Resultado del proceso: Informe de auditor??a, y resoluci??n del mantenimiento de la certificaci??n de producto con sello IBNORCA y en caso de la evaluaci??n seg??n Reglamento t??cnico se emitir?? un Documento de mantenimiento de conformidad de Producto</p>
                    </td>
                </tr>
                <tr>
                    <td class="border-b">
                       <div class="card">
                           <div class="card-imagen"><img src="../assets/libraries/img/logos_oferta/4.jpg" alt="NONE"></div>
                           <div class="card-titulo font-weight-bold">RENOVACI??N DE LA CERTIFICACI??N DE PRODUCTO CON SELLO IBNORCA /DOCUMENTO DE CONFORMIDAD DEL PRODUCTO.</div>
                       </div>   
                    </td>
                    <td class="border-b">
                        <p>Tres meses antes del vencimiento del certificado de producto con Sello IBNORCA / documento de conformidad de producto, IBNORCA se pone en contacto con la organizaci??n para acordar la renovaci??n del mismo.  La auditor??a de renovaci??n tiene caracter??sticas similares a la auditoria de certificaci??n.</p>
                    </td>
                </tr>
        </table>
    </div>
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,2);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">2. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p class="font-weight-bold">La certificaci??n de producto con SELLO IBNORCA, aplica para los productos: </p>
            <p class="pl-2">
            <?php 

             $stmtAtributos = $dbh->prepare("SELECT * from simulaciones_servicios_atributos where cod_simulacionservicio=$codigo");
             $stmtAtributos->execute();
             $codigoFilaAtrib=0;
             while ($rowAtributo = $stmtAtributos->fetch(PDO::FETCH_ASSOC)) {
               $nombreAtrib=$rowAtributo['nombre'];
               $marcaAtrib=$rowAtributo['marca'];
               $normaXAtrib=$rowAtributo['norma']; 
               ?>
               -   <?=$nombreAtrib?>, Marca <?=$marcaAtrib?>, bajo Norma <?=$normaXAtrib?><br>
               <?php
             }
            ?>
            </p>
        </div>
    </div>
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,3);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">3. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p><?=str_replace("\n", "</p><p>",obtenerValorOferta($codOferta,12,$default,1))?></p>
        </div>
    </div>
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,4);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">4. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p>En la tabla siguiente se muestra el presupuesto para <b>los <?=$anioLetra?> a??os que dura el ciclo de certificaci??n.</b> Dicho presupuesto ha sido elaborado teniendo en cuenta el tama??o de la organizaci??n postulante, las recomendaciones que a tal efecto tiene establecidas el IBNORCA por su propia experiencia y las tarifas vigentes del proceso de certificaci??n.</p>
            <p>Para la certificaci??n, los montos a cancelar son:</p>
        </div>
        <?php 
         for ($i=1; $i <=$anioX ; $i++) { 
             $ordinal=ordinalSuffix($i);
             ?>
        <table class="table pt-2 table-bordered">
                <tr class="s-10 text-white bg-plomo text-center font-weight-bold">
                    <td width="27%">SERVICIO</td>
                    <td width="27%">COSTO</td>
                    <td width="10%">D??AS</td>
                    <td width="16%">AUDITORES</td>
                    <td width="20%">TOTAL COSTO USD</td>
                </tr>
                <tr class="bg-plomo-claro">
                   <td colspan="5"><?=$ordinal?> a??o (GESTI??N <?=$gestionInicio?>)</td>  
                </tr>
                <?php 
                $queryPr="SELECT s.*,t.Descripcion as nombre_serv FROM simulaciones_servicios_tiposervicio s, cla_servicios t where s.cod_simulacionservicio=$codigo and s.cod_claservicio=t.IdClaServicio and s.habilitado=1 and s.cod_anio=$i order by t.nro_orden";
                $stmt = $dbh->prepare($queryPr);
                $stmt->execute();
                $modal_totalmontopre=0;$modal_totalmontopretotal=0;
                while ($rowPre = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $codigoPre=$rowPre['codigo'];
                  $codCS=$rowPre['cod_claservicio'];
                  $tipoPre=strtoupper($rowPre['nombre_serv']);
                  $tipoPreEdit=strtoupper($rowPre['observaciones']);
                  $cantidadPre=$rowPre['cantidad'];
                  $cantidadEPre=$rowPre['cantidad_editado'];
                  $montoPre=$rowPre['monto'];
                  $montoPreTotal=$montoPre*$cantidadEPre;
                  $codTipoUnidad=$rowPre['cod_tipounidad'];
                  $codAnioPre=$rowPre['cod_anio'];
                  $modal_totalmontopre+=$montoPre;
                  $modal_totalmontopretotal+=$montoPreTotal;
                  $montoPreUSD=number_format($montoPre/$usd,2,".","");
                  $montoPreTotalUSD=number_format($montoPreTotal/$usd,2,".","");
                  $montoPre=number_format($montoPre,2,".","");
                  $montoPreTotal=number_format($montoPreTotal,2,".","");
                 ?>
                 <tr>
                    <td><?=$tipoPreEdit?></td>
                    <td><p><?=$montoPreUSD?> USD</p></td>
                    <td class="text-right"><?=$cantidadEPre?></td>
                    <td></td>
                    <td class="text-right"><?=$montoPreTotalUSD?></td>
                </tr>
                 <?php
                }
                ?>
                
                <tr class="font-weight-bold">
                   <td colspan="4">Total, Gesti??n <?=$gestionInicio?></td>
                   <td class="text-right"><?=number_format($modal_totalmontopretotal/$usd,2, ',', '')?></td>  
                </tr>
        </table>
             <?php
             $gestionInicio++;
         }
        ?>
        
        <div class="pl-6 pr-6 pt-1 text-justificar">
            <p><?=str_replace("\n", "</p><p>",obtenerValorOferta($codOferta,13,$default,1))?></p>
            </p>

            <p><i>AMPLIACI??N DEL ALCANCE DE LA CERTIFICACI??N</i></p>
            <p>Luego de obtener la certificaci??n, la organizaci??n puede solicitar la ampliaci??n del alcance de la certificaci??n de productos. Estas ampliaciones deber??n realizarse conforme a lo establecido en el Reglamento de Certificaci??n, para ello la organizaci??n deber?? actualizar los datos remitidos en su solicitud, y el IBNORCA presentar?? una nueva oferta para el proceso. </p>
            <p>ACLARACIONES </p>
            <p>La presenta oferta contempla los servicios de Certificaci??n de producto con SELLO IBNORCA y la evaluaci??n de la conformidad del producto seg??n el Reglamento T??cnico. </p>
            <p>Para la auditoria de certificaci??n y/o evaluaci??n de la conformidad seg??n el Reglamento T??cnico RM 261.2018, se requerir?? que la planta de producci??n se encuentre funcionando, a fin de que el equipo auditor pueda evaluar la fabricaci??n del producto solicitado en el alcance, adem??s, la empresa deber?? contar con el producto disponible para la toma de muestras.</p>
            <p>El costo del Derecho de uso del Sello IBNORCA incluye tambi??n la emisi??n del DOCUMENTO DE CONFORMIDAD DE PRODUCTO seg??n Reglamento T??cnico.</p>
            <p>Asimismo, el costo del Derecho de uso de Sello IBNORCA se mantendr?? el segundo y tercer a??o siempre y cuando se mantengan las condiciones declaradas en el contrato de uso de sello y tarifario vigente. </p>
        </div>  
    </div>
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,5);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">5. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p>Adicionalmente para el proceso de certificaci??n de producto con Sello IBNORCA o emisi??n del DOCUMENTO DE CONFORMIDAD DE PRODUCTO, la empresa debe considerar los costos por muestreo y ensayos realizados durante la auditoria a muestras tomadas en la f??brica y en el mercado.</p>
            <p>Para ello debe considerar lo siguiente:</p>
              <p class="pl-2">1. Si la empresa cuenta con un laboratorio designado por la entidad regulatoria, debe cubrir el costo de muestreo y ensayos con testigo.<p>
              <p class="pl-2">2. Si la empresa cuenta con un laboratorio acreditado     por la entidad regulatoria, entonces debe cubrir el costo de muestreo.<p>
              <p class="pl-2">3. Si la empresa no cuenta con ninguna de las anteriores, entonces debe cubrir con los costos de muestreo y el costo de la ejecuci??n de ensayos en un laboratorio Designado/Acreditado. </p>
        </div>
    </div>
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,6);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">6. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p>Todos los miembros del equipo que participan en la auditoria han sido calificados por IBNORCA de acuerdo a sus procedimientos internos.</p>
            <p>Los procedimientos internos de IBNORCA de calificaci??n de auditores satisfacen los requerimientos de la Norma NB/ISO/IEC 17021 "Evaluaci??n de la conformidad-Requisitos para los organismos que realizan la auditoria y certificaci??n de Sistemas de gesti??n???.</p>
        </div>
    </div>
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,7);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">7. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p>IBNORCA mantiene la confidencialidad de los datos e informaci??n a los que pudiera tener acceso como consecuencia de su actividad de certificaci??n.</p>
            <p>Adem??s, IBNORCA mantiene el compromiso de salvaguardia del nombre de la organizaci??n postulante que se encuentran en fase de evaluaci??n hasta que obtienen el correspondiente certificado, momento en el cual se registra y publica su nombre en la lista de empresas certificadas.</p>
        </div>
    </div> 
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,8);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">8. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p>En un plazo no superior a 7 d??as desde la aceptaci??n de la oferta contrato de certificaci??n, IBNORCA se pondr?? en contacto con el representante de la organizaci??n postulante a objeto de coordinar las fechas de ejecuci??n de la certificaci??n/renovaci??n.</p>
        </div>
    </div>  
      <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,9);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">9. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p><?=str_replace("\n", "</p><p>",obtenerValorOferta($codOferta,14,$default,1))?></p>
        </div>
    </div>
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,10);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">10. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p>La presente oferta contrato tiene un periodo de validez para su aceptaci??n de treinta (30) d??as calendario a partir de la fecha de emisi??n.</p>
            <p>La presente oferta contrato estar?? vigente desde la fecha de su suscripci??n hasta concluir las etapas del proceso de certificaci??n y sus correspondientes plazos de ejecuci??n que ser??n coordinados entre <b>IBNORCA</b> y el <b>CLIENTE</b> de acuerdo a lo establecido en el punto 4.</p>
        </div>
    </div>  
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,11);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">11. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p>Para el caso en que la organizaci??n determine modificar la fecha de realizaci??n de auditoria ya prevista, deber?? comunicar esta determinaci??n con una antelaci??n de <b>10 d??as</b> calendario, antes de la fecha prevista para la auditoria, si no se comunicase en el tiempo determinado la organizaci??n deber?? abonar el lucro cesante y todos los costos de programaci??n de esta actividad.</p>
        </div>
    </div>    
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,12);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }
    ?>
    <div class="s-9 "<?=$estiloTitulo?>>
        <p class="font-weight-bold bg-danger text-white">12. &nbsp;&nbsp;<?=$tituloIndex?></p>
        <div class="pl-6 pr-6 text-justificar">
            <p>???   La organizaci??n postulante deber?? cumplir las disposiciones del Reglamento de Certificaci??n de producto RMT-TCP-01 y la Gu??a de Uso de Marca ESP-TCP-0X, documentos que se encuentran disponibles en su versi??n vigente en la p??gina web <a href="www.ibnorca.org" target="_blank" class="text-azul">www.ibnorca.org</a>, y que ser??n proporcionados por el personal de certificaci??n. En ese sentido, en caso de operar alguna sanci??n que implique suspensi??n o revocatoria de la Certificaci??n, el <b>CLIENTE</b> no podr?? usar las marcas registradas de <b>IBNORCA</b> a partir del momento en el que opere la suspensi??n o revocatoria de la certificaci??n.</p>
            <p>???   Excepcionalmente, la organizaci??n debe permitir a requerimiento de IBNORCA, la participaci??n de representantes de organismos de acreditaci??n, en calidad de observadores, durante la auditor??a.</p>
            <p>???   Durante los procesos de auditor??a, no se permite la intervenci??n del consultor del Sistema de Gesti??n de la organizaci??n. De ser requerida su participaci??n, su rol ser?? ??nicamente de observador.</p>
            <p>???   <b>IBNORCA</b> podr?? realizar auditor??as sea de oficio o por que medie alguna denuncia por parte de terceros. El costo de dichas auditor??as ser?? pagado por el CLIENTE de acuerdo a los aranceles vigentes. En caso que la organizaci??n no acepte la realizaci??n de la auditor??a antes referida, IBNORCA proceder?? a la suspensi??n de la certificaci??n por el tiempo que establezca.</p>
            <p>???   El IBNORCA podr?? sugerir la modalidad de auditor??as remotas.</p>
        </div>
    </div>    
    <div class="saltopagina"></div>
    <div class="s-9">
        <div class="titulo_texto_inf text-danger"><u>ANEXO 1</u></div>
        <div class="text-justificar">
            <p class="s-10 bg-danger text-white"><u>RESOLUCI??N DE LA OFERTA CONTRATO</u></p>
            <p>En caso que cualquiera de las Partes incumpla sus obligaciones sustanciales asumidas en la presente oferta contrato y con lo establecido en el Reglamento de Certificaci??n de Sistemas de Gesti??n de <b>IBNORCA</b>, la parte afectada con el incumplimiento comunicar?? dicho aspecto a la otra parte otorg??ndole un plazo razonable para su debido cumplimiento. Si vencido el plazo otorgado no se cumple la obligaci??n, el presente contrato quedar?? resuelto de pleno derecho y sin necesidad de comunicaci??n previa ni actuaci??n judicial o extrajudicial alguna.</p>
            <p class="s-10 bg-danger text-white"><u>IMPOSIBILIDAD SOBREVENIDA</u></p>
            <p>Ninguna de las Partes ser?? considerada responsable, cuando dicho incumplimiento sea ocasionado por imposibilidad sobreviniente no imputable a la Parte que incumpliere sus obligaciones. Se entiende como imposibilidad sobreviniente a los eventos de caso fortuito y fuerza mayor, sean ??stos de cualquier naturaleza, como ser: cat??strofes, descargas atmosf??ricas, incendios, inundaciones, epidemias, y a hechos provocados por los hombres, tales como y de manera enunciativa, actos de terrorismo o de vandalismo, huelgas, bloqueos de caminos, guerra, sabotajes, actos del Gobierno como entidad soberana o persona privada que alteren substancialmente los derechos y/o obligaciones de las Partes, siempre que tales eventos no sean previsibles, o de serlo, sean imposibles de evitar y por tanto, no sean imputables a la Parte afectada e impidan el cumplimiento de sus obligaciones contra??das en virtud al presente Oferta contrato, de manera general, cualquier causal fuera del control de la Parte que incumpla y no atribuible a ella. La Parte afectada deber?? comunicar a la otra, en forma escrita, dentro de los dos (2) d??as h??biles de conocido el evento proporcionando toda la informaci??n disponible que permita corroborar la imposibilidad sobreviniente. Si la imposibilidad sobreviniente persiste por m??s de treinta (30) d??as, las Partes tendr??n la posibilidad de decidir si contin??an con el presente Oferta contrato o lo resuelven sin penalidad alguna.</p>
            <p class="s-10 bg-danger text-white"><u>SOLUCION DE CONTROVERSIAS CERTIFICACI??N IBNORCA</u></p>
            <p>Las Partes expresan que los t??rminos de la presente Oferta contrato y las obligaciones que de ??l emergen, se encuentran bajo la jurisdicci??n de las leyes y autoridades bolivianas. Todo litigio, discrepancia, cuesti??n y reclamaci??n resultante de la ejecuci??n o interpretaci??n de la presente Oferta contrato o relacionado con ??l, directa o indirectamente, se someter?? previamente a la negociaci??n directa entre Partes. Si agotada la negociaci??n entre Partes o expirado el plazo m??ximo de 10 (Diez) d??as calendario, la controversia no fuese resuelta amigablemente, la misma se resolver?? definitivamente mediante arbitraje en el marco de la Ley No. 708 de 25 de junio de 2015 Ley de Conciliaci??n y Arbitraje o de la ley que regule dicho medio alternativo de soluci??n de controversias. El arbitraje se sujetar?? a las autoridades, reglas y al procedimiento contenido en el Reglamento de Arbitraje del Centro de Conciliaci??n y Arbitraje de la C??mara Nacional de Comercio de la ciudad de La Paz. Igualmente, las Partes hacen constar expresamente su compromiso de cumplir el Laudo Arbitral que se dicte, renunciando en la medida permitida por Ley, a cualquier tipo de recurso contra el mismo. Los costos emergentes del proceso de arbitraje ser??n asumidos en su totalidad por la parte que resulte perdedora. En caso de que se pudiera llegar a una conciliaci??n antes de emitirse el Laudo Arbitral, los costos en los que se hubieran incurrido ser??n cubiertos por ambas partes en iguales porcentajes (50%). Las Partes excluyen de la presente cl??usula la verificaci??n por parte de la autoridad competente, la comisi??n de infracciones en las que incurra LA EMPRESA a los derechos de propiedad intelectual de IBNORCA. No obstante, de ello, una vez verificada la infracci??n, los da??os y perjuicios que genere dicha infracci??n ser??n calculados en negociaci??n o en arbitraje conforme lo establece la presenta clausula.</p>
            <p class="s-10 bg-danger text-white"><u>ACEPTACI??N DE LA OFERTA Y REGLAMENTO DE CERTIFICACI??N POR PARTE DE LA ORGANIZACI??N POSTULANTE</u></p>
            <p><?=str_replace("\n", "</p><p>",obtenerValorOferta($codOferta,15,$default,1))?></p>
            
        </div>
    </div>
    
    <div class="s-9">
        <table class="table-grande pt-1">
                <tr class="s-11 font-weight-bold">
                    <td colspan="2" width="50%">FIRMA</td>
                    <td colspan="2" width="50%">FIRMA</td>
                </tr>   
                <tr class="s-11">
                    <td class="text-left">CLIENTE</td>
                    <td class="text-right text-info">________________________</td>
                    <td class="text-left">IBNORCA</td>
                    <td class="text-right text-info">________________________</td>
                </tr>
                <tr class="s-11 pt-4">
                    <td class="text-left">FECHA: </td>
                    <td class="text-right text-info">________________________</td>
                    <td class="text-left">FECHA: </td>
                    <td class="text-right text-info">________________________</td>
                </tr>   
        </table>
    </div>

    <!--<div class="saltopagina"></div>-->
 </div>  

</body></html>