<?php

namespace Core;

class Application
{
    public Request $request;
    public Response $response;
    public Router $router;
    public View $view;
    public Session $session;
    public Csrf $csrf;
    public Database $db;
    public static Application $app;
    public function __construct()
    {
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
        $this->view = new View();
        $this->session = new Session();
        $this->csrf = new Csrf();
        $this->db = new Database();

    }

    public function run(): void
    {
        echo $this->router->dispatch();
    }
}