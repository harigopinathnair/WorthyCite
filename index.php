<?php
/**
 * Worthycite - Main Entry Point & Router
 */

// Start session
session_start();

// Load config
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/app.php';

// Define routes
Router::get('',           'HomeController', 'index');
Router::get('pricing',    'HomeController', 'pricing');
Router::get('features',   'HomeController', 'features');
Router::get('help',       'HomeController', 'help');
Router::get('contact',    'HomeController', 'contact');
Router::get('login',      'AuthController', 'loginForm');
Router::post('login',     'AuthController', 'login');
Router::get('register',   'AuthController', 'registerForm');
Router::post('register',  'AuthController', 'register');
Router::get('logout',     'AuthController', 'logout');

// Dashboard
Router::get('dashboard',  'DashboardController', 'index');

// Projects
Router::get('projects',             'ProjectController', 'index');
Router::get('projects/create',      'ProjectController', 'create');
Router::post('projects/store',      'ProjectController', 'store');
Router::get('projects/{id}',        'ProjectController', 'show');
Router::get('projects/{id}/edit',   'ProjectController', 'edit');
Router::post('projects/{id}/update','ProjectController', 'updateProject');
Router::post('projects/{id}/delete','ProjectController', 'destroy');

// Backlinks
Router::get('projects/{id}/backlinks',        'BacklinkController', 'index');
Router::get('projects/{id}/backlinks/create',  'BacklinkController', 'create');
Router::post('projects/{id}/backlinks/store',  'BacklinkController', 'store');
Router::post('backlinks/{id}/delete',          'BacklinkController', 'destroy');

// Orders
Router::get('orders',              'OrderController', 'index');
Router::get('orders/create',       'OrderController', 'create');
Router::post('orders/store',       'OrderController', 'store');
Router::post('orders/{id}/update', 'OrderController', 'updateStatus');
Router::post('orders/{id}/delete', 'OrderController', 'destroy');

// Alerts
Router::get('alerts',              'AlertController', 'index');
Router::post('alerts/{id}/read',   'AlertController', 'markRead');
Router::post('alerts/read-all',    'AlertController', 'markAllRead');

// Reports
Router::get('reports',             'ReportController', 'index');
Router::post('reports/generate',   'ReportController', 'generate');

// Billing
Router::get('billing',             'BillingController', 'index');
Router::post('billing/upgrade',    'BillingController', 'upgrade');

// Contacts
Router::get('contacts',             'ContactController', 'index');
Router::get('contacts/create',      'ContactController', 'create');
Router::post('contacts/store',      'ContactController', 'store');
Router::get('contacts/{id}/edit',   'ContactController', 'edit');
Router::post('contacts/{id}/update','ContactController', 'updateContact');
Router::post('contacts/{id}/delete','ContactController', 'destroy');

// Admin
Router::get('admin',               'AdminController', 'index');
Router::get('admin/users/{id}',    'AdminController', 'editUser');
Router::post('admin/users/{id}',   'AdminController', 'updateUser');

// API endpoints
Router::get('api/dashboard-stats', 'DashboardController', 'stats');
Router::get('api/chart-data',      'DashboardController', 'chartData');

// Newsletter
Router::post('newsletter/subscribe', 'NewsletterController', 'subscribe');

// Dispatch
Router::dispatch();
