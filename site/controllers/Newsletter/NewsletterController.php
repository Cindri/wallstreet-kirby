<?php

require('NewsletterService.php');

class NewsletterController {

    private $lang;
    private $data = [];
    private $newsletterService = null;

    public function __construct($lang = 'de', $data = [])
    {
        $this->lang = $lang;
        $this->data = $data;
        $this->newsletterService = new NewsletterService();
    }

    public function add() {
        $page = site()->visit('galerien', $this->lang);
        return [$page, $this->data];
    }

    public function confirm() {
        return \Response::success('Confirm erfolgreich', $this->data);
    }

    public function signOut() {
        return \Response::success('Sign out');
    }

    public function send() {
        return \Response::success('Send');
    }

}