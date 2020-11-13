<?php
namespace Controllers;

use Models\Compra;
use Models\Ticket;
use Models\DatosTarjeta;
use Controllers\ProjectionController;
use DAO\TicketDAO;
use DAO\CompraDAO;
use DAO\DatosTarjetaDAO;

class ComprasController{
    private $ticketDao;
    private $compraDao;
    private $datosTarjetaDao;
    private $projController;


    public function __construct() {
        $this->ticketDao = new TicketDAO();
        $this->compraDao = new CompraDAO();
        $this->datosTarjetaDao = new DatosTarjetaDAO();
        $this->projController = new ProjectionController();
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
    public function showCreditCard(/* $cuantity */)
    {
        $cuantity = 2;
        /* session_start();
        $datosDeSession = $_SESSION["selectedProjection"];
        $precioTotal = $datosDeSession["room"]->getTicketPrice() * $quantity;
        $_SESSION["selectedProjection"] += ["quantity" => $quantity]; */
        include_once(VIEWS_PATH."tarjeta_form.php");
    }
    public function showAceptBuy($dataTarjeta)
    {
        session_start();
        $datosDeSession = $_SESSION["selectedProjection"];
        $datosDeSession += ["tarjeta" => $dataTarjeta];
        include_once(VIEWS_PATH."aceptar_compra.php");
    }
    public function procesarCompra($compraAceptada)
    {
        if($compraAceptada)
        {
            session_start();
            $datosDeSession = $_SESSION["selectedProjection"];
            $buyedTickets = $this->projController->sellTickets($datosDeSession["quantity"],$datosDeSession["projection"]->getId());
            $precioTotal = $datosDeSession["room"]->getTicketPrice() * $datosDeSession["quantity"];
            $compra = new Compra("",$_SESSION["loggedUser"]->getId(),$buyedTickets,$datosDeSession["tarjeta"],$precioTotal);
            $this->mailableFunction();
            
        }
    }
    public function qrFunction()
    {

    }
    public function mailableFunction()
    {

    }
    public function creditCardFunction($dataIncoming)
    {
        require_once 'vendor/autoload.php';
        MercadoPago\SDK::setAccessToken("TEST-4179188020977247-111219-929220aea58ad8136f09dbaa455b9e82-199607676");

        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = (float)$dataIncoming['transactionAmount'];
        $payment->token = $dataIncoming['token'];
        $payment->description = $dataIncoming['description'];
        $payment->installments = (int)$dataIncoming['installments'];
        $payment->payment_method_id = $dataIncoming['paymentMethodId'];
        $payment->issuer_id = (int)$dataIncoming['issuer'];

        $payer = new MercadoPago\Payer();
        $payer->email = "test_user_5216506@testuser.com";
        $payer->identification = array( 
            "type" => $dataIncoming['docType'],
            "number" => $dataIncomig['docNumber']
        );
        $payment->payer = $payer;

        $payment->save();

        $response = array(
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id
        );
        echo json_encode($response);



    }

}
?>

