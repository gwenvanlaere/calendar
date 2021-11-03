<?php
//Exceptions/ExceptionsHandler.php

declare(strict_types = 1);

namespace App\Exceptions;
use \Exception;

class ExceptionsHandler {
    private Exception $exception;
    private string $exceptionName;
    
    public static $messages = array(
        'Exception' => 'Er ging iets mis... Probeer het later opnieuw',
        'InvalidYearException' => 'Invalid year given',        
        'LanguageNotSupportedException' => 'Language not supported',        
        'CannotRemoveNoteException' => 'Could not remove this note',        
        'UnknownException' => 'Er is een onbekende fout opgetreden!',
    );
    
    public function __construct(Exception $exception) 
    {
        $this->exception = $exception;
        $this->exceptionName = $this->setName();
    }
    private function setName() : string 
    {
        $string = explode('\\', get_class($this->exception));
        return end($string);
    }
    public function getException() : Exception 
    {
        return $this->exception;
    }
    public function getName() : string 
    {        
        return $this->exceptionName;
    }    
}