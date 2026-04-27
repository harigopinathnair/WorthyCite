<?php
$pageTitle = 'Vendor Contacts';
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Vendor Contacts</h1>
        <p class="page-subtitle">Manage your link building relationships</p>
    </div>
    <div class="page-actions">
        <a href="<?= APP_URL ?>/contacts/create" class="btn btn-primary">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> New Contact
        </a>
    </div>
</div>

<div class="page-body">
    <?php if (empty($contacts)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <div class="empty-state-title">No Contacts Yet</div>
                <div class="empty-state-text">Add your first vendor or outreach contact to start managing relationships.</div>
                <a href="<?= APP_URL ?>/contacts/create" class="btn btn-primary">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i> Add New Contact
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="card animate-in">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact Info</th>
                            <th>Type</th>
                            <th>Website</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($contact['name']) ?></strong>
                                </td>
                                <td>
                                    <?php if (!empty($contact['email'])): ?>
                                        <div><a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="text-secondary"><?= htmlspecialchars($contact['email']) ?></a></div>
                                    <?php endif; ?>
                                    <?php if (!empty($contact['phone'])): ?>
                                        <div class="text-muted" style="font-size: 13px;"><?= htmlspecialchars($contact['phone']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($contact['type'])): ?>
                                        <span class="badge badge-info"><?= ucfirst(htmlspecialchars($contact['type'])) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($contact['website'])): ?>
                                        <a href="<?= htmlspecialchars(strpos($contact['website'], 'http') === 0 ? $contact['website'] : 'https://'.$contact['website']) ?>" target="_blank" class="text-secondary">
                                            <?= htmlspecialchars($contact['website']) ?> <i data-lucide="external-link" style="width:12px;height:12px;"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex" style="gap: 8px;">
                                        <a href="<?= APP_URL ?>/contacts/<?= $contact['id'] ?>/edit" class="btn btn-sm btn-secondary">Edit</a>
                                        <form method="POST" action="<?= APP_URL ?>/contacts/<?= $contact['id'] ?>/delete" onsubmit="return confirm('Are you sure you want to delete this contact?');" style="display:inline;">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                            <button type="submit" class="btn btn-sm btn-danger"><i data-lucide="trash-2" style="width:14px;height:14px;margin:0;"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
