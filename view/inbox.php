<?php
require "./model/mode_inbox.php";


// Configuration
$emailsPerPage = 10; // Set the number of emails per page

// Get the current inboxPage number from the query parameter (default to 1)
$inboxPage = isset($_GET['inboxPage']) ? (int)$_GET['inboxPage'] : 1;
if ($inboxPage < 1) $inboxPage = 1; // Ensure the inboxPage number is at least 1

// Get the total number of emails
$totalEmails = count($emails); // Assuming $emails contains all emails fetched
$totalPages = ceil($totalEmails / $emailsPerPage); // Calculate total pages

// Calculate the starting index for the emails to fetch
$start = ($inboxPage - 1) * $emailsPerPage;

// Fetch the emails for the current inboxPage
$currentEmails = array_slice($emails, $start, $emailsPerPage);
?>

<div class="email-container">
    <div class="email-list" id="emailList">
        <?php if (empty($currentEmails)): ?>
            <p>No emails found.</p>
        <?php else: ?>
            <?php foreach ($currentEmails as $email): ?>
                <div class="senddatamail">
                    <div class="sendcheck">
                        <input type="checkbox" class="checkbox" name="email-select[]">
                        <div class="iconstar" data-id="<?php echo htmlspecialchars($email['id']); ?>" data-isstar="<?php echo htmlspecialchars($email['isstar']); ?>">
                            <i class="fa-<?php echo $email['isstar'] == 1 ? 'solid' : 'regular'; ?> fa-star star-icon"></i>
                        </div>
                    </div>
                    <div class="email" data-id="<?php echo htmlspecialchars($email['id']); ?>">
                        <div class="email-subject"><?php echo htmlspecialchars($email['subject']); ?></div>
                        <div class="email-snippet"><?php echo htmlspecialchars($email['body']); ?></div>
                        <div class="email-time"><?php echo htmlspecialchars($email['created_at']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination Controls -->
    <div class="pagination">
        <?php if ($inboxPage > 1): ?>
            <a href="?type=inbox&inboxPage=<?php echo $inboxPage - 1; ?>" class="pagination-button"><i class="fa-solid fa-angle-left"></i></a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?type=inbox&inboxPage=<?php echo $i; ?>" class="pagination-button <?php echo $i == $inboxPage ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
        
        <?php if ($inboxPage < $totalPages): ?>
            <a href="?type=inbox&inboxPage=<?php echo $inboxPage + 1; ?>" class="pagination-button"><i class="fa-solid fa-angle-right"></i></a>
        <?php endif; ?>
    </div>
</div>

<script>
document.querySelectorAll('.iconstar').forEach(star => {
    star.addEventListener('click', function() {
        const emailId = this.getAttribute('data-id');
        // Add logic to toggle star status if needed
        console.log('Star clicked for email ID:', emailId);
    });
});
</script>

<style>
.email-container {
    display: flex;
    flex-direction: column;
    align-items: stretch; /* Ensure items stretch to full width */
}

.email-list .senddatamail {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.email-list .sendcheck {
    display: flex;
    align-items: center;
}

.email-list .sendemail {
    cursor: pointer;
    flex-grow: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.email-list .sendemail div {
    padding: 0 10px;
}

.fa-star {
    cursor: pointer;
    margin-left: 10px;
    color: #ffab00; /* Star color */
}

.fa-regular.fa-star {
    color: #ccc; /* Unfilled star color */
}

/* Pagination styles */
.pagination {
    display: flex;
    justify-content: flex-end; /* Align pagination to the right */
    margin: 20px 0;
}

.pagination-button {
    margin: 0 5px;
    padding: 5px 10px;
    border: 1px solid #007bff;
    color: #007bff;
    text-decoration: none;
}

.pagination-button.active {
    background-color: #007bff;
    color: white;
}

.pagination-button:hover {
    background-color: #0056b3;
    color: white;
}
</style>
