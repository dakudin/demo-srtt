<?php

namespace frontend\widgets\cookieconsent;

use yii\base\Widget;

class CookieConsentWidget extends Widget
{
    public $cookieConsentStatus;
    public $message;
    public $dismiss;
    public $allow;
    public $href;
    public $link;
    public $theme;
    public $container;
    public $path;
    public $position;
    public $domain;
    public $expiryDays;
    public $target;
    public $static;

    public function init()
    {
        parent::init();

        /*
         * These are the possible values that the cookie can be set to.
         *
         * Possible statuses:
         * deny
         * allow
         * dismiss
*/
        if (!$this->cookieConsentStatus) {
            $this->cookieConsentStatus = 'dismiss';
        }

        /*
         * The message shown by the plugin.
         */
        if (!$this->message) {
            $this->message = 'This website uses cookies to ensure you get the best experience on our website.';
        }

        /*
         * The text used on the dismiss button.
         */
        if (!$this->dismiss) {
            $this->dismiss = 'Got It!';
        }

        /*
         * The text used on the allow button.
         */
        if (!$this->allow) {
            $this->allow = 'Allow cookies';
        }

        /*
         * The text shown on the link to the cookie policy (requires the link option to also be set).
         */
        if (!$this->link) {
            $this->link = 'More info';
        }

        /*
         * The url of your cookie policy. If it’s set to null, the link is hidden.
         */
        if (!$this->href) {
            $this->href = null;
        }

        /*
         * The popup uses position fixed to stay in one place on the screen despite any scroll bars. This option makes
         * the popup position static so it displays at the top of the page. A height animation has also been added by
         * default so the popup doesn’t make the page jump, but gradually grows and fades in.
         */
        if (!$this->static) {
            $this->static = false;
        }

        /*
         * The theme you wish to use.
         * Can be any of the themes from the style directory, e.g. dark-bottom.
         *
         * To stop Cookie Consent from loading CSS at all, specify false.
         *
         * Possible themes:
         * block
         * edgeless
         * classic
         */
        if (!$this->theme) {
            $this->theme = 'block';
        }

        /*
         * Position option
         *
         * Possible values:
         * top, bottom – Banner
         * top-left, top-right, bottom-left, bottom-right – Floating
         */
        if (!$this->position) {
            $this->position = 'bottom';
        }

        /*
         * The element you want the Cookie Consent notification to be appended to.
         * If null, the Cookie Consent plugin is appended to the body.
         *
         * Note: the majority of our built in themes are designed around the plugin being a child of the body.
         */
        if (!$this->container) {
            $this->container = null;
        }

        /**
         * The path for the consent cookie that Cookie Consent uses, to remember that users have consented to cookies.
         * Use to limit consent to a specific path within your website.
         */
        if (!$this->path) {
            $this->path = '/';
        }

        /**
         * The domain for the consent cookie that Cookie Consent uses,
         * to remember that users have consented to cookies.
         * Useful if your website uses multiple subdomains,
         *
         * e.g.if your script is hosted at www.example.com you might override this to example.com,
         * thereby allowing the same consent cookie to be read by subdomains like foo.example.com.
         */
        if (!$this->domain) {
            $this->domain = '';
        }

        /**
         * The number of days Cookie Consent should store the user’s consent information for.
         */
        if (!$this->expiryDays) {
            $this->expiryDays = 365;
        }

        /*
         * The target of the link to your cookie policy. Use to open a link in a new window,
         * or specific frame, if you wish.
         */
        if (!$this->target) {
            $this->target = '_self';
        }
    }

    public function run()
    {
        return $this->render('cookieConsentWidget', [
            'cookieConsentStatus' => ['allow'=> 'allow'], //$this->cookieConsentStatus,
            'message' => $this->message,
            'dismiss' => $this->dismiss,
            'allow' => $this->allow,
            'link' => $this->link,
            'href' => $this->href,
            'position' => $this->position,
            'static' => $this->static,
            'theme' => $this->theme,
            'container' => $this->container,
            'path' => $this->path,
            'domain' => $this->domain,
            'expiryDays' => $this->expiryDays,
            'target' => $this->target,
        ]);
    }
}