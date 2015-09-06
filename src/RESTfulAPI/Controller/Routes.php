<?php

namespace TweetFind\RESTfulAPI\Controller; 

use TweetFind\TweetFind;

/** 
 * Routes
 *
 */ 
class Routes
implements RoutesInterface
{
    /**
     * TweetFind
     * @access protected
     * @var    TweetFind
     */
    protected $_tweetfind;

    /**
     * Nest
     * @access protected
     * @var    string
     */
    protected $_nest;

    /**
     * Get Root
     * 
     * @return string
     */
    public function __construct()
    {
        $this->_tweetfind = new TweetFind();
        $this->_nest = $this->_tweetfind->nest;
    }

    /**
     * Get Root
     * 
     * @return string
     */
    public function get()
    {
        return "";
    }

    /**
     * Post Root
     *
     * @return string
     */
    public function post()
    {
        return "";
    }

    /**
     * Get Load
     *
     * @url    load
     * @return string
     */
    public function getLoad()
    {
        $result = $this->_nest->load();
        $response = [
            'loaded' => $result
            ];
        return $response;
    }

    /**
     * Get Clear
     *
     * @url    clear
     * @return string
     */
    public function getClear()
    {
        $result = $this->_nest->clear();
        $response = [
            'cleared' => $result
            ];
        return $response;
    }

    /**
     * Get Extract
     *
     * @url    extract
     * @return string
     */
    public function getExtract()
    {
        $result = $this->_tweetfind->extract();
        $response = [
            'extracted' => $result
            ];
        return $response;
    }

    /**
     * Get Tweets
     *
     * @url    tweets
     * @return string
     */
    public function getTweets()
    {
        $result = $this->_nest->tweets();
        $response = [
            'count' => count($result),
            'tweets' => $result
            ];
        return $response;
    }

    /**
     * Get Search
     *
     * @url    search
     * @param  string $text     Text
     * @param  string $location Location
     * @return string
     */
    public function getSearch($text = null, $location = null)
    {
        if ($text || $location) {
            $result = $this->_nest->search(
                ['text' => $text,
                'location' => $location]
            );
            $response = [
                'count' => count($result),
                'tweets' => $result
                ];
            return $response;
        } else {
            $response = [
                'error' => 'unknown request'
                ]; 
            return $response;
        }
    }
}