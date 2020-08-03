<?php

namespace OneTUI;
/**
 * Views helper (Uses klein service)
 */
class Views
{
    private $service;
    private $assets_dir = __DIR__ . "/assets/";
    private $views_dir = __DIR__ . "/assets/views/";
    private $components_dir = __DIR__ . "/assets/views/components/";
    private $sharedData;

    function __construct($_service)
    {
        $this->service = $_service;
        $this->sharedData = [
            'views' => $this->views_dir,
            'components' => $this->components_dir,
            'assets' => $this->assets_dir
        ];
    }

    public function getSharedData()
    {
        return $this->sharedData;
    }

    public function home()
    {
        $this->service->render($this->views_dir . "home.phtml", $this->sharedData);
    }

    public function userPage()
    {
        $this->service->render($this->views_dir . "home.phtml", $this->sharedData);
    }

}