<?php 
$pageTitle = "Profile";
require_once ("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
require_once("include/connection.php");
?>
<div class="dash-content">
    <div class="overview">
        <?php 
            $id = $_SESSION['User'];
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
        ?>
        <div class="container">
        <form id="registrationForm" method="post" action="helpers/profile.php" onsubmit="return validateRegiterform()">
        <div class="form-group">
            <h2>Profile</h2>
        </div>
           <div class="form-group">
               <?php
                    if(isset($_SESSION["msg"])){
                        echo $_SESSION["msg"];
                    }
                    unset($_SESSION["msg"]);
                ?>
           </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value ="<?php echo $row['name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value ="<?php echo $row['email'] ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone"  value ="<?php echo $row['phone'] ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address"  value ="<?php echo $row['address'] ?>" required>
            </div>
            <button type="submit">Update Profile</button>
        </form>
        <?Php 
          }
        }
        ?>
        </div>
    </div>
</body>
    </div>
<?php require_once("include/footer.php");?>