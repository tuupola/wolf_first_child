<?php

/*
 * First Child - Wolf CMS behaviour
 *
 * Copyright (c) 2009-2010 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/
 *
 */

include dirname(__FILE__) . '/PageRedirectToFirstChild.php';

class Redirect_to_first_child {

    public function __construct(&$page, $params) {
        /* Parent behaviours seem to be automatically executed. Bug or feature?  */
        /* Execute this behaviour only if page equals the current page.          */
        if (url_match($page->getUri())) {
            /* Workaround for Behaviour::loadPageHack() throwing errors. */
            if (class_exists('AutoLoader')) {
                AutoLoader::addFolder(dirname(__FILE__));
            }

            if ($child = $page->children(array('limit' => 1))) {
                /* For Toad see http://github.com/tuupola/toad */
                if (defined('TOAD')) {
                    header('Location: ' . $child[0]->url());
                } else {
                    header('Location: ' . $child->url());
                }
                die();
            }
        } else {
            // find called page
            foreach ($params as $slug) {
                $page = Page::findBySlug($slug, $page);
            }
            
            // if found
            if ($page instanceof Page) {
                // check for behavior
                if ($page->behavior_id != '') {
                    // add a instance of the behavior with the name of the behavior
                    $page->{$page->behavior_id} = Behavior::load($page->behavior_id, $page, $params);
                }
            } else { // not found
                page_not_found($_SERVER['REQUEST_URI']);
            }
        }
    }

    public function usesParameters() {
        return false;
    }

}
