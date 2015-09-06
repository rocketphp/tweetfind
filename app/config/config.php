<?php
return array(
    'app_name'            => 'TweetFind',
    'github_link'         => 'https://github.com/rocketphp/tweetfind',
    'tweet_zip'           => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'tweet_files.zip',
    'elasticsearch_host'  => 'localhost:9200',
    'elasticsearch_index' => 'tweetfind',
    'elasticsearch_type'  => 'tweet',
    'tpl_dir'             => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR
);