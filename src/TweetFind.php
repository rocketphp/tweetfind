<?php
/** 
 * TweetFind
 * 
 * @package  TweetFind
 * @author   Eric Mugerwa <eric.mugerwa@outlook.com>
 */ 

namespace TweetFind;

use RocketPHP\TweetNest\TweetNest;
use RocketPHP\Template\Template;
use RestService\Server as RESTServer;
use ZipArchive;
use RuntimeException;

/** 
 * TweetFind
 *
 * Web application
 */ 
class TweetFind
implements TweetFindInterface
{
    /** 
     * Environment
     * @var string
     */
    public $env;

    /** 
     * TweetNest
     * @var TweetNest
     */
    public $nest;

    /** 
     * Config
     * @access protected
     * @var    array
     */
    protected $_config;

    /** 
     * Rest Service
     * @access protected
     * @var    obj
     */
    protected $_restService;

    /** 
     * Zip filepath
     * @access protected
     * @var    string
     */
    protected $_zip;

    /** 
     * Tweet files directory
     * @access protected
     * @var    string
     */
    protected $_dir;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {  
        $this->env = getenv('APPLICATION_ENV');

        $this->_config = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 
                        'app' . DIRECTORY_SEPARATOR . 
                        'config' . DIRECTORY_SEPARATOR . 
                        'config.php';

        $this->_zip = $this->_config['tweet_zip'];  
        $this->_dir = dirname($this->_zip) . 
                        DIRECTORY_SEPARATOR . 'tweet_files';
        if(!is_dir($this->_dir))
            $this->extract();
        $this->nest = new TweetNest(
            $this->_config['elasticsearch_host'], 
            $this->_dir
        );
    } 

    /**
     * Return HTML view
     *
     * Few static pages - no need for heavy MVC framework
     *
     * @param  string $name View name
     * @return string
     * @throws InvaidArgumentException If key is not a string
     * @throws RuntimeException        If key not in config
     */
    public function view($name)
    {  
        if(!is_string($name) || $name === "")
            throw new InvaidArgumentException(
                "Expected string for name.",
                1
            );

        $d = $this->_config['tpl_dir'];
        $filename = $d . 'views' . DIRECTORY_SEPARATOR . $name . '.tpl';
        if (is_file($filename)) {
            // index
            if ($name === 'index') {
                // head
                $head = new Template($d . 'layouts/head.tpl'); 
                // view
                $view = new Template($d . 'views/index.tpl');
                $view->set('head', $head->output());
                $view->set('app_name', $this->_config['app_name']);
                // picture
                $picture = new Template($d . 'includes/picture.tpl'); 
                $view->set('picture', $picture->output());
                // searchform
                $searchform = new Template($d . 'includes/searchform.tpl'); 
                $view->set('searchform', $searchform->output());
                // searchresults
                $searchresults = new Template(
                    $d . 'includes/searchresults.tpl'
                ); 
                $view->set('searchresults', $searchresults->output());
                // footer
                $footer = new Template($d . 'layouts/footer.tpl');
                $footer->set('github_link', $this->_config['github_link']); 
                $view->set('footer', $footer->output());
                // return Template::merge([$head, $view, $footer]);
                $output = $view->output();
                return $view->output();
            }
        } else {
            throw new RuntimeException(
                "File does not exist: $filename.", 
                1
            );  
        }
    }

    /**
     * Start REST service
     *
     * @return bool
     */
    public function startRestService()
    {  
        if (!$this->_restService) {
            $this->_restService = RESTServer::create(
                '/api', 
                'TweetFind\RESTfulAPI\Controller\Routes'
            )->collectRoutes();
            $this->_restService->run();    
            return true;    
        } else {
            return false;
        }
    }

    /**
     * Extract tweet zip file
     *
     * @return bool
     */
    public function extract()
    { 
        $zip = new ZipArchive;
        if ($zip->open($this->_zip) === TRUE) {
            $zip->extractTo($this->_dir);
            $zip->close(); 
        } else {
            throw new RuntimeException(
                "Error unzipping: " . $this->_zip, 
                1
            );
        }
        return true;
    }
}