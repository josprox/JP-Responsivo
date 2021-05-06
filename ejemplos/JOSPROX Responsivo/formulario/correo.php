<?php

$conexión = mysqli_connect("localhost", "root", "", "bd_pruebas");

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$correo1 = $_POST['correo1'];
$correo2 = $_POST['correo2'];
$asunto = $_POST['principal'];
$mensaje = $_POST['texto'];

/*if($_FILES["archivos"]){
    $nombre_base = basename($_FILES["archivos"]["name"]);
    $nombre_final = date("d-m-y") ."-" . date("h-i-s") . "-" . $nombre_base;
    $ruta= 'archivos/' . $nombre_final;
    $subirarchivo = move_uploaded_file($_FILES["archivos"]["tmp_name"], $ruta);
    if($subirarchivo){
        $insertarSQL = "INSERT INTO informes (nombre, apellidos, correo, asunto, mensaje, archivo)
         VALUES ('$nombre', '$apellido', '$correo', '$asunto', '$mensaje', '$ruta')";
         $resultado = mysqli_query($conexión, $insertarSQL);
         if($resultado){
             echo "<script> alert('El mensaje se envió correctamente a la base de datos en caso de un archivo');
             window.history.go(-1);
             </script>";
         }else{
             printf("Error mensaje: %s\n", mysqli_error($conexión));
         }
    }
}*/

$cuerpo = 'Nombre completo: '. $nombre . " " . $apellido . "<br>Correo: " . $correo . "<br>Asunto: " . $asunto . "<br>Mensaje: " . $mensaje . "<br>Correo alternativo: " . $correo1 . "@" . $correo2;

//importar php mailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmail/Exception.php';
require 'phpmail/PHPMailer.php';
require 'phpmail/SMTP.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.ionos.mx';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'joss@int.josprox.com';                     //SMTP username
    $mail->Password   = 'Andyyyo12?';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom( $correo, $nombre);
    $mail->addAddress('joss@int.josprox.com');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Prueba dev formularios';
    $mail-> CharSet = 'UTF-8';
    $mail->Body    = $cuerpo;

    $mail->send();
    echo '
    <script> alert("El mensaje se envió correctamente, actualmente no funciona los archivos adjuntos, esperar una actualizacion.");
    window.history.go(-1);
    </script>';
} catch (Exception $e) {
    echo "Tuvimos un error, pruebalo mas tarde: {$mail->ErrorInfo}";
}

?>