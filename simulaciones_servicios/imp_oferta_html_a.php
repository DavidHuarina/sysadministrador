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
        $alcanceSimulacionX=$alcanceSimulacionX;
        $anioX=$anioX;
        $anioLetra=strtolower(CifrasEnLetras::convertirNumeroEnLetras($anioX));

        $gestionInicio=(int)strftime('%Y',strtotime($fechaX));
        $correoResponsable=obtenerCorreoPersonal($codResponsableX);
        $numeroOferta=$nombreX;
      }
/*                        archivo HTML                      */

?>
<!-- formato cabeza fija para pdf-->
<html><head>
    <link href="../assets/libraries/plantillaPDFOfertaPropuesta.css" rel="stylesheet" />
   </head><body>
   <header class="header">            
            <div id="header_titulo_texto"><center><label class="text-muted font-weight-bold">
              <small><small><i><u>Instituto Boliviano de Normalizaci??n y Calidad</u></i></small></small>
              <b><br><br>OFERTA CONTRATO</b>
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
         <div class="s-9 text-left"><label class="">Nuestra Referencia</label><br> <?php
            $codAreaX=obtenerCodigoAreaPlantillasServicios(obtenerPlantillaCodigoSimulacionServicio($codigo));
            $areaX=abrevArea_solo($codAreaX);
            echo $numeroOferta." - ".$areaX;?></div><!--<?=obtenerValorOferta($codOferta,5,$default,1)?>-->  
       </div> 
    </div>

    <div class="pt-8 s-10 pl-6">
        <div class="">Se??ores: </div>
        <div class=""><?=$nombreClienteX?></div>
        <div class=""><?php 
            echo ucfirst(strtolower(obtenerValorOferta($codOferta,23,$default,1)))." | ".obtenerValorOferta($codOferta,24,$default,1)." .-";
             ?></div>
        
    </div>
    <div class="pt-2 s-10 pl-6">
        <div class="">A/A: &nbsp;&nbsp;<?=obtenerValorOferta($codOferta,8,$default,5)?></div>
        <div class="pl-6 font-weight-bold"><?=obtenerValorOferta($codOferta,8,$default,6)?></div>
        
    </div>
    <div class="pt-2">
        <div class="s-11 font-weight-bold text-justificar text-right">Ref: <u><?=obtenerValorOferta($codOferta,7,$default,1)?></u></div>
    </div>
    <div class="pt-2 pl-6 pr-6 text-justificar s-9">
        <p class="pb-2 s-9">De nuestra consideraci??n:</p>
        <p><?=obtenerValorOferta($codOferta,8,$default,1)?></p>
        <!--<p><?=obtenerValorOferta($codOferta,8,$default,11)?></p>-->
        <p>La presente propuesta ha sido confeccionada en base a los datos suministrados en el cuestionario de solicitud del servicio.</p>
        <p>Para dar inicio al proceso de certificaci??n y la coordinaci??n de auditor??as, requerimos nos env??e la oferta contrato llenando los datos correspondientes a la cl??usula primera del anexo II y su firma al final del mismo como constancia de aceptaci??n a las condiciones establecidas, al correo electr??nico: 
          <?=obtenerValorOferta($codOferta,25,$default,1)?>.
        </p>
        <?php 
        if(obtenerValorOferta($codOferta,8,$default,4)!=""){
         ?><p><?=obtenerValorOferta($codOferta,8,$default,4)?></p><?php 
        } 
        ?>
        <p>Si desea cualquier informaci??n adicional o aclaraci??n, podemos coordinar una reuni??n con nuestro equipo de trabajo.</p>
        <p class="pt-2 text-left">Atentamente,</p>

        <p class="pt-6 text-left"><?=ucfirst(namePersonalCompleto(obtenerValorConfiguracion(68)));?><br>
           <b>DIRECTOR NACIONAL DE EVALAUCI??N<br> 
           DE LA CONFORMIDAD</b>
        </p>
    </div>
    <div class="saltopagina"></div>
    <?php 
    $tituloIndex=obtenerValorOferta($codOferta,23,$default,1);
    $estiloTitulo="";
    if(trim($tituloIndex)==""){
      $estiloTitulo="style='display:none;'";
    }

    $quienesSomos="IBNORCA es un organismo privado sin fines de lucro y de ??mbito nacional que tiene como funciones las actividades de Normalizaci??n t??cnica, Certificaci??n, Capacitaci??n e Inspecci??n, y se constituye en uno de los pilares fundamentales del Sistema Boliviano de Normalizaci??n, Metrolog??a, Acreditaci??n y Certificaci??n ??? SNMAC.

