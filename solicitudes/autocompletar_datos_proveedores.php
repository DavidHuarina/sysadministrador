<?php
session_start();
require_once '../conexion.php';

$dbh = new Conexion();
$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

// Si no hay búsqueda, mostrar un arreglo vacío y salir
if (empty($_GET["busqueda"])) {
    echo "[]";
    exit;
}
$busqueda = $_GET["busqueda"];
$stmt = $dbh->prepare("SELECT p.* from af_proveedores p where p.nombre like '%$busqueda%' or p.nit like '%$busqueda%' limit 20");
$stmt->execute();
//$stmtProveedor->execute();
$proveedores=[];$i=0;
   while ($rowProv = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $codigoX=$rowProv['codigo'];
    $nombreX=$rowProv['nombre'];
    $labelProveedor=$nombreX;
    $imagenProveedor="../assets/img/clientes.jpg"; 
    $labelProveedor.=" (Registrado)"; 

    if(!($rowProv['nit']==""||$rowProv['nit']==0)){
      if($rowProv['cod_empresa']==1){
        $labelProveedor.=" CI/DNI: ".$rowProv['nit']." ";
      }else{
        $labelProveedor.=" NIT: ".$rowProv['nit']." "; 
      }  
    }
    $clase="N";
   $objetoLista = array('label' => trim($labelProveedor),'value' => $codigoX,'imagen' => $imagenProveedor,'proveedor' => $rowProv['nombre'],'tipo' => $rowProv['cod_empresa'],
    'nombre' => $rowProv['nombre'],'paterno' => '','materno' => '',
    'pais' =>1,'departamento' =>1,'ciudad' => 1,'clase' => $clase
    ,'nit' => $rowProv['nit']
    ,'identificacion' => $rowProv['nit']);
    $proveedores[$i]=$objetoLista;
    $i++;
  }  
//$proveedores = $stmt->fetchAll(PDO::FETCH_OBJ);
echo json_encode($proveedores);
