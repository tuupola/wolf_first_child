<?php

/*
 * First Child - Frog CMS behaviour
 *
 * Copyright (c) 2009 Mika Tuupola
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
        $check_url = '/' . str_replace(URL_PUBLIC, '', $page->url());
        if ($check_url == $_SERVER['REQUEST_URI']) {
            /* Workaround for Behaviour::loadPageHack() throwing errors. */
            if (class_exists('AutoLoader')) {
                AutoLoader::addFolder(dirname(__FILE__));
            }

            unset($params);
            $params['limit'] = 1;
            if ($child = $page->children($params)) {
                /* For Toad see http://github.com/tuupola/toad */
                if (defined('TOAD')) {
                    header('Location: ' . $child[0]->url());                                        
                } else {
                    header('Location: ' . $child->url());                    
                }
                die();
            }
        }
    }
    
    public function usesParameters() {
        return false;
    }
    
}
