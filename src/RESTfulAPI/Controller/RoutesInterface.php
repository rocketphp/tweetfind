<?php namespace TweetFind\RESTfulAPI\Controller;
/** 
 * Routes Interface
 *
 */
interface RoutesInterface
{ 
    public function get();
    public function post();
    public function getLoad();
    public function getTweets();
    public function getSearch($text = null, $location = null);
}