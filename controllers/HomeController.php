<?php
class HomeController extends Controller {
    
    public function index(): void {
        if (Auth::check()) {
            $this->redirect('dashboard');
            return;
        }
        $this->view('home.index');
    }

    public function pricing(): void {
        $this->view('home.pricing');
    }

    public function features(): void {
        $this->view('home.features');
    }

    public function help(): void {
        $this->view('home.help');
    }

    public function contact(): void {
        $this->view('home.contact');
    }
}
