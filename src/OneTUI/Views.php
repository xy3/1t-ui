<?php

namespace OneTUI;

use OneT\Accounts;
use OneT\Statistics;
use OneT\Utils;

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
    private $app;

    /**
     * Views constructor.
     * @param $app
     * @param $service
     */
    function __construct($app, $service)
    {
        Utils::startSession();
        $this->app = $app;
        $this->service = $service;

        $this->sharedData = [
            'views' => $this->views_dir,
            'components' => $this->components_dir,
            'assets' => $this->assets_dir,
            'version' => $this->ui_version,
            'site_url' => $this->site_url,
        ];
    }

    public function showProtected($req, $resp, $app, $service)
    {
        if (!Accounts::isLoggedIn()) {
            $this->login();
        } else {
            $this->show($req, $resp, $app, $service);
        }
    }

    public function login()
    {
        $this->renderView("login_register");
    }

    private function renderView($page)
    {
        $this->renderComponent("header");
        $this->renderComponent("nav");
        $this->service->render($this->views_dir . "$page.phtml", $this->sharedData);
        $this->renderComponent("footer");
    }

    public function show($req, $resp, $app, $service)
    {
        $page = $req->page;
        if ($page == "") {
            $this->home();
        } else {
            $this->$page();
        }
    }

    private function renderComponent($component)
    {
        $this->service->render($this->components_dir . "$component.phtml", $this->sharedData);
    }

    public function home()
    {
        $this->renderView("home");
    }

    public function contact()
    {
        $this->renderView("contact");
    }

    public function getSharedData()
    {
        return $this->sharedData;
    }

    public function links()
    {
        $stats = new Statistics($this->app->pdo);
        $this->sharedData['user_links'] = $stats->getUserLinks($_SESSION['user']->user_id);
        $this->renderView("links");
    }

    public function user()
    {
        $this->renderView("user");
    }

    /**
     * @param string $site_url
     */
    public function setSiteUrl($site_url)
    {
        $this->site_url = $site_url;
    }

}