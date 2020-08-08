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
    private $site_url = "https://1t.ie/";

    function __construct($_service)
    {
        $this->service = $_service;
        $this->sharedData = [
            'views' => $this->views_dir,
            'components' => $this->components_dir,
            'assets' => $this->assets_dir,
            'version' => $this->ui_version,
            'site_url' => $this->site_url,
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

    public function userPage($user_links)
    {
        $this->sharedData['user_links'] = $user_links;
        $this->service->render($this->views_dir . "user.phtml", $this->sharedData);
    }

    /**
     * @return string
     */
    public function getSiteUrl()
    {
        return $this->site_url;
    }

    /**
     * @param string $site_url
     */
    public function setSiteUrl($site_url)
    {
        $this->site_url = $site_url;
    }

}