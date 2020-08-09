<?php

namespace OneTUI;
use OneT\Accounts;
use OneT\Statistics;

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
    private $stats;
    private $app;

    /**
     * Views constructor.
     * @param $app
     * @param $service
     */
    function __construct($app, $service)
    {
        $this->app = $app;
        $this->service = $service;

        $this->sharedData = [
            'views' => $this->views_dir,
            'components' => $this->components_dir,
            'assets' => $this->assets_dir,
            'version' => $this->ui_version,
            'site_url' => $this->site_url,
        ];
        $this->stats = new Statistics($app);
    }

    public function show($req, $resp, $app, $service)
    {
        $page = $req->page;
        $page();
    }

    public function showProtected($page)
    {
        if (!Accounts::isLoggedIn()) {
            $this->login();
        }

    }

    public function getSharedData()
    {
        return $this->sharedData;
    }

    public function home()
    {
        $this->renderView("home");
    }

    public function user()
    {
        $this->sharedData['user_links'] = $this->stats->getUserLinks($_SESSION['user_id']);
        $this->renderView("user");
    }

    public function login()
    {
        $this->renderView("login_register");
    }

    /**
     * @param string $site_url
     */
    public function setSiteUrl($site_url)
    {
        $this->site_url = $site_url;
    }

    private function renderView($page)
    {
        $this->service->render($this->views_dir . "$page.phtml", $this->sharedData);
    }

}