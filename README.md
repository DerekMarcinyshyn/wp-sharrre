# WP Sharrre

**Contributors**:

* Derek Marcinyshyn [derek.marcinyshyn.com](http://derek.marcinyshyn.com)
* Julien Hany [hany.fr](http://hany.fr)

* **Version**: 1.0
* ~Current Version:1.0~
* **Requires at least**: 3.5
* **Tested up to**: 3.5
* **License**: GPLv2

Features
--------

* Google Plus
* Facebook
* Twitter
* Digg
* Delicious
* StumbleUpon
* Linkedin
* Pinterest default image and url
* Automatically grabs the first image on a page
* Google Analytics tracking
* Improve loading page
* Super lightweight

Description
-----------

WP Sharrre is a WordPress plugin based on a jQuery plugin that allows you to create sharing buttons for Facebook, Twitter, Google Plus and more.

More information on [Sharrre](http://sharrre.com/).

Must be using PHP 5.3.x + and WordPress 3.5

Usage
-----

In your theme use ```<?php if ( is_callable( '\WP_Sharrre\View\Frontend::display_wp_sharrre' ) ) { echo \WP_Sharrre\View\Frontend::display_wp_sharrre(); } ?>``` to display the Share buttons.