<?php
session_start();
require_once '../conexion.php';
require_once '../functionsGeneral.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

//$direccionServ=obtenerValorConfiguracion(42);//direccion des servicio web
$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();
$globalUser=$_SESSION["globalUser"];


$ciudad=(int)$_GET['ciudad'];
$otra="";
if($_GET['ciudad']==""){
	$ciudad="0";
	$otra=$_GET['otra'];
}

$nombre_contacto="";
if($_GET['nombre_contacto']!=""){
  $nombre_contacto=$_GET['nombre_contacto'];
}
$apellido_contacto="";
if($_GET['apellido_contacto']!=""){
  $apellido_contacto=$_GET['apellido_contacto'];
}
$cargo_contacto="";
if($_GET['cargo_contacto']!=""){
  $cargo_contacto=$_GET['cargo_contacto'];
}
$correo_contacto="";
if($_GET['correo_contacto']!=""){
  $correo_contacto=$_GET['correo_contacto'];
}

$direccion="";
if($_GET['direccion']!=""){
  $direccion=$_GET['direccion'];
}

$telefono="";
if($_GET['telefono']!=""){
  $telefono=$_GET['telefono'];
}
$correo="";
if($_GET['correo']!=""){
  $correo=$_GET['correo'];
}

$mensajeDevuelta="";$errorDevuelta=0;
  // Tipo P=Persona, E=Empresa
if($_GET['tipo']=='E'){
	$codEmpres=2;
}else{//para el cliente
	$codEmpres=1;	
}		

$fechaActual=date("Y-m-d H:i:s");

$nombre=$_GET['nombre'];
$nit=$_GET['nit'];
$sqlDetalle2="INSERT INTO af_proveedores (cod_empresa,nombre,nit,created_by,created_at,direccion,telefono,email,personacontacto,email_personacontacto,cod_estado) 
VALUES ('$codEmpres', '$nombre', '$nit','$globalUser','$fechaActual', '$direccion', '$telefono','$correo','$nombre_contacto $apellido_contacto','$correo_contacto',1)";
$stmtDetalle2 = $dbh->prepare($sqlDetalle2);
$stmtDetalle2->execute();

echo "1####SE REGISTRO SATISFACTORIAMENTE!";

?>