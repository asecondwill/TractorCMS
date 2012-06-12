<?php
 $this->set('documentData', array(
        'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

    $this->set('channelData', array(
        'title' => __("Most Recent Contacts"),
        'link' => $this->Html->url('/', true),
        'description' => __("Most recent contacts."),
        'language' => 'en-us'));


 foreach ($contacts as $contact) {
        $contactTime = strtotime($contact['Contact']['created']);
 
        $contactLink = array(
            'controller' => 'contacts',
            'action' => 'view',
            'year' => date('Y', $contactTime),
            'month' => date('m', $contactTime),
            'day' => date('d', $contactTime),
            $contact['Contact']['slug']);
        // You should import Sanitize
        App::import('Sanitize');
        // This is the part where we clean the body text for output as the description 
        // of the rss item, this needs to have only text to make sure the feed validates
        $bodyText = preg_replace('=\(.*?\)=is', '', $contact['Contact']['body']);
        $bodyText = $text->stripLinks($bodyText);
        $bodyText = Sanitize::stripAll($bodyText);
        $bodyText = $text->truncate($bodyText, 400, '...', true, true);
 
        echo  $this->Rss->item(array(), array(
            'title' => $contact['Contact']['title'],
            'link' => $contactLink,
            'guid' => array('url' => $contactLink, 'isPermaLink' => 'true'),
            'description' =>  $bodyText,
            'dc:creator' => configure::read('site'),
            'pubDate' => $contact['Contact']['created']));
    }
