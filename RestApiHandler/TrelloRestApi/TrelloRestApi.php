<?php

namespace MesClics\UtilsBundle\RestApiHandler\TrelloRestApi;

use MesClics\UtilsBundle\RestApi\RestApi;
use MesClics\UtilsBundle\RestApiHandler\RestApiRequest;

class TrelloRestApi extends RestApi{

    public function getBoardsRequest(){
        $request = new RestApiRequest();
        $request->setPathEndpoint("boards");

    }
}