IBNORCA es el ??nico representante de la Organizaci??n Internacional de Normalizaci??n (ISO) en Bolivia y el ??nico organismo acreditado en Certificaci??n de Sistemas de Gesti??n en el pa??s por la Direcci??n T??cnica de Acreditaci??n (DTA) del IBMETRO conforme a las normas internacionales ISO/IEC 17021 e ISO/IEC 17065, cumpliendo con el Decreto supremo 29519 del 16 de abril de 2008, que indica que es atribuci??n del IBMETRO la acreditaci??n de los organismos de certificaci??n que operar en el territorio Nacional seas, estos nacionales o internacionales como condici??n necesaria para que sus certificaciones sean reconocidos a nivel del Estado Boliviano.

La acreditaci??n garantiza y reconoce que IBNORCA tiene las competencias y cumple los requisitos para realizar labores de certificaci??n a las organizaciones bajo distintos esquemas, entre ellos, los de sistemas de gesti??n bajo la MARCA IBNORCA y la certificaci??n de productos con SELLO IBNORCA, adicionalmente verifica si en IBNORCA se ha implementado un Sistema de Gesti??n que asegure la imparcialidad, confidencialidad y calidad de sus certificaciones.

IBNORCA tambi??n cuenta con una alianza estrat??gica con AFNOR por la cual brindamos la certificaci??n IQNET, como reconocimiento internacional a la certificaci??n por los miembros de esta red.";

