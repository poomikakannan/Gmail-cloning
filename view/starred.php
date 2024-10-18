<?php

require './config/config.php';

try {
    // Prepare and execute the query
    $query = "SELECT * FROM tbl_email WHERE isstar = 1";
    $stmt = $pdo->query($query);

    // Fetch the result in an array
    $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        /* .star-icon {
            cursor: pointer;
            color: yellow; 
        } */

        .star-icon.starred {
            color: yellow; /* Yellow color when starred */
        }


    </style>
</head>
<htm>
<div class="email-list"></div>
        <?php foreach ($emails as $email): ?>
        <div class="senddatamail">
                <div class="sendcheck">
                <input type="checkbox" class="checkbox" name="email-select[]">
                    <div class="starshow" data-email-id="<?php echo $email['id']; ?>">
                    
                <!-- Star Icon -->
                <div class="iconstar" data-id="<?php echo htmlspecialchars($email['id']); ?>" data-isstar="<?php echo htmlspecialchars($email['isstar']); ?>">
                    <!-- Star icon's initial class depends on isstar column value -->
                    <i class="fa-<?php echo $email['isstar'] == 1 ? 'solid' : 'regular'; ?> fa-star star-icon"></i>
                </div>
                </div>
                </div>
                <div class="email-subject"><?php echo htmlspecialchars($email['subject']); ?></div>
                <div class="email-snippet"><?php echo htmlspecialchars($email['body']); ?></div>
                <div class="email-time"><?php echo htmlspecialchars($email['created_at']); ?></div>
            
            </div>
        <?php endforeach; ?>
</div>
</body>
</html>
