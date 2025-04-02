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
  <link rel="stylesheet" href="../css/manage_user.css">
</head>
<body>

  <div class="sidebar">
  <h2><a href="/newnews">New News</a></h2>
    <a href="AdminPanel.php">📊 Dashboard</a>
      <a href="manage_news.html">📰 Manage News</a>
      <a href="manage_user.php">👥 Manage Users</a>
      <a href="manage_message.php">✉️ User Messages</a>
      <div class="logout-btn">
        <a href="logout.php">🔓 Logout</a>
    </div>
  </div>

  <div class="main-content">
    <h1>👥 Manage Users</h1>
    <div class="actions">
      <button class="btn btn-success add-btn"><i class="fas fa-user-plus"></i> Add User</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT UserID,username,Email,roleid  FROM user";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            session_start();
              while ($row = $result->fetch_assoc()) {
                $_SESSION['username']=$row['Email'];
                $_role=(($row['roleid']==1)?"Admin":"User");
                  echo "<tr>
                          <td>{$row['UserID']}</td>
                          <td>{$row['username']}</td>
                          <td>{$row['Email']}</td>
                          <td>{$_role}</td>
                          <td>
                            <a href='../ahmed/edit_user.php' class='action-btn edit-btn'>Edit</a>
                            <a href='delete_user.php' class='action-btn delete-btn'>Delete</a>
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