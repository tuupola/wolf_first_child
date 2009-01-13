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

class Redirect_to_first_child {
    
    public function __construct(&$page, $params) {
        /* Parent behaviours seem to be automatically executed. Bug or feature*? */
        /* Execute this behaviour only if page equals the current page.          */
        if (CURRENT_URI == $page->url) {
            /* Workaround for Behaviour::loadPageHack() throwing errors. */
            AutoLoader::addFolder(dirname(__FILE__));            

            unset($params);
            $params['limit'] = 1;
            if ($child = $page->children($params)) {
                header('Location: ' . $child->url()); 
                die();            
            }
        } 
    }
    
}




