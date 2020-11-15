<?php
namespace Controllers;
/* require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php'; */
use Controllers\PHPMailer\PHPMailer;
use Controllers\PHPMailer\SMTP;
use Controllers\PHPMailer\Exception;
use Models\Compra;
use Models\Ticket;
use Models\DatosTarjeta;
use Models\User;
use Controllers\ProjectionController;
use DAO\TicketDAO;
use DAO\CompraDAO;
use DAO\DatosTarjetaDAO;
use DAO\UserDao;


class ComprasController{
    private $ticketDao;
    private $compraDao;
    private $datosTarjetaDao;
    private $projController;
    private $userDao;
    private $actualUser;


    public function __construct() {
        $this->ticketDao = new TicketDAO();
        $this->compraDao = new CompraDAO();
        $this->datosTarjetaDao = new DatosTarjetaDAO();
        $this->projController = new ProjectionController();
        $this->userDao = new UserDAO();
    }

    public function getAll(){
        return $this->cinemaDao->getAll();
    }

    public function getAllSorted(){
        $sorted=$this->cinemaDao->getAll();
        usort($sorted,array("Models\Cinema","compare"));
        return $sorted;
    }

    public function add($name,$provinceId,$cityId,$address){
        $id=time(); //number of seconds since January 1 1970
        $locContro=new LocationController();
        $province=$locContro->getProvinceById($provinceId);
        $city=$locContro->getCityById($cityId);
        $newCinema=new Cinema($name,$id,$province,$city,$address);
        $this->cinemaDao->add($newCinema);
        $this->showCinemasList();
    }

    public function modify($name,$id,$provinceId,$cityId,$address){
        $locContro=new LocationController();
        $province=$locContro->getProvinceById($provinceId);
        $city=$locContro->getCityById($cityId);
        $this->cinemaDao->modify(new Cinema($name,$id,$province,$city,$address));
        $this->showCinemasList();
    }

    public function remove($id){
        if ($this->cinemaDao->remove($id)>0) {
            $this->showCinemasList();
        }
        
    }

    public function showCinemasList(){
        $cinemas=$this->getAll();
        require_once VIEWS_PATH."cinema_list.php";
    }

    public function showAddCinema(){
        
        $locationContr=new LocationController();
        $provinces=$locationContr->getAllProvinces();
        $initCities=$locationContr->getCitiesByProvince(1);  
        require_once VIEWS_PATH."add_cinema.php";
    }

    public function showModifyCinema($id){
        $locContro=new LocationController();
        $cinema=$this->cinemaDao->getById($id);
        $provinces=$locContro->getAllProvinces();
        $initCities=$locContro->getCitiesByProvince(1);  
        require_once(VIEWS_PATH."modify_cinema.php");
    }
    public function showCreditCard($cuantity)
    {
        session_start();
        $datosDeSession = $_SESSION["selectedProjection"];
        $precioTotal = $datosDeSession["room"]->getTicketPrice() * $quantity;
        $_SESSION["selectedProjection"] += ["quantity" => $quantity];
        $this->actualUser = $this->userDao->getById($_SESSION["id"]);
        include_once(VIEWS_PATH."tarjeta_form.php");
    }
    public function procesarCompra()
    {
            session_start();
            $datosDeSession = $_SESSION["selectedProjection"];
            $buyedTickets = $this->projController->sellTickets($datosDeSession["quantity"],$datosDeSession["projection"]->getId());
            $precioTotal = $datosDeSession["room"]->getTicketPrice() * $datosDeSession["quantity"];
            $compra = new Compra("",$_SESSION["id"]->getId(),$buyedTickets,$datosDeSession["tarjeta"],$precioTotal);
            $this->mailableFunction($compra);
            
        
    }

    public function mailableFunction($compra)
    {
       

        $message = $this->setMessage($compra);
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'moviepass013@gmail.com';                     // SMTP username
            $mail->Password   = 'laboratorio4';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('moviepass013@gmail.com', 'MoviePass');
            $mail->addAddress($actualUser->getEmail(), '');     // Add a recipient
            $mail->addAddress($actualUser->getEmail());               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
        /*  $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com'); */

            // Attachments
           //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('https://www.qrcoder.co.uk/api/v3/?key=gC81EhO2FfnR3ou4bwDS7Udpx0eIHq56&text=ANDA+A+DORMIR+PIBE+%28%3F%29&type=png', 'new.jpg');     // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Usted a realizado correctamente una compra en Movie Pass';
            $mail->Body    = $message;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            
            echo '<br><br><br>Message has been sent';
            include_once(VIEW_PATH."home.php");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            include_once(VIEW_PATH."home.php");
}
    }
    private function setMessage($compra)
    {
        session_start();
        $message = "Se ha realizado la commpra con éxito <br>";
        $message = $message. "realizada por el usuario" . $_SESSION["name"] . "<br>";
        $message = $message. "En el cine" . $_SESSION["selectedProjection"]["cinema"]->getName() . "<br>";
        $message = $message. "En la sala" . $_SESSION["selectedProjection"]["room"]->getDescription() ."<br>";
        $message = $message. "De la película" . $_SESSION["selectedProjection"]["movie"]->getName()."<br>";
        $message = $message. "El día".$_SESSION["selectedProjection"]["projection"]->getDate(). "al horario de ".$_SESSION["selectedProjection"]["projection"]->getTime()."<br>";
        $message = $message. "Las siguientes entradas <br>";
        foreach($compra->getTickets() as $key => $value)
        {
            $qr = $value->getQR();
            $message = $message . "Número de entrada = " . $value->getNroEntrada() . "<br>";
             $message = $message . "<img src='$qr' alt=''>";
        }
        return $message;
    }
    public function creditCardFunction($email,$docType,$docNumber,$paymentMethodId,$transactionAmount,$description,$token)
    {
        $this->datosTarjetaDao->add($docType,$docNumber,$transactionAmount,$token,$paymentMethodId);
        $this->procesarCompra();
        
       /*  require_once 'vendor/autoload.php';
        MercadoPago\SDK::setAccessToken("TEST-4179188020977247-111219-929220aea58ad8136f09dbaa455b9e82-199607676");

        $payment = new MercadoPago\Entities\Shared\Payment();
        $payment->transaction_amount = (float)$transactionAmount;
        $payment->token = $token;
        $payment->description = $description;
        $payment->installments = (int)$installments=1;
        $payment->payment_method_id = $paymentMethodId;
        $payment->issuer_id = (int)$issuer=1;

        $payer = new MercadoPago\Entities\Shared\Payer();
        $payer->email = $email;
        $payer->identification = array( 
            "type" => $docType,
            "number" => $docNumber
        );
        $payment->payer = $payer;

        $payment->save();

        $response = array(
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id
        );
        echo json_encode($response); */



    }

}
?>

