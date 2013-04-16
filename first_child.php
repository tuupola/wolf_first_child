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


class RedirectToFirstChild {

    public function __construct(&$page, $params) {

        /* Execute this behaviour only if page equals the current page.          */
        if (url_match($page->getUri())) {
            if ($child = $page->children(array('limit' => 1))) {
                header('Location: ' . $child->url());
                die();
            }
        } else {
            // replicate Page::findByUri's behaviour so that sub pages may also have their specific behaviour
            foreach ($params as $slug) {
                $page = Page::findBySlug($slug, $page);
                // if found
                if ($page instanceof Page) {
                    // check for behavior
                    if ($page->behavior_id != '') {
                        // add a instance of the behavior with the name of the behavior
                        $page->{$page->behavior_id} = Behavior::load($page->behavior_id, $page, $params);
                        //$page on the caller side is now set to the first child-page with a behaviour or to the
                        //value this behaviour assigns to the $page variable.
                        return;
                    }
                } else { // not found
                    pageNotFound($_SERVER['REQUEST_URI']);
                }
            }
            //$page on the caller side is now set to the one which is actually selected by the uri
        }
    }

    public function usesParameters() {
        return false;
    }

}
