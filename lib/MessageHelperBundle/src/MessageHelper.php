<?php


namespace App\MessageHelperBundle;



use phpDocumentor\Reflection\Types\Boolean;

class MessageHelper
{
    private $unicornsAreReal;
    private $minSunshine;

    public function __construct(bool $unicornsAreReal = true, int $minSunshine = 5)
    {
        $this->unicornsAreReal = $unicornsAreReal;
        $this->minSunshine = $minSunshine;
    }

    public function generateMessage(string $source): string
    {
        dd($this->unicornsAreReal, $source);
       return $source.' dela';
    }
}