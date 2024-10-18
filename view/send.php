<?php 
require "./model/model_send.php";

// Define the number of emails per page
$emailsPerPage = 10;

// Get the current page number from the query parameter (default to 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting point for the emails to fetch
$start = ($page - 1) * $emailsPerPage;

// Get the emails for the current page
$currentEmails = array_slice($emails, $start, $emailsPerPage); // Fetch the correct slice of emails
// echo "Current Page: " . $page . "<br>";
// echo "Start Index: " . $start . "<br>";
// echo "Emails Per Page: " . $emailsPerPage . "<br>";
// print_r($currentEmails); // Debugging output


// Calculate total pages
$totalEmails = count($emails);
$totalPages = ceil($totalEmails / $emailsPerPage);
?>

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
            <div class="sendemail" data-id="<?php echo htmlspecialchars($email['id']); ?>">
                <div class="email-sender"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
                <div class="email-subject"><?php echo htmlspecialchars($email['subject']); ?></div>
                <div class="email-snippet"><?php echo htmlspecialchars($email['body']); ?></div>
                <div class="email-time"><?php echo htmlspecialchars($email['created_at']); ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="pagination">
    <!-- Show the "Previous" button only if the current page is greater than 1 -->
    <?php if ($page > 1): ?>
        <a href="?type=sent&page=<?php echo $page - 1; ?>" class="pagination-prev"><i class="fa-solid fa-angle-left"></i></a>
    <?php endif; ?>

    <!-- Loop through the total number of pages and display page numbers -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?type=sent&page=<?php echo $i; ?>" class="pagination-page <?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <!-- Show the "Next" button only if there are more pages -->
    <?php if ($page < $totalPages): ?>
        <a href="?type=sent&page=<?php echo $page + 1; ?>" class="pagination-next"><i class="fa-solid fa-angle-right"></i></a>
    <?php endif; ?>
</div>

<style>
    .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    padding: 8px 16px;
    margin: 0 4px;
    text-decoration: none;
    color: #007bff;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.pagination a.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination a:hover {
    background-color: #f1f1f1;
    border-color: #007bff;
}

</style>