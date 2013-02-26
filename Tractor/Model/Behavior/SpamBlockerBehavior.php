<?php
/**
 * Spam Blocker Behavior
 *
 * A CakePHP Behavior that moderates / validates comments to check for spam.
 * Validates based on a point system. High points is an automatic approval, where as low points is marked as spam or deleted.
 * Based on Jonathon Snooks outline.
 *
 * @author      Miles Johnson - www.milesj.me
 * @copyright   Copyright 2006-2010, Miles Johnson, Inc.
 * @license     http://www.opensource.org/licenses/mit-license.php - Licensed under The MIT License
 * @link        http://milesj.me/resources/script/spam-blocker-behavior
 * @link        http://snook.ca/archives/other/effective_blog_comment_spam_blocker/
 */

/**
CREATE TABLE `tests`.`comments` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `entry_id` INT NOT NULL,
    `status` ENUM('approved','pending','delete','spam') NOT NULL DEFAULT 'pending',
    `points` INT NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `website` VARCHAR(50) NOT NULL,
    `content` TEXT NOT NULL,
    `created` DATETIME NULL DEFAULT NULL,
    `modified` DATETIME NULL DEFAULT NULL,
    INDEX (`entry_id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
*/

class SpamBlockerBehavior extends ModelBehavior {

    /**
     * Current version: http://milesj.me/resources/logs/spam-blocker-behavior
     *
     * @access public
     * @var string
     */
    public $version = '1.6';

    /**
     * Settings initiliazed with the behavior.
     *
     * @access public
     * @var array
     */
    public $settings = array(
        'parent_model'      => 'Entry',     // Model name of the parent article/entry/etc
        'article_link'      => '',          // Link to the parent article, use :id for the permalink id
        'use_slug'          => false,       // To use a slug in the article link, use :slug
        'notify_email'      => 'willjbarker@gmail.com',          // Email address where the notify emails should go
        'save_points'       => true,        // Should the points be saved to the database?
        'send_email'        => true,        // Should you receive a notification email for each comment?
        'blacklist_keys'    => array ('viagra', 'sex', 'buy', 'seo', 'drugs', 'fuck', 'shit', 'bugger', 'cunt', 'dam') ,         // List of blacklisted words within text blocks
        'blacklist_chars'   => array('viagra'),          // List of blacklisted characters within URLs
        'deletion'          => -10000          // How many points till the comment is deleted (negative)
    );

    /**
     * Names for table columns within the comments table and the parent.
     *
     * @access public
     * @var array
     */
    public $columns = array(
        'author'        => 'username',      // Column for the authors name
        'content'       => 'content',   // Column for the comments body
        'email'         => 'email',     // Column for the authors email
        'website'       => 'website',   // Column for the authors website
        'foreign_id'    => 'entry_id',  // Column of the foreign id that links to the article/entry/etc
        'slug'          => 'slug',      // Column for the slug in the entries table
        'title'         => 'title',     // Column for article title in the entries table
        'status'        => 'status',    // Column for approval status
        'points'        => 'points'     // Column for point score
    );

    /**
     * Status codes for the enum (or integer) status column.
     *
     * @access public
     * @var array
     */
    public $statusCodes = array(
        'pending'   => 'pending',
        'approved'  => 'approved',
        'delete'    => 'denied',
        'spam'      => 'spam'
    );

    /**
     * Disallowed words within the comment body.
     *
     * @access public
     * @var array
     */
    public $blacklistKeywords = array(
        'levitra', 'viagra', 'casino', 'sex', 'loan', 'finance', 'slots', 'debt', 'free', 'stock', 'debt',
        'marketing', 'rates', 'ad', 'bankruptcy', 'homeowner', 'discreet', 'preapproved', 'unclaimed',
        'email', 'click', 'unsubscribe', 'buy', 'sell', 'sales', 'earn'
    );

