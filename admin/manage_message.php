<?php
  require '../connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/manage_message.css">
</head>
<body>

  <div class="sidebar">
  <h2><a href="/newnews">New News</a></h2>
    <a href="AdminPanel.php">📊 Dashboard</a>
      <a href="manage_news.php">📰 Manage News</a>
      <a href="manage_user.php">👥 Manage Users</a>
      <a href="manage_message.php">✉️ User Messages</a>
      <div class="logout-btn">
        <a href="logout.php">🔓 Logout</a>
    </div>
  </div>

  <div class="main-content">
    <h1>✉️ Manage Messages</h1>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Message</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT message_id,username,email_message,message_content FROM message";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            session_start();
              while ($row = $result->fetch_assoc()) {
                $_SESSION['username']=$row['email_message'];
                  echo "<tr>
                          <td>{$row['message_id']}</td>
                          <td>{$row['username']}</td>
                          <td>{$row['email_message']}</td>
                          <td>{$row['message_content']}</td>
                          <td>
                            <a href='#' class='action-btn edit-btn'>Edit</a>
                            <a href='delete_message.php' class='action-btn delete-btn'>Delete</a>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='6'>No users found</td></tr>";
          }

          $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>