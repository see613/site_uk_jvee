<?php

Yii::import('ext.twitteroauth.*');


class TwitterService extends CApplicationComponent {
    public $cacheAddress = './uploads/cache/last_tweets.txt';
    public $maxCache = 1;


    public function getLastTweets() {
        $error = false;
        $result = array();

        try {
            $connection = new TwitterOAuth(
                'W2gC3eQ3rvL2BpNAysZlWfUMz',
                'aCbYOK5hi0GpPZ5a5OMFLdIasLac0D2uS8iTfzIZdae2O7w3oP',
                '396023249-gTFRZhf7zZLBx092ZY2TWq8y0U4yRsP3XVJ1uf7A',
                'jsCHtSZqc4SVMiBvyiWW8m4lt26Dm43JVWlrJJeG2M95v'
            );
            $tweets = $connection->get("statuses/user_timeline", array('screen_name' => '', "count" => 10, 'include_rts' => 'false', "exclude_replies" => true));
        }
        catch (Exception $e) {
            $error = true;
        }

        // if error we take content from the cache
        if ($error || $connection->getLastHttpCode() != 200) {
            $data = @file_get_contents($this->cacheAddress);

            if ( !empty($data) ) {
                $result = explode("\n", $data);
                array_pop( $result );
            }
        }
        // if everything is ok we take content and put it into the cache
        else if( !empty($tweets) ) {
            $data = '';
            $i = 0;

            foreach ($tweets as $tweet) {
                if ($i >= $this->maxCache) {
                    break;
                }

                /*if (UrlHelper::stringHasUrl($tweet->text)) {
                    continue;
                }*/

                $tweetContent = $this->replaceLinks($tweet);

                $data .= $tweetContent."\n";
                $result[] = $tweetContent;
                $i++;
            }

            @mkdir('./uploads/cache', 0777, TRUE);
            file_put_contents($this->cacheAddress, $data);
        }

        return $result;
    }

    protected function replaceLinks($tweet) {
        $text = $tweet->text;

        // hastags
        if (true === array_key_exists('hashtags', $tweet->entities)) {
            $linkified = array();
            foreach ($tweet->entities->hashtags as $hashtag) {
                $hash = $hashtag->text;
                if (in_array($hash, $linkified)) {
                    continue; // do not process same hash twice or more
                }
                $linkified[] = $hash;
                // replace single words only, so looking for #Google we wont linkify >#Google<Reader
                $text = preg_replace('/#\b' . $hash . '\b/', sprintf('<a href="https://twitter.com/search?q=%%23%2$s&src=hash" target="_blank">#%1$s</a>', $hash, urlencode($hash)), $text);
            }
        }

        // user mentions
        if (true === array_key_exists('user_mentions', $tweet->entities)) {
            $linkified = array();
            foreach ($tweet->entities->user_mentions as $userMention) {
                $name = $userMention->name;
                $screenName = $userMention->screen_name;
                if (in_array($screenName, $linkified)) {
                    continue; // do not process same user mention twice or more
                }
                $linkified[] = $screenName;
                // replace single words only, so looking for @John we wont linkify >@John<Snow
                $text = preg_replace('/@\b' . $screenName . '\b/', sprintf('<a href="https://www.twitter.com/%1$s" title="%2$s" target="_blank">@%1$s</a>', $screenName, $name), $text);
            }
        }

        // urls
        if (true === array_key_exists('urls', $tweet->entities)) {
            $linkified = array();
            foreach ($tweet->entities->urls as $url) {
                $expandedUrl = $url->expanded_url;
                $url = $url->url;
                if (in_array($url, $linkified)) {
                    continue; // do not process same url twice or more
                }
                $linkified[] = $url;
                $text = str_replace($url, sprintf('<a href="%1$s" title="%2$s" target="_blank">%1$s</a>', $url, $expandedUrl), $text);
            }
        }

        // media
        if (true === array_key_exists('media', $tweet->entities)) {
            $linkified = array();
            foreach ($tweet->entities->media as $media) {
                $mediaUrl = $media->media_url;
                $media = $media->url;
                if (in_array($media, $linkified)) {
                    continue; // do not process same url twice or more
                }
                $linkified[] = $media;
                $text = str_replace($media, sprintf('<a href="%1$s" title="%2$s" target="_blank">%1$s</a>', $media, $mediaUrl), $text);
            }
        }

        return $text;
    }



}