$poderIbnorca=" El INSTITUTO BOLIVIANO DE NORMALIZACI??N Y CALIDAD (IBNORCA), asociaci??n sin fines de lucro legalmente constituida, con NIT N?? 1020745020, que en virtud al Testimonio de Poder N?? 427/2020 de fecha 14 de agosto de 2020 otorgado por ante Notar??a de Fe P??blica de Primera Clase N?? 097 del Distrito Judicial de La Paz, a cargo de la Dra. Patricia Ampuero Carrillo se encuentra debidamente representado en el presente acto por el Sr. Jos?? Jorge Dur??n Guill??n mayor de edad, h??bil por derecho, con C.I. N?? 461774 LP y que en lo sucesivo a los fines del presente contrato se denominar?? simplemente ???IBNORCA???.";

    ?>
    <div class="s-9 ">
        <p class="font-weight-bold bg-danger text-white">&nbsp;&nbsp;QUIENES SOMOS</p>
        <!--<p class="font-weight-bold">1.1. </p>-->
          <table>
          <tr>
            <td width="30%"><div class="card-imagen"><img src="../assets/img/ibnorca2.jpg" alt="NONE" width="200px" height="150px"></div></td>
            <td class="text-justificar"><p><?=str_replace("\n", "</p><p>",$quienesSomos)?></p></td>
          </tr>
        </table>
    </div>

    <div class="s-9 ">
        <center><p class="font-weight-bold s-11" style="color:#AC1904;;"><u>PROPUESTA T??CNICA</u></p></center>
        <!--<p class="font-weight-bold">1.2. &nbsp;&nbsp;Proceso de Certificaci??n</p>
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
            <p><br></p>
            <p class="text-danger">CERTIFICACI??N</p>

            <img src="<?=$pdf_tipo?>" alt="NONE" width="100%" height="200px">
        </div>
        -->
    </div>

    <div class="s-9">
        <p class="font-weight-bold bg-danger text-white">1. &nbsp;&nbsp;ALCANCE DE LA CERTIFICACI??N</p>
        <div class="pl-6 pr-6 text-justificar">
            <p class="font-weight-bold"><?=$alcanceSimulacionX?></p>
            <p class="font-weight-bold">En el/los sitio(s):</p>
            <p class="pl-2">
            <?php 

             $stmtAtributos = $dbh->prepare("SELECT * from simulaciones_servicios_atributos where cod_simulacionservicio=$codigo");
             $stmtAtributos->execute();
             $codigoFilaAtrib=0;
             while ($rowAtributo = $stmtAtributos->fetch(PDO::FETCH_ASSOC)) {
               $nombreAtrib=$rowAtributo['nombre'];
               $dirAtrib=$rowAtributo['direccion'];
               $normaXAtrib=$rowAtributo['norma'];

               $datosAtributos=obtenerAtributoSimulacionServicioDatos($rowAtributo['codigo']); 
               ?>
                 <?=$nombreAtrib?>: <small><?=strtoupper($dirAtrib)?>, <?=$datosAtributos[0]?> - <?=$datosAtributos[1]?></small><br>
               <?php
             }
            ?>
            </p>
        </div>
    </div>
    <div class="s-9 ">
        <p class="font-weight-bold bg-danger text-white">2. &nbsp;&nbsp;CALIFICACI??N DEL EQUIPO AUDITOR</p>
        <div class="pl-6 pr-6 text-justificar">
            <p>Todos los miembros del equipo que participan en la auditoria han sido calificados por IBNORCA de acuerdo a sus procedimientos internos.</p>
            <p>IBNORCA podr?? incluir en el equipo auditor, un auditor en formaci??n, a cuyo efecto comunicar?? a la organizaci??n con la oportunidad debida.</p>
        </div>
    </div>

    <div class="s-9 ">
        <p class="font-weight-bold bg-danger text-white">3. &nbsp;&nbsp;CONFIDENCIALIDAD E IMPARCIALIDAD</p>
        <div class="pl-6 pr-6 text-justificar">
            <p>IBNORCA mantiene la confidencialidad de los datos e informaci??n a los que pudiera tener acceso como consecuencia de su actividad de certificaci??n. As?? mismo, mantiene el compromiso de salvaguardar el nombre de la organizaci??n postulante que se encuentra en fase de evaluaci??n hasta que obtenga el correspondiente certificado, momento en el cual se registra y publica su nombre en la lista de empresas certificadas.</p>
            <p>IBNORCA mantendr?? en todo momento absoluta imparcialidad en la prestaci??n del servicio, cumpliendo los lineamientos establecidos en los Reglamentos espec??ficos y C??digo de ??tica.</p>
        </div>
    </div>
    <div class="s-9 ">
        <p class="font-weight-bold bg-danger text-white">4. &nbsp;&nbsp;VALIDEZ DE LA OFERTA</p>
        <div class="pl-6 pr-6 text-justificar">
          <?php 
          $diasValidez=obtenerValorOferta($codOferta,26,$default,1);
          $diasLiteral=strtolower(CifrasEnLetras::convertirNumeroEnLetras($diasValidez));
          $diasFormaPago=obtenerValorOferta($codOferta,27,$default,1);
          ?>
            <p>La presente oferta tiene un periodo de validez para su aceptaci??n de <b><?=$diasLiteral?> (<?=(int)$diasValidez?>) </b> d??as calendario a partir de la fecha de emisi??n.</p>
        </div>
    </div>




    
    <div class="s-9">
        <p class="font-weight-bold bg-danger text-white">5. &nbsp;&nbsp;PROPUESTA ECON??MICA</p>
        <div class="pl-6 pr-6 text-justificar">
            <p>En la tabla siguiente se muestra la propuesta econ??mica por el servicio solicitado.</p>
        </div>
        <?php 
         for ($i=1; $i <=$anioX ; $i++) { 
             $ordinal=ordinalSuffix($i);
             $tituloRomano="";
             for ($ff=0; $ff < ($i-1); $ff++) { 
                $tituloRomano.="I";
             }
             $tituloTabla="seguimiento ".$tituloRomano;
             $sqlAnio="and s.cod_anio=".$i;
             if($i==1||$i==0){
              $tituloTabla="certificaci??n/renovaci??n";
              $sqlAnio="and s.cod_anio in(".$i.",0)";
             }

             $cantidadPr="SELECT count(*) as cantidad FROM simulaciones_servicios_tiposervicio s, cla_servicios t where s.cod_simulacionservicio=$codigo and s.cod_claservicio=t.IdClaServicio and s.habilitado=1 $sqlAnio order by t.nro_orden";
             $stmtCantidad = $dbh->prepare($cantidadPr);
             $stmtCantidad->execute();
             $resultCantidad = $stmtCantidad->fetch(); 
             if($resultCantidad['cantidad']>0){
               ?>
             <p>Para la auditoria de <b><?=$tituloTabla?></b>:</p>
        <table class="table table-bordered">
                <tr class="s-10 text-white bg-danger text-center font-weight-bold">
                    <td width="27%">CONCEPTO</td>
                    <td width="27%">D??AS <br> AUDITOR</td>
                    <td width="10%">COSTO USD</td>
                </tr>
                <?php 
                $queryPr="SELECT s.*,t.Descripcion as nombre_serv FROM simulaciones_servicios_tiposervicio s, cla_servicios t where s.cod_simulacionservicio=$codigo and s.cod_claservicio=t.IdClaServicio and s.habilitado=1 $sqlAnio order by t.nro_orden";
                $stmt = $dbh->prepare($queryPr);
                $stmt->execute();
                $modal_totalmontopre=0;$modal_totalmontopretotal=0;$modal_totalmontopretotalUSD=0;
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
                  $modal_totalmontopretotalUSD+=$montoPreTotal/$usd;
                  $montoPreUSD=number_format($montoPre/$usd,2,".","");
                  $montoPreTotalUSD=number_format($montoPreTotal/$usd,2,".","");
                  $montoPre=number_format($montoPre,2,".","");
                  $montoPreTotal=number_format($montoPreTotal,2,".","");
                 ?>
                 <tr>
                    <td><?=$tipoPreEdit?></td>
                    <td class="text-right"><?=$cantidadEPre?></td>
                    <td class="text-right"><?=$montoPreTotalUSD?></td>
                </tr>
                 <?php
                }
                ?>
                
                <tr class="font-weight-bold">
                   <td colspan="2">Total, (<?=$ordinal?>) a??o</td>
                   <td class="text-right"><?=number_format($modal_totalmontopretotalUSD,2, ',', '')?></td>  
                </tr>
        </table>
             <?php
             $gestionInicio++;
             }

         }//fin if
        ?>  
 
        <div class="pl-6 pr-6 pt-2 text-justificar">
            <p><?=str_replace("\n", "</p><p>",obtenerValorOferta($codOferta,13,$default,1))?></p>
            </p>
        </div>  
       

    </div>    
    <div class="saltopagina"></div>
    <div class="s-9">
        <div class="titulo_texto_inf text-danger s-11" style="color:#AC1904;"><u>ANEXO I</u></div>
        <div class="s-9 ">
            <p class="s-10 bg-danger text-white">PROCESO DE CERTIFICACI??N</p>
           <div class="text-justificar">
            <p>En un mundo competitivo la certificaci??n hace la diferencia, el objetivo principal es proporcionar confianza a todas las partes interesadas de que una certificaci??n de producto cumple con los requisitos especificados. </p>
            <p>A continuaci??n, se muestra el proceso de certificaci??n IBNORCA.</p>
           </div>   
          <div class="text-justificar">
            <p class="s-11" style="color:#AC1904;"><u>COMERCIAL</u></p>
            <img src="../assets/libraries/img/logos_oferta/certificacion_new.jpg" alt="NONE" width="100%" height="75px">
            <p class="s-11" style="color:#AC1904;"><u>CERTIFICACI??N</u></p>
            <?php
            $tituloImagenTCS="oferta_a_new.jpg";
               if (verificarOfertaFormatoB($codigo)>0) {
                  $tituloImagenTCS="oferta_b_new.jpg"; 
               }
            ?>
            <img src="../assets/libraries/img/logos_oferta/<?=$tituloImagenTCS?>" alt="NONE" width="100%" height="375px">
          </div>


    </div>
         <div class="text-justificar pt-2">
            <p class="s-10 bg-danger text-white">DESCRIPCI??N DE LOS PROCESOS DE CERTIFICACI??N</p>
            <p>Las etapas del proceso de certificaci??n se detallan en el RMT-TC-01 Reglamento de Certificaci??n de Producto, documento disponible en la p??gina web www.ibnorca.org.</p>
            <p><b>NOTA: Si durante los 3 a??os de vigencia del certificado hubiese alg??n cambio en la organizaci??n que afecte al producto, sistema de gesti??n o la informaci??n brindada al inicio del proceso, es responsabilidad de la organizaci??n comunicar de inmediato a IBNORCA para actualizar la propuesta.</b></p>
        </div>
     <div class="saltopagina"></div>
     <div class="titulo_texto_inf text-danger s-11" style="color:#AC1904;"><u>ANEXO II</u></div>
     <div class="titulo_texto_inf text-danger s-13" style="font-size:20px;color:#AC1904;"><u>CONTRATO DE PRESTACI??N DE SERVICIO</u></div>  
     <br>
        <div class="text-justificar">   
          <br>
            <p>Conste por el presente documento privado que al s??lo reconocimiento de firmas podr?? ser elevado a instrumento p??blico, un Contrato Civil de Servicio que se suscribe al amparo de lo previsto por los Art. 519, 568, 732 del C??digo Civil, as?? como otras disposiciones concordantes con la materia al tenor de las siguientes cl??usulas</p>
            <br>
            <p class="s-10 bg-danger text-white">PRIMERA: PARTES</p>
            <p>Constituyen partes integrantes del presente contrato:</p>
            <p class="pl-2">1.1 <?=str_replace("\n", "</p><p class='pl-2'>",$poderIbnorca)?></p>
            <p class="pl-2">1.2 <?=str_replace("\n", "</p><p class='pl-2'>",obtenerValorOferta($codOferta,15,$default,1))?></p>
            <p>A efectos del presente contrato, y seg??n el contexto de cada cl??usula se podr?? referir como ???Partes??? a ambos suscribientes cuando act??en de manera conjunta y simplemente como ???Parte??? cuando la referencia sea a uno solo de ellos.</p>
            
            <p class="s-10 bg-danger text-white">SEGUNDA: OBJETO Y ALCANCE</p>
            <p>El objeto del presente contrato es establecer los t??rminos y condiciones por los que IBNORCA prestar?? sus servicios para la realizaci??n de la auditor??a correspondiente para la Certificaci??n de producto en favor del CLIENTE?? en adelante simplemente los ???Servicios???, el resultado de todo el proceso podr?? culminar con la otorgaci??n o no de la Certificaci??n o mantenimiento de la certificaci??n, seg??n corresponda.</p>
            <p>Forman parte del presente contrato:</p>
            <p>1) La Propuesta T??cnica que forma parte del presente documento<br>2)  Reglamento de Certificaci??n de Producto (disponible en la p??gina web www.ibnorca.org)<br>3)  Gu??a de Uso de Marca (disponible en la p??gina web www.ibnorca.org)</p>
            <p>El Alcance de la Certificaci??n se encuentra definido en el punto 1 de la propuesta t??cnica. La modificaci??n de este alcance podr?? ser solicitado por el CLIENTE o cuando el resultado de las auditor??as as?? lo determine. El alcance definitivo estar?? debidamente consensuado y plasmado en el Certificado.</p>
            
            <p class="s-10 bg-danger text-white">TERCERA: VIGENCIA Y PLAZOS DE EJECUCI??N</p>
            <p>El presente contrato estar?? vigente desde la fecha de su suscripci??n hasta concluir las etapas del proceso de certificaci??n y sus correspondientes plazos de ejecuci??n que ser??n coordinados entre IBNORCA y el CLIENTE de acuerdo a lo establecido en la en la propuesta econ??mica.</p><p>Para el caso en que el CLIENTE requiera modificar la fecha de inicio de cualquier etapa o auditor??as ya previstas y coordinadas, deber?? comunicar esta determinaci??n con una antelaci??n de veinte (20) d??as calendario a la fecha de inicio. En caso de no comunicar dicha modificaci??n dentro del plazo se??alado, el CLIENTE deber?? abonar a IBNORCA todos los costos y gastos en los que se haya incurrido.</p>    
            
            <p class="s-10 bg-danger text-white">CUARTA: CONTRAPRESTACI??N</p>
            <p>El CLIENTE se obliga a cancelar en favor de IBNORCA, la contraprestaci??n de acuerdo a los establecido en el punto 5 de la Propuesta T??cnica.</p>    

            <p class="s-10 bg-danger text-white">QUINTA: FORMA DE PAGO</p>
            <p>Concluida la auditor??a, IBNORCA emitir?? la correspondiente factura, debiendo el CLIENTE realizar el pago correspondiente a m??s tardar dentro de los siguientes <?=$diasFormaPago?> d??as de recibida la misma. En caso que el CLIENTE no pague el monto de la factura en el plazo se??alado, el CLIENTE pagar?? a IBNORCA, el 2 % de inter??s sobre el monto adeudado.</p><p>Asimismo, las Partes aclaran que para el caso que el CLIENTE no solicite la realizaci??n de la auditor??a de certificaci??n de la Etapa II, seg??n los t??rminos y plazos establecidos en el Reglamento de Certificaci??n de Sistemas de Gesti??n de IBNORCA, y en caso que el CLIENTE a??n est?? interesado en continuar el proceso de Certificaci??n correspondiente, deber?? iniciar nuevamente la Etapa I, debiendo pagar por la misma, de acuerdo a la contraprestaci??n acordada mediante la presente cl??usula.</p>     
            <p class="s-10 bg-danger text-white">SEXTA: NATURALEZA DEL CONTRATO E INEXISTENCIA DE RELACI??N LABORAL</p>
            <p>Se deja plenamente establecido que el presente contrato es de naturaleza estrictamente civil debiendo someterse a las normas del C??digo Civil, aclar??ndose en consecuencia que entre el CLIENTE e IBNORCA y entre cada una de las Partes con el personal de la otra no existe absolutamente ninguna relaci??n ni vinculaci??n laboral como tampoco de seguridad social. </p>    
            <p class="s-10 bg-danger text-white">SEPTIMA: AUTORIZACI??N DE USO DE MARCA</p>
            <p>En caso que el CLIENTE obtenga la Certificaci??n por parte de IBNORCA o la renovaci??n de la misma, IBNORCA autoriza al CLIENTE al uso de las marcas y signos distintivos que son propios de IBNORCA.</p><p>La autorizaci??n contenida en el presente documento, solo permanecer?? vigente en tanto la Certificaci??n otorgada al CLIENTE se encuentre vigente. </p><p>El uso de los signos distintivos y marcas de IBNORCA por parte del CLIENTE fuera de las condiciones establecidas en el presente documento y en la Gu??a de Uso de Marca, ser?? causal de retiro de la Certificaci??n y en su defecto infracci??n a la normativa legal aplicable.</p><p>En caso de operar alguna sanci??n que implique suspensi??n o retiro de la Certificaci??n, el CLIENTE no podr?? usar las marcas registradas de IBNORCA a partir del momento en el que opere la suspensi??n o retiro de la certificaci??n.</p>    
            <p class="s-10 bg-danger text-white">OCTAVA: R??GIMEN SANCIONATORIO</p>
            <p>El CLIENTE se somete al r??gimen de suspensi??n, retiro de la Certificaci??n y de sanciones establecido en el Reglamento de Certificaci??n de Producto de IBNORCA.</p>    
            <p class="s-10 bg-danger text-white">NOVENA: APLICACI??N DE REGLAMENTOS DE IBNORCA</p>
            <p>El CLIENTE declara conocer todas y cada una de las condiciones y estipulaciones del Reglamento de Certificaci??n de Producto de IBNORCA, disponible en la p??gina web www.ibnorca.org.</p><p>En este sentido, el CLIENTE se obliga a cumplir todas y cada una de las cl??usulas, condiciones, art??culos, obligaciones y otras establecidas en dicho reglamento. IBNORCA podr?? modificar unilateralmente dicho reglamento. En caso de modificaciones, ??stas ser??n comunicadas y se tendr?? disponible en la p??gina web www.ibnorca.org para su debido cumplimiento.</p>    
            <p class="s-10 bg-danger text-white">D??CIMA: VERIFICACI??N DE CUMPLIMIENTO</p>
            <p>Las Partes acuerdan que IBNORCA podr??, en cualquier momento, realizar acciones de verificaci??n de cumplimiento del presente contrato y de los reglamentos de IBNORCA. El CLIENTE se obliga a proporcionar cualquier informaci??n que requiera IBNORCA, as?? como a permitir el acceso a sus instalaciones sin limitaci??n alguna.</p><p>Entre dichas acciones IBNORCA podr?? realizar auditor??as sea de oficio o por que medie alguna denuncia por parte de terceros. El costo de dichas auditor??as ser?? pagado por el CLIENTE de acuerdo a los aranceles vigentes.</p><p>En caso que la organizaci??n no acepte la realizaci??n de la auditor??a antes referida, IBNORCA proceder?? a la suspensi??n de la certificaci??n por el tiempo que establezca, durante este periodo el CLIENTE deber?? someterse a la auditor??a de verificaci??n mencionada; pasado este periodo IBNORCA retirar?? la certificaci??n.</p>    
            <p class="s-10 bg-danger text-white">D??CIMA PRIMERA: RESOLUCI??N DEL CONTRATO</p>
            <p>En caso que cualquiera de las Partes incumpla sus obligaciones sustanciales asumidas en el presente contrato y con lo establecido en el Reglamento de Certificaci??n de Producto de IBNORCA, la parte afectada con el incumplimiento comunicar?? dicho aspecto a la otra parte otorg??ndole un plazo razonable para su debido cumplimiento. Si vencido el plazo otorgado no se cumple la obligaci??n, el presente contrato quedar?? resuelto de pleno derecho y sin necesidad de comunicaci??n previa ni actuaci??n judicial o extrajudicial alguna. </p>    
            <p class="s-10 bg-danger text-white">D??CIMA SEGUNDA: IMPOSIBILIDAD SOBREVENIDA</p>
            <p>Ninguna de las Partes ser?? considerada responsable, cuando dicho incumplimiento sea ocasionado por imposibilidad sobreviniente no imputable a la Parte que incumpliere sus obligaciones.</p><p>Se entiende como imposibilidad sobreviniente a los eventos de caso fortuito y fuerza mayor, sean ??stos de cualquier naturaleza, como ser: cat??strofes, descargas atmosf??ricas, incendios, inundaciones, epidemias, y a hechos provocados por los hombres, tales como y de manera enunciativa, actos de terrorismo o de vandalismo, huelgas, bloqueos de caminos, guerra, sabotajes, actos del Gobierno como entidad soberana o persona privada que alteren substancialmente los derechos y/o obligaciones de las Partes, siempre que tales eventos no sean previsibles, o de serlo, sean imposibles de evitar y por tanto, no sean imputables a la Parte afectada e impidan el cumplimiento de sus obligaciones contra??das en virtud al presente Contrato o, de manera general, cualquier causal fuera del control de la Parte que incumpla y no atribuible a ella. </p><p>La Parte afectada deber?? comunicar a la otra, en forma escrita, dentro de los dos (2) d??as h??biles de conocido el evento proporcionando toda la informaci??n disponible que permita corroborar la imposibilidad sobreviniente.</p><p>Si la imposibilidad sobreviniente persiste por m??s de <?=$diasLiteral?> (<?=$diasValidez?>) d??as, las Partes tendr??n la posibilidad de decidir si contin??an con el presente Contrato o lo resuelven sin penalidad alguna.</p>    
            <p class="s-10 bg-danger text-white">D??CIMA TERCERA: SOLUCI??N DE CONTROVERSIAS CERTIFICACI??N IBNORCA</p>
            <p>Las Partes expresan que los t??rminos del presente Contrato y las obligaciones que de ??l emergen, se encuentran bajo la jurisdicci??n de las leyes y autoridades bolivianas. Todo litigio, discrepancia, cuesti??n y reclamaci??n resultante de la ejecuci??n o interpretaci??n del presente Contrato o relacionado con ??l, directa o indirectamente, se someter?? previamente a la negociaci??n directa entre Partes. </p><p>Si agotada la negociaci??n entre Partes o expirado el plazo m??ximo de 10 (Diez) d??as calendario, la controversia no fuese resuelta amigablemente, la misma se resolver?? definitivamente mediante arbitraje en el marco de la Ley No. 708 de 25 de junio de 2015 Ley de Conciliaci??n y Arbitraje o de la ley que regule dicho medio alternativo de soluci??n de controversias. </p><p>El arbitraje se sujetar?? a las autoridades, reglas y al procedimiento contenido en el Reglamento de Arbitraje del Centro de Conciliaci??n y Arbitraje de la C??mara Nacional de Comercio de la ciudad de La Paz. Igualmente, las Partes hacen constar expresamente su compromiso de cumplir el Laudo Arbitral que se dicte, renunciando en la medida permitida por Ley, a cualquier tipo de recurso contra el mismo.</p><p>Los costos emergentes del proceso de arbitraje ser??n asumidos en su totalidad por la parte que resulte perdedora. En caso de que se pudiera llegar a una conciliaci??n antes de emitirse el Laudo Arbitral, los costos en los que se hubieran incurrido ser??n cubiertos por ambas partes en iguales porcentajes (50%).</p><p>Las Partes excluyen de la presente cl??usula la verificaci??n por parte de la autoridad competente, la comisi??n de infracciones en las que incurra EL CLIENTE a los derechos de propiedad intelectual de IBNORCA. No obstante, de ello, una vez verificada la infracci??n, los da??os y perjuicios que genere dicha infracci??n ser??n calculados en negociaci??n o en arbitraje conforme lo establece la presenta cl??usula.</p>    
            <p class="s-10 bg-danger text-white">D??CIMA CUARTA: CONDICIONES GENERALES</p>
            <p>EL CLIENTE debe permitir a requerimiento de IBNORCA, la participaci??n de representantes de organismos de acreditaci??n, en calidad de observadores, durante la auditor??a.</p><p>Durante los procesos de auditor??a, no se permite la intervenci??n del consultor del Sistema de Gesti??n de la organizaci??n. De ser requerida su participaci??n, su rol ser?? ??nicamente de observador.</p><p>El IBNORCA podr?? sugerir la modalidad de auditor??as remotas para evaluar los procesos, cuando corresponda.</p>    
            <p class="s-10 bg-danger text-white">D??CIMA QUINTA: ACEPTACI??N Y CONSENTIMIENTO</p>
            <p>Las Partes, cuyas generales de ley se encuentran identificadas en la primera cl??usula del presente contrato, declaran y reconocen que el mismo ha sido le??do y comprendido en su integridad, as?? como los documentos relacionados al mismo, aceptando el contenido y manifestando su pleno consentimiento, sin que medie vicio alguno del consentimiento.</p>    

            
        </div>
    </div>
    
    <div class="s-9 pt-6">
      <table class="table-grande pt-1">
                <tr class="s-11">
                    <td class="text-center text-info" width="25%">________________________</td>
                    <td class="text-center text-white" width="25%">________</td>
                    <td class="text-center text-white" width="25%">________</td>
                    <td class="text-center text-info" width="25%">________________________</td>
                </tr>
                <tr class="s-11 font-weight-bold">
                    <td class="text-center" width="25%">FIRMA<br>CLIENTE</td>
                    <td class="text-center text-white" width="25%">________</td>
                    <td class="text-center text-white" width="25%">________</td>
                    <td class="text-center" width="25%">FIRMA<br>IBNORCA</td>
                </tr>    
        </table>
    </div>

    <!--<div class="saltopagina"></div>-->
 </div>  

</body></html>
