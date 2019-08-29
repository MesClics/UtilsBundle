<?php

namespace MesClics\UtilsBundle\ApisManager\RestApis\TrelloApi;

use Unirest\Request as UnirestRequest;
use Symfony\Component\HttpFoundation\Session\Session;
use MesClics\UtilsBundle\ApisManager\RestApis\RestApi;

class TrelloApi extends RestApi{
    public $boards_ids;

    const REQUEST_HEADERS = array('Accept' => 'application/json');

    public function __construct(Array $options, Session $session){
        parent::__construct($options, $session);

        if($options['boards_ids']){
            foreach($options['boards_ids'] as $board => $id){
               $this->boards_ids[$board] = $id;
            }
        }
    }

    protected function areAllFieldsAvailable($objectToCheck, $options){
        foreach($options['fields'] as $field_name => $field_value){
            if(!property_exists($objectToCheck, $field_name)){
                return false;
            }
        }
        return true;
    }

    public function getBoards(Array $options = null){            
        $endpoint = $this->getEndpoint().'member/me/boards';
        return self::sendUnirestRequest("get", $endpoint, $options);
    }

    public function getBoard($id, Array $options = null){            
        $endpoint = $this->getEndpoint() . 'boards/' . $id;
        return self::sendUnirestRequest("get", $endpoint, $options);
    }

    public function getBoardByName($name, Array $options = null){
        $boards = $this->getBoards($options);

        foreach($boards as $board){
            if($board->name === $name){
                return $board;
            }
        }

        return false;
    }

    public function getList($id, Array $options = null){        
        $endpoint = $this->getEndpoint() . 'lists/' . $id;
        return self::sendUnirestRequest("get", $endpoint, $options);
    }

    public function addList($board_id, Array $datas){
        $endpoint = $this->getEndpoint().'boards/'.$board_id.'/lists';
        return self::sendUnirestRequest("post", $endpoint, $datas);
    }

    public function getCardsWithinList($list_id){
        $endpoint = $this->getEndpoint() . 'lists/' . $list_id . '/cards';
        return self::sendUnirestRequest("get", $endpoint);
    }

    public function getCard($id, Array $options = null){
        $endpoint = $this->getEndpoint(). 'cards/' . $id;
        return self::sendUnirestRequest("get", $endpoint, $options);
    }

    public function addCard(Array $datas){
        $endpoint = $this->getEndpoint().'cards';
        return self::sendUnirestRequest("post", $endpoint, $datas);
    }

    public function addAttachmentToCard(string $card_id, Array $datas){
        $endpoint = $this->getEndpoint().'cards/'.$card_id.'/attachments';
        return self::sendUnirestRequest("post", $endpoint, $datas);
    }

    public function addChecklist(Array $datas){
        $endpoint = $this->getEndpoint().'checklists';
        return self::sendUnirestRequest("post", $endpoint, $datas);
    }

    public function addItemToChecklist(string $checklist_id, Array $datas){
        $endpoint = $this->getEndpoint().'checklists/'.$checklist_id.'/checkItems';
        return self::sendUnirestREquest("post", $endpoint, $datas);
    }
}