    /**
     * Disallowed words/chars within the url links.
     *
     * @access public
     * @var array
     */
    public $blacklistCharacters = array('.html', '.info', '?', '&', '.de', '.pl', '.cn', '.ru', '.biz');

    /**
     * Startup hook from the model.
     *
     * @access public
     * @param object $Model
     * @param array $settings
     * @return void
     */
    public function setup(&$Model, $settings = array()) {
        if (!empty($settings) && is_array($settings)) {
            if (!empty($settings['settings'])) {
                $this->settings = $settings['settings'] + $this->settings;
            }

            if (!empty($settings['columns'])) {
                $this->columns = $settings['columns'] + $this->columns;
            }

            if (!empty($settings['statusCodes'])) {
                $this->statusCodes = $settings['statusCodes'] + $this->statusCodes;
            }
        }

        if (!empty($this->settings['blacklist_keys']) && is_array($this->settings['blacklist_keys'])) {
            $this->blacklistKeywords = $this->settings['blacklist_keys'] + $this->blacklistKeywords;
        }

        if (!empty($this->settings['blacklist_chars']) && is_array($this->settings['blacklist_chars'])) {
            $this->blacklistCharacters = $this->settings['blacklist_chars'] + $this->blacklistCharacters;
        }
    }

    /**
     * Runs before a save and marks the content as spam or regular comment.
     *
     * @access public
     * @param object $Model
     * @param boolean $created
     * @return mixed
     */
    public function afterSave(&$Model, $created) {
        if ($created) {
            $data = $Model->data[$Model->name];
            $points =  0;

            if (!empty($data)) {
                // Get links in the content
                $links = preg_match_all("#(^|[\n ])(?:(?:http|ftp|irc)s?:\/\/|www.)(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,4}(?:[-a-zA-Z0-9._\/&=+%?;\#]+)#is", $data[$this->columns['content']], $matches);
                $links = $matches[0];

                $totalLinks = count($links);
                $length = mb_strlen($data[$this->columns['content']]);

                // How many links are in the body
                // +2 if less than 2, -1 per link if over 2
                if ($totalLinks > 2) {
                    $points = $points - $totalLinks;
                } else {
                    $points = $points + 2;
                }

                // How long is the body
                // +2 if more then 20 chars and no links, -1 if less then 20
                if ($length >= 20 && $totalLinks <= 0) {
                    $points = $points + 2;
                } else if ($length >= 20 && $totalLinks == 1) {
                    ++$points;
                } else if ($length < 20) {
                    --$points;
                }

                // Number of previous comments from email
                // +1 per approved, -1 per spam
             
             	if(isset($data[$this->columns['email']])){
             		$comments = $Model->find('all', array(
                    'fields' => array('id', $this->columns['status']),
                    'conditions' => array($this->columns['email'] => $data[$this->columns['email']]),
                    'recursive' => -1,
                    'contain' => false
                	));
             	}
                

                if (!empty($comments)) {
                    foreach ($comments as $comment) {
                        if ($comment[$Model->alias][$this->columns['status']] == $this->statusCodes['spam']) {
                            --$points;
                        }

                        if ($comment[$Model->alias][$this->columns['status']] == $this->statusCodes['approved']) {
                            ++$points;
                        }
                    }
                }

                // Keyword search
                // -1 per blacklisted keyword
                foreach ($this->blacklistKeywords as $keyword) {
                    if (stripos($data[$this->columns['content']], $keyword) !== false) {
                        --$points;
                    }
                }

                // URLs that have certain words or characters in them
                // -1 per blacklisted word
                // URL length
                // -1 if more then 30 chars
                foreach ($links as $link) {
                    foreach ($this->blacklistCharacters as $word) {
                        if (stripos($link, $word) !== false) {
                            --$points;
                        }
                    }

                    foreach ($this->blacklistKeywords as $keyword) {
                        if (stripos($link, $keyword) !== false) {
                            --$points;
                        }
                    }

                    if (strlen($link) >= 30) {
                        --$points;
                    }
                }

                // Body starts with...
                // -10 points
                $firstWord = mb_substr($data[$this->columns['content']], 0, stripos($data[$this->columns['content']], ' '));
                $firstDisallow = array('interesting', 'cool', 'sorry') + $this->blacklistKeywords;

                if (in_array(mb_strtolower($firstWord), $firstDisallow)) {
                    $points = $points - 10;
                }

                // Author name has http:// in it
                // -2 points
                if (isset($data[$this->columns['author']])){
                	if (stripos($data[$this->columns['author']], 'http://') !== false) {
                    	$points = $points - 2;
                	}
                }
                

                // Body used in previous comment
                // -1 per exact comment
                $previousComments = $Model->find('count', array(
                    'conditions' => array($this->columns['content'] => $data[$this->columns['content']]),
                    'recursive' => -1,
                    'contain' => false
                ));

                if ($previousComments > 0) {
                    $points = $points - $previousComments;
                }

                // Random character match
                // -1 point per 5 consecutive consonants
                $consonants = preg_match_all('/[^aAeEiIoOuU\s]{5,}+/i', $data[$this->columns['content']], $matches);
                $totalConsonants = count($matches[0]);

                if ($totalConsonants > 0) {
                    $points = $points - $totalConsonants;
                }
            }

            // Finalize and save
            if ($points >= 1) {
                $status = $this->statusCodes['approved'];
            } else if ($points == 0) {
                $status = $this->statusCodes['pending'];
            } else if ($points <= $this->settings['deletion']) {
                $status = $this->statusCodes['delete'];
            } else {
                $status = $this->statusCodes['spam'];
            }

            if ($status == $this->statusCodes['delete']) {
                $Model->delete($Model->id, false);
            } else {
                $update = array($this->columns['status'] => $status);

                if ($this->settings['save_points']) {
                    $update[$this->columns['points']] = $points;
                }

                $Model->save($update, false, array_keys($update));

                if ($this->settings['send_email']) {
                    $update[$this->columns['points']] = $points;

                    $this->__notify($data, $update);
                }
            }

            return $points;
        }
    }

