<?php 

/** 
 * TweetFind
 * 
 * @package  TweetFind
 * @author   Eric Mugerwa <eric.mugerwa@outlook.com>
 */ 

use TweetFind\TweetFind;

/**
 * @group TweetFind
 */ 
class TweetFindTest
extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $tweetfind = new TweetFind();
    }

    public function testStartRestService()
    {
        $tweetfind = new TweetFind();
        $result = $tweetfind->startRestService();
    }
}