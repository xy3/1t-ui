<?php

namespace OneTUI;
/**
 * Views helper (Uses klein service)
 */
class Views
{
    private $service;
    private $sharedData;
    private $views_dir = "src/views/";
    private $components_dir = "src/views/components/";
    private $assets_dir = "src/";
    private $ui_version = "1.0.0";

    function __construct($_service)
    {
        $this->service = $_service;
        $this->sharedData = [
            'views' => $this->views_dir,
            'components' => $this->components_dir,
            'assets' => $this->assets_dir,
            'version' => $this->ui_version,
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
        $this->service->render($this->views_dir . "user.phtml", $this->sharedData);
    }

}