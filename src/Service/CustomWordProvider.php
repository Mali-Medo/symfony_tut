<?php


namespace App\Service;


use App\MessageHelperBundle\MessageHelperWordProvider;

class CustomWordProvider extends MessageHelperWordProvider
{
    public function getWordList(): array
    {
        $words = parent::getWordList(); // TODO: Change the autogenerated stub
        $words[] = 'beach';

        return $words;
    }

}