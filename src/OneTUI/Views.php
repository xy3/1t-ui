<?php

namespace OneTUI;
/**
 * Views helper (Uses klein service)
 */
class Views
{
    private $service;
    private $views_dir = "src/views/";
    private $components_dir = "src/views/components/";
    private $sharedData;

    function __construct($_service)
    {
        $this->service = $_service;
        $this->sharedData = ['views' => $this->views_dir, 'components' => $this->components_dir];
    }

    public function home() {
        $this->service->render($this->views_dir . "home.phtml", $this->sharedData);
    }

    public function userPage() {
        $this->service->render($this->views_dir . "home.phtml", $this->sharedData);
    }

}