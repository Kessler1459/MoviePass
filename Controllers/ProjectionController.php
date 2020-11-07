<?php

    namespace Controllers;

    use DAO\ProjectionDAO;
    use Controllers\MovieController;
    use Controllers\GenreController;
    use Models\Projection;
    use controllers\CinemaController;
    use Controllers\LocationController;

    class ProjectionController
    {
        private $projDao;
        private $movieContr;
        private $cinemaContr;
        private $locationContr;

        public function __construct()
        {
            $this->projDao = new ProjectionDAO();
            $this->movieContr = new MovieController();
            $this->cinemaContr = new CinemaController();
            $this->locationContr = new LocationController();
        }

        /**
         * este es cartelera jeje
         */
        public function showProjectionsList(){
            $movieList=$this->projDao->getAllMovies();
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include(VIEWS_PATH."movies_list.php");
        }

        public function showProjectionsByGenre($genresArray){
            $movieList=$this->projDao->getByGenre($genresArray);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include(VIEWS_PATH."movies_list.php");
        }

        public function showProjectionSearch($search){
            $movieList=$this->projDao->searchByName($search);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include(VIEWS_PATH."movies_list.php");
        }

        public function showProjectionDate($date){
            $movieList=$this->projDao->getAllMoviesByDate($date);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include(VIEWS_PATH."movies_list.php");
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

        public function showProjections($roomId){
            $projs=$this->projDao->getArrayByRoomId($roomId);
            
            include(VIEWS_PATH."projection_admin.php");
        }

        public function add($roomId,$movieId,$date,$time)
        {
            $movie=$this->movieContr->getById($movieId);
            $proj=new Projection(time(),$movie,$date,$time);
            $this->projDao->add($proj,$roomId);
            $this->showProjections($roomId);
        }

        public function addFromList($roomId){
            $movieList=$this->movieContr->getAll();
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include(VIEWS_PATH."add_projection.php");
        }

        public function addFromListByGenre($genresArray,$roomId){
            $movieList=$this->movieContr->getByGenre($genresArray);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include(VIEWS_PATH."add_projection.php");
        }

        public function addFromListSearch($search,$roomId){
            $movieList=$this->movieContr->searchByName($search);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include(VIEWS_PATH."add_projection.php");
        }

        public function updateMoviesList($roomId){
            $this->movieContr->updateNowPlaying();
            $this->addFromList($roomId);
        }

        /**
         * retorna todas las peliculas que tengan una funcion activa en el futuro sin repetirse.(cartelera hehe)
         */
        public function getAllMovies()
        {
            return $this->projDao->getAllMovies();
        }

        public function getById($id)
        {
            return $this->projDao->getById($id);
        }


        public function searchByName($name){
            $movies=$this->getAllMovies();
            $arrayFinded = array();
            foreach ($movies as $value) {
                if (stripos($value->getTitle(),$name)!==false)
                {
                    array_push($arrayFinded,$value);
                }
            }
            return $arrayFinded; 
        }

        /**
         * devuelve todo el array de funciones futuras de una sala
         */
        public function getArrayByRoomId($id)
        {
            return $this->projDao->getArrayByRoomId($id);
        }

        public function remove($id,$roomId)
        {
            if ($this->projDao->remove($id)>0) {
                $this->showProjections($roomId);
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
    }

?>