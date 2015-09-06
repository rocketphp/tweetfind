<?php 
/** 
 * TweetFind
 * 
 * @package  TweetFind
 * @author   Eric Mugerwa <eric.mugerwa@outlook.com>
 */

namespace TweetFind;

/** 
 * Interface for TweetFind
 */
interface TweetFindInterface
{
    public function startRestService();
    public function extract();
}