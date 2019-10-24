<?php

namespace MesClics\UtilsBundle\FormManager;

use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use MesClics\UtilsBundle\Notification\Notification;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class FormManager{
    private $em;
    private $request;
    private $session;
    private $form;
    private $action;
    private $result;
    private $result_count;
    private $success_notification;
    private $error_notification;
    private $success = null;
    private $error = null;
    
    const ERROR_NOTIFICATION_SINGULIER = "L'opération a échoué. Veuillez vérifier les données saisies.";
    const ERROR_NOTIFICATION_PLURIEL = "L'opération  a échoué. Veuillez vérifier les données saisies.";
    const SUCCESS_NOTIFICATION_SINGULIER = "L'opération  a réussi.";
    const SUCCESS_NOTIFICATION_PLURIEL = "L'opération  a réussi.";

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack, SessionInterface $session){
        $this->em = $em;
        $this->request = $requestStack->getCurrentRequest();
        $this->session = $session;
        $this->result_count = 0;
        $this->success_notification = new Notification("success");
        $this->error_notification = new Notification("error");
        $this->getSuccessNotification()
            ->setNotificationSingulier(static::SUCCESS_NOTIFICATION_SINGULIER)
            ->setNotificationPluriel(static::SUCCESS_NOTIFICATION_PLURIEL);

        $this->getErrorNotification()
            ->setNotificationSingulier(static::ERROR_NOTIFICATION_SINGULIER)
            ->setNotificationPluriel(static::ERROR_NOTIFICATION_PLURIEL);
    }

    public function setBeforeUpdate($clonedObject){
        $this->before_update = $clonedObject;

        return $this;
    }

    public function getBeforeUpdate(){
        return $this->before_update;
    }

    public function getAction(){
        return $this->action;
    }

    public function getEm(){
        return $this->em;
    }

    protected function getErrorNotification(){
        return $this->error_notification;
    }

    protected function getErrorNotificationCorrectGrammar(){
        if($this->getResult() > 1){
            return $this->getErrorNotification()->getNotificationPluriel();
        }
        return $this->getErrorNotification()->getNotificationSingulier();
    }
    
    public function getForm(){
        return $this->form;
    }

    public function getNotification(){
        if($this->hasSucceeded()){
            $this->getSuccessNotificationCorrectGrammar();
        } else{
            $this->getErrorNotificationCorrectGrammar();
        }
    }
 
    public function getNotificationLabel(){
       if($this->hasSucceeded()){
           return $this->getSuccessNotification()->getLabel();
       } else{
           return $this->getErrorNotification()->getLabel();
       }
    }

    public function getRequest(){
        return $this->request;
    }

    public function getResult(){
        return $this->result;
    }

    public function getResultCount(){
        return $this->result_count;
    }

    public function getSession(){
        return $this->session;
    }

    protected function getSuccessNotification(){
        return $this->success_notification;
    }

    protected function getSuccessNotificationCorrectGrammar(){
        if($this->getResultCount() > 1){
            return $this->getSuccessNotification()->getNotificationPluriel();
        }
        return $this->getSuccessNotification()->getNotificationSingulier();
    }

    public function hasSucceeded(){
        return $this->success;
    }
         
    protected function hydrate(array $donnees)
    {
        foreach ($donnees as $attribut => $valeur)
        {
            $methode = 'set'.ucfirst($attribut);
                
            if (is_callable(array($this, $methode)))
            {
                $this->$methode($valeur);
            }
        }
    }

    protected function setAction($action){
        $this->action = $action;
    }

    protected function setError($error){
        $this->error = $error;
    }

    protected function setErrorNotification(Notification $notification){
        $this->error_notification = $notification;
        return $this;
    }

    public function setForm(Form $form){
        $this->form = $form;
        return $this;
    }

    protected function setNotification(){
            $this->session->getFlashBag()->add($this->getNotificationLabel(), $this->getNotification());
    }

    public function setResult($result){
        $this->result = $result;
    }

    public function setResultCount(int $count){
        $this->resultCount = $count;
    }

    protected function setSuccess($success){
        $this->success = $success;
    }

    protected function setSuccessNotification(Notification $notification){
        $this->success_notification = $notification;
        return $this;
    }

    public function handle(Form $form, $addNotification = true){
        $this->hydrate(array(
            // 'request' => $request,
            'form' => $form
        ));
        //on fait le lien entre la requête et le formulaire, $object contient les valeurs entrées dans le formulaire
        $this->getForm()->handleRequest($this->getRequest());
        //on vérifie la validité des données saisies
        if($this->getForm()->isSubmitted() && $this->getForm()->isValid()){
            $this->setAction($this->getForm()->getClickedButton()->getName());
            $object = $this->getForm()->getData();

            //on persiste notre objet en bdd
            $this->getEm()->persist($object);
            $this->getEm()->flush();
            $this->setResult($object);
            $result_count = $this->getResultCount();
            $this->setResultCount($result_count++);
            $this->setSuccess(true);
        }
        if($addNotification){
            $this->setNotification();
        }
        return $this;
    }
}