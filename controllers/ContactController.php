<?php
class ContactController extends Controller {
    
    public function index(): void {
        $this->requireAuth();
        $contactModel = new Contact();
        $contacts = $contactModel->findByUser(Auth::id());
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        $this->view('contacts.index', compact('contacts', 'user', 'csrf', 'flash', 'unreadAlerts'));
    }
    
    public function create(): void {
        $this->requireAuth();
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        $this->view('contacts.create', compact('user', 'csrf', 'flash', 'unreadAlerts'));
    }
    
    public function store(): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('contacts/create');
            return;
        }
        
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $website = trim($_POST['website'] ?? '');
        $type = trim($_POST['type'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        
        if (empty($name)) {
            $this->flash('error', 'Contact name is required.');
            $this->redirect('contacts/create');
            return;
        }
        
        $contactModel = new Contact();
        $contactModel->create([
            'user_id' => Auth::id(),
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
            'website' => $website,
            'type'    => $type,
            'notes'   => $notes
        ]);
        
        $this->flash('success', 'Contact created successfully!');
        $this->redirect('contacts');
    }
    
    public function edit(int $id): void {
        $this->requireAuth();
        $contactModel = new Contact();
        $contact = $contactModel->findById($id);
        
        if (!$contact || $contact['user_id'] != Auth::id()) {
            $this->flash('error', 'Contact not found.');
            $this->redirect('contacts');
            return;
        }
        
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        $this->view('contacts.edit', compact('contact', 'user', 'csrf', 'flash', 'unreadAlerts'));
    }
    
    public function updateContact(int $id): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect("contacts/$id/edit");
            return;
        }
        
        $contactModel = new Contact();
        $contact = $contactModel->findById($id);
        
        if (!$contact || $contact['user_id'] != Auth::id()) {
            $this->flash('error', 'Contact not found.');
            $this->redirect('contacts');
            return;
        }
        
        $name = trim($_POST['name'] ?? '');
        if (empty($name)) {
            $this->flash('error', 'Contact name is required.');
            $this->redirect("contacts/$id/edit");
            return;
        }
        
        $contactModel->update($id, [
            'name'    => $name,
            'email'   => trim($_POST['email'] ?? ''),
            'phone'   => trim($_POST['phone'] ?? ''),
            'website' => trim($_POST['website'] ?? ''),
            'type'    => trim($_POST['type'] ?? ''),
            'notes'   => trim($_POST['notes'] ?? '')
        ]);
        
        $this->flash('success', 'Contact updated successfully!');
        $this->redirect('contacts');
    }
    
    public function destroy(int $id): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('contacts');
            return;
        }
        
        $contactModel = new Contact();
        $contact = $contactModel->findById($id);
        
        if ($contact && $contact['user_id'] == Auth::id()) {
            $contactModel->delete($id);
            $this->flash('success', 'Contact deleted.');
        }
        
        $this->redirect('contacts');
    }
}
