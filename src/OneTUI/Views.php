<?php

namespace OneTUI;
/**
 * Views helper (Uses klein service)
 */
class Views
{
    private $service;
    private $assets_dir;
    private $sharedData;
    private $views_dir = __DIR__ . "/assets/views/";
    private $components_dir = __DIR__ . "/assets/views/components/";

    function __construct($_service)
    {
        $this->service = $_service;
        $this->assets_dir = str_replace("OneTUI", "assets/", __DIR__);
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