<?php


namespace App\MessageHelperBundle;


use App\MessageHelperBundle\DependencyInjection\MessageHelperExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MessageHelperBundle extends Bundle
{
    // ne dela s ovim sranjem jer oce string a vraca se objekt
//    protected function getContainerExtensionClass()
//    {
//        $a = parent::getContainerExtensionClass();
//        dd($a);
//        if(null === $this->extension){
//            $this->extension = new MessageHelperExtension();
//        }
//
//        return $this->extension;
//    }


}