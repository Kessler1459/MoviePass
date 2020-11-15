<?php

    namespace Controllers;

    use DAO\ProjectionDAO;
    use Controllers\RoomController;
    use Controllers\MovieController;
    use Controllers\GenreController;
    use DateTime;
    use Models\Projection;
    use controllers\CinemaController;
    use Controllers\LocationController;
    use DAO\TicketDAO;

    class ProjectionController
    {
        private $projDao;
        private $movieContr;
        private $cinemaContr;
        private $locationContr;
        private $ticketDao;

        public function __construct()
        {
            $this->projDao = new ProjectionDAO();
            $this->movieContr = new MovieController();
            $this->cinemaContr = new CinemaController();
            $this->locationContr = new LocationController();
            $this->ticketDao = new TicketDAO();
        }

    /**
     * este es cartelera jeje
     */
    public function showProjectionsList(){
        $locContro=new LocationController();
        $gencontr=new GenreController();
        try{
            $projectionList=$this->projDao->getAllProjections();
            $genres=$gencontr->getAll();
            $provinces=$locContro->getAllProvinces();
            $initCities=$locContro->getCitiesByProvince(1);
            include(VIEWS_PATH."movies_list.php");
        }
        catch(Exception $e){
            $message="Projections are not currently available.";
            include(VIEWS_PATH."message_view.php");
        }
    }

    public function projectionFilters($cityId,$date,$genresJsonArray){
        $params["id_city"]=$cityId;
        $params["proj_date"]=$date;
        $projectionList=array();
        try{
            $projectionList=$this->projDao->projectionFilters($params);
            $projectionList=$this->filterByGenre(json_decode($genresJsonArray),$projectionList);
        }
        catch(Exception $e){
            $message="Error applying filters.";//TODO
        }
        finally{
            echo json_encode($projectionList,1);
        }
    }

    public function showProjectionSearch($search){
        $projectionList=$this->searchByName($search);
        echo json_encode($projectionList,1);
    }

    /*---------------------------------*/

   
    public function showProjections($roomId){
        $projs=$this->getArrayByRoomId($roomId);
        include(VIEWS_PATH."projection_admin.php");
    }

    public function add($roomId,$movieId,$date,$time)
    {
        try{
            $this->projDao->add($roomId,$movieId,$date,$time);
        }
        catch(Exception $e){
            $message="Error adding the projection.";
        }
        finally{
            $this->showProjections($roomId);
        }
    }
        public function showProjectionFromMovie($movieId)
        {
            $movie = $this->movieContr->getById($movieId);
            $cinemas=$this->cinemaContr->getAll();
            $cinemas = $this->divideByMovie($movie);
            $cinemas = $this->divideByCity($cinemas);
            include(VIEWS_PATH."select_city.php");   
        }
        public function showProjectionByCity($cityId,$movieId,$date)
        {
            if($date == "")
            {
                $date = date('Y-m-d');
            }
            $movie = $this->movieContr->getById($movieId);
            $cinemas=$this->cinemaContr->getAll();
            $cinemas = $this->divideByMovie($movie);
            $cinemas = $this->divideByCity($cinemas);
            $cinemasXrooms = $this->divideRoomByCinema($cinemas, $movie, $date);
            include(VIEWS_PATH."select_projection.php");
        }
        /*---------------------------------*/

    

    public function addFromList($roomId){
        try{
            $movieList=$this->movieContr->getAll();
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
        }
        catch(Exception $e){
            $message="No movies could be found.";
            include(VIEWS_PATH."message_view.php");
        }
        include(VIEWS_PATH."add_projection.php");
    }

    public function addFromListFiltered($genresJsonArray){
        $movies=$this->movieContr->getAll();    
        $movies=$this->movieContr->filterByGenre(json_decode($genresJsonArray),$movies);
        echo json_encode($movies,1);
    }

    public function addFromListSearch($search){
        try{
            $movieList=$this->movieContr->searchByName($search);
        }
        catch(Exception $e){
            $message="No movies could be found.";
            include(VIEWS_PATH."message_view.php");
        }
        echo json_encode($movieList,1);
    }

    public function updateMoviesList($roomId){
        $this->movieContr->updateNowPlaying();
        $this->addFromList($roomId);
    }

    /**
     * retorna todas las peliculas que tengan una funcion activa en el futuro sin repetirse.(cartelera hehe)
     */
    public function getAllProjections()
    {
        try{
            return $this->projDao->getAllProjections();
        }
        catch(Exception $e){
            return array();
        }
    }

    public function getById($id)
    {
        try{
            return $this->projDao->getById($id);
        }
        catch(Exception $e){
            $message="Error getting the projection.";
            include(VIEWS_PATH."message_view.php");
        }
    }


    /**
     * busca y devuelve array de proyecciones
     */
    public function searchByName($name){
        $projections=$this->getAllProjections();
        $arrayFinded = array();
        foreach ($projections as $value) {
            $movie=$value->getMovie();
            if (stripos($movie->getTitle(),$name)!==false)
            {
                array_push($arrayFinded,$value);
            }
        }
        return $arrayFinded; 
    }

    /**
     * todo
     * filtro de generos para cartelera 
     */
    public function filterByGenre($genresArray,$projectionList)
    {
        $newArray = array();
        foreach ($projectionList as $proj) {
            $jaja = 0;
            $movie=$proj->getMovie();
            $genresMovie = $movie->getGenres();
            foreach ($genresMovie as $genM) {
                foreach ($genresArray as $strGen) {
                    if ($strGen == $genM->getName()) {
                        $jaja++;
                    }
                }
            }
            if ($jaja == count($genresArray)) {
                $newArray[] = $proj;
            }
        }
        return $newArray;
    }

    /**
     * devuelve todo el array de funciones futuras de una sala
     */
    public function getArrayByRoomId($id)
    {
        try{
            return $this->projDao->getArrayByRoomId($id);
        }
        catch(Exception $e){
            return array();
        }
    }

    public function remove($id,$roomId)
    {
        try{
            $this->projDao->remove($id);
        }
        catch(Exception $e){
            $message="Error removing the projection.";
        }
        finally{
            $this->showProjections($roomId);
        }
    }

    public function getByDateRoom($date,$roomId){
        try{
            return $this->projDao->getByDateRoom($date,$roomId);
        }
        catch(Exception $e){
            $message="Error searching projection.";
            include(VIEWS_PATH."message_view.php");
        }
    }
        private function divideByCity($cinemas)
        {
            $cinesxciudad = array();
            foreach ($cinemas as $key => $value) {
                    if(!in_array($value->getCity()))
                    {
                        $cinesxciudad += [$value->getCity => array($value)];
                    }
                    else
                    {
                        array_push($cinesxciudad[$value->getCity()]);
                    }
            }
            return $cinesxciudad;
        }
        private function divideByMovie($movie)
        {
            $cinesXmovie = array();
            $flag = false;
            foreach($cinemas as $key => $cine)
            {
                $flag = false;
                foreach($cine->getRooms() as $key => $room)
                {
                    foreach($room->getProjections() as $key => $projection)
                    {
                        if(!$flag == false && $projection->getMovie() == $movie)
                        {
                            $flag = true;
                            array_push($cinesXmovie,$cine);
                            break;
                        }
                    }
                    if ($flag)
                    {
                    break;
                    }
                }
            }
        }
        private function divideRoomByCinema($cinemas, $movie, $date)
        {
            $roomsXcinema += [$cinemas => array()];
            $projections;
            $rooms;          
            $flag = false;
            $roomsXcinema = array();
            foreach ($cinemas as $key => $cinema) {
                foreach ($rooms as $key => $room) {
                    $projections = $room->getProjections();
                    foreach($projections as $key => $projection)
                    {
                        if(($projection->getMovie()->getId() == $movie->getId()) && ($projection->getDate() == $date))
                        {
                            if(!in_array(($cinema),$roomsXcinema))
                            {
                                $roomsXcinema += [$cinema => array($room => array($projection))];
                            }
                            else {
                                if (!in_array(($room),$roomsXcinema[$cinema]))
                                {
                                    $roomsXcinema[$cinema] += [$room => $projection];
                                }
                                else
                                {
                                    array_push($roomsXcinema[$cinema][$room],$projection);
                                }
                            }
                            
                        }
                    }
                }
            }
            return $roomsXcinema;
        }
    

    /**
     * devuelve todo el array de funciones futuras de una sala
     */

    /**
     * valida si se respetan los 15min antes de cada funcion y no existe otra funcion de la pelicula en otro sala u cine el mismo dia
     */
    public function validateProjection($roomId,$movieId,$date,$time){
        if($this->projDao->existByDate($date,$movieId,$roomId)==0){         //si la pelicula no esta registrada en una funcion en ninguna otra sala de ningun otro cine el mismo dia
            $newMovie=$this->movieContr->getById($movieId);
            $projList=$this->getByDateRoom($date,$roomId);
            $initTime=new DateTime($date." ".$time);         //hora de inicio de funcion a crear
            $endTime=new DateTime($date." ".$time); 
            $endTime=$endTime->modify("+".$newMovie->getLength()." minutes");  //hora de finalizacion
            foreach ($projList as $value) {
                $datetime=$value->getDate()." ".$value->getHour();
                $initTime2=new DateTime($datetime);  
                $endTime2=new DateTime($datetime);               //hora de inicio de las funciones existentes
                $endTime2=$initTime2->modify("+".$value->getMovie()->getLength()." minutes");       //hora de fin
                if(($initTime<=$endTime2->modify("+15 minutes")) && ($endTime>=$initTime2->modify("-15 minutes"))){
                    $msg["msg"]="This time is not available";
                } 
            }
            if (!isset($msg["msg"])) {
                $msg["msg"]="Ok"; //si se puede insertar la nueva
            }
        }
        else {
            $msg["msg"]="This movie is already in another room or cinema";
        }
        echo json_encode($msg,1);
    }

    public function addDetailsMovie($cinemaId,$movieId,$roomId,$projectionId)
    {
        session_start();
        $cinema_actual = $this->cinemaContr->getCinemaById($cinemaId);
        $movie_actual = $this->cinemaContr->getById($movieId);
        $room_actual = $this->roomContr->getById($roomId);
        $projection_actual = $this->projDao->getById($projectionId);
        $_SESSION["selectedProjection"]=["cinema" => $cinema_actual,"movie"=> $movie_actual,"room" => $room_actual,"projection" => $projection_actual];
        include_once(VIEW_PATH."ticket_buys.php");
    }
    private function ticketProduction($room, $idProyection)
    {
        $capacity = $room->getCapacity();
        $ticketsToBuy = array();
        $movie = $this->projDao->getById($idProyection)->getMovie()->getName();
        $ticketPrice = $room->getTicketPrice();
        for ($i = 0; $i < $capacity ;$i++)
        {
            array_push($ticketsToBuy,new Ticket("",$i++,$idProyection,$this->qrFunction("Numero de ticket = $i++\nPelícula= $movie\nPrecio = $ $ticketPrice")));
        } 
        foreach($ticketsToBuy as $key => $value)
        {
            $this->ticketDao->add($value);
        }
        return $ticketsToBuy;
    }
    private function sellTickets($cuantity,$proj_id)
    {
        $projActual = $this->projDao->getById($proj_id);
        $tickets = $projActual->getTickets();
        $buyedTickets = array();
        for($i = 0 ; $i < $cuantity; $i++)
        {
            array_push($buyedTickets,array_pop($tickets));
        }
        $projActual->setTickets($tickets);
        $this->projDao->update($projActual);
        $this->ticketDao->sellTickets($buyedTickets);
        return $buyedTickets;
        
    }
        public function qrFunction($message)
    {
        $key = "gC81EhO2FfnR3ou4bwDS7Udpx0eIHq56";  
        $url_to_return_qrcode = "https://www.qrcoder.co.uk/api/v3/?key=" . $key . "&text=" . urlencode($message);
        return $url_to_return_qrcode;
    }
}
