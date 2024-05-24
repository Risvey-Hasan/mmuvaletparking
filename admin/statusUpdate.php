<?php 
$pageTitle = "Update Artist Information";
require_once ("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
require_once("include/connection.php");
require_once ("function/validate.php");
?>
<div class="dash-content">
    <div class="overview">
        <?php 
            if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && $_GET['id'] != "") {
                $id = validate_input($_GET['id']);
            } 
            else{
                header("location: artist_info.php");
                exit();
            }           
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
        ?>
        <div class="container">
        <form id="registrationForm" method="post" action="helpers/update_artist.php" onsubmit="return validateRegiterform()">
        <div class="form-group">
            <h2>Update Artist Information</h2>
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
            <input type="hidden" name="id" value="<?php  echo $row['id']?>">
            <button type="submit">Update</button>
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