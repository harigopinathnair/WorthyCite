<?php
/**
 * Worthycite - Newsletter Controller
 * Handles newsletter subscription from exit-intent popup
 */
class NewsletterController extends Controller {

    public function subscribe(): void {
        // Only accept POST + AJAX
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request'], 405);
        }

        $email = trim($_POST['email'] ?? '');

        // Validate email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['success' => false, 'message' => 'Please enter a valid email address.']);
        }

        try {
            $db = getDB();

            // Check if already subscribed
            $stmt = $db->prepare('SELECT id FROM newsletter_subscribers WHERE email = ?');
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $this->json(['success' => true, 'message' => "You're already subscribed! 🎉"]);
            }

            // Insert new subscriber
            $stmt = $db->prepare('INSERT INTO newsletter_subscribers (email, source) VALUES (?, ?)');
            $stmt->execute([$email, 'exit_popup']);

            $this->json(['success' => true, 'message' => 'Welcome aboard! Check your inbox for SEO tips. 🚀']);

        } catch (PDOException $e) {
            $this->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }
}
