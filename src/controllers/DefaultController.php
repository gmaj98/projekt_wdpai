<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/CityRepository.php';

class DefaultController extends AppController {

    public function dashboard()
    {
        $cityRepository = new CityRepository();
        $cities = $cityRepository->getCities();

        // TODO 
        
        $this->render('dashboard', ['cities' => $cities]);
    }
}