    /**
     * Sends out an email notifying you of a new comment.
     *
     * @access private
     * @uses Model
     * @param array $data
     * @param array $stats
     * @return void
     */
    private function __notify($data, $stats) {
        if (!empty($this->settings['parent_model']) && !empty($this->settings['article_link']) && !empty($this->settings['notify_email'])) {
            $Entry = $this->settings['parent_model'];

            if (strpos($Entry, '.') !== false) {
                $parts = explode('.', $Entry);
                $Entry = $parts[1];
            }

            // Get parent entry/blog
            $fields = array('id', $this->columns['title']);
            if ($this->settings['use_slug']) {
                $fields[] = $this->columns['slug'];
            }

            $entry = ClassRegistry::init($this->settings['parent_model'])->find('first', array(
                'fields' => $fields,
                'conditions' => array('id' => $data[$this->columns['foreign_id']]),
                'recursive' => -1,
                'contain' => false
            ));

            if ($this->settings['use_slug']) {
                $entryLink = str_replace(':slug', $entry[$Entry][$this->columns['slug']], $this->settings['article_link']);
            }

            $entryLink = str_replace(':id', $entry[$Entry]['id'], $this->settings['article_link']);
            $entryTitle = $entry[$Entry][$this->columns['title']];

            // Build message
            $message  = "A new comment has been posted for: ". $entryLink ."\n\n";
            $message .= "Name: ". $data[$this->columns['author']] ." <". $data[$this->columns['email']] .">\n";
            $message .= "Status: ". ucfirst($stats['status']) ." (". $stats['points'] ." Points)\n";
            $message .= "Message:\n\n". $data[$this->columns['content']];

            // Send email
            mail($this->settings['notify_email'], 'Comment Approval: '. $entryTitle, $message, 'From: '. $data[$this->columns['author']] .' <'. $data[$this->columns['email']] .'>');
        }
    }

}
