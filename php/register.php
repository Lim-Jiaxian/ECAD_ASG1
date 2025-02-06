<?php
// Detect the current session
session_start();
// Include config file
$config = include(__DIR__ . "/../config.php");
// Include the Page Layout header
include("header.php");
?>

<script type="text/javascript">
    function validateForm() {
        // To Do 1 - Check if password matched
        if (document.register.password.value != document.register.password2.value) {
            alert("Passwords not matched!");
            return false; // cancel submission
        }
        // To Do 2 - Check if telephone number entered correctly
        //           Singapore telephone number consists of 8 digits,
        //           start with 6, 8 or 9
        if (document.register.phone.value != "") {
            var str = document.register.phone.value;
            if (str.length != 8) {
                alert("Please enter a 8-digit phone number.");
                return false; // cancel submission
            } else if (str.substr(0, 1) != "6" &&
                str.substr(0, 1) != "8" &&
                str.substr(0, 1) != "9") {
                alert("Phone number in Singapore should start with 6, 8 or 9.");
                return false; // cancel submission       
            }
        }
        return true; // No error found
    }
</script>

<!-- Registration Form -->
<div class="d-flex justify-content-center align-items-center"
    style="min-height: 100vh; background-color: #fcfcfc; padding: 50px 0;">
    <div class="registration-form p-4"
        style="background: #ffffff; width: 90%; max-width: 900px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h3 class="text-center mb-4" style="color: #8d695b; font-weight: bold;">Membership Registration</h3>
        <form name="register" action="addMember.php" method="post" onsubmit="return validateForm()">
            <div class="row">
                <!-- Name -->
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label" style="color: #8d695b;">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" required />
                    <small class="form-text text-muted">(required)</small>
                </div>
                <!-- DOB -->
                <div class="col-md-6 mb-3">
                    <label for="dob" class="form-label" style="color: #8d695b;">Date Of Birth (YYYY-MM-DD):</label>
                    <input type="text" name="dob" id="dob" class="form-control" required />
                    <small class="form-text text-muted">(required)</small>
                </div>
            </div>
            <div class="row">
                <!-- Email -->
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label" style="color: #8d695b;">Email Address:</label>
                    <input type="email" name="email" id="email" class="form-control" required />
                    <small class="form-text text-muted">(required)</small>
                </div>
                <!-- Phone -->
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label" style="color: #8d695b;">Phone:</label>
                    <input type="text" name="phone" id="phone" class="form-control" required />
                    <small class="form-text text-muted">(required)</small>
                </div>
            </div>
            <div class="row">
                <!-- Country -->
                <div class="col-md-6 mb-3">
                    <label for="country" class="form-label" style="color: #8d695b;">Country:</label>
                    <input type="text" name="country" id="country" class="form-control" required />
                    <small class="form-text text-muted">(required)</small>
                </div>
                <!-- Address -->
                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label" style="color: #8d695b;">Address:</label>
                    <textarea name="address" id="address" class="form-control" rows="2" required></textarea>
                    <small class="form-text text-muted">(required)</small>
                </div>
            </div>
            <div class="row">
                <!-- Password -->
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label" style="color: #8d695b;">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required />
                    <small class="form-text text-muted">(required)</small>
                </div>
                <!-- Retype Password -->
                <div class="col-md-6 mb-3">
                    <label for="password2" class="form-label" style="color: #8d695b;">Retype Password:</label>
                    <input type="password" name="password2" id="password2" class="form-control" required />
                    <small class="form-text text-muted">(required)</small>
                </div>
            </div>
            <div class="row">
                <!-- Password Question -->
                <div class="col-md-6 mb-3">
                    <label for="passwordQn" class="form-label" style="color: #8d695b;">Password Question:</label>
                    <input type="text" name="passwordQn" id="passwordQn" class="form-control" required />
                    <small class="form-text text-muted">(required)</small>
                </div>
                <!-- Password Answer -->
                <div class="col-md-6 mb-3">
                    <label for="passwordAns" class="form-label" style="color: #8d695b;">Password Answer:</label>
                    <input type="text" name="passwordAns" id="passwordAns" class="form-control" required />
                    <small class="form-text text-muted">(required)</small>
                </div>
            </div>
            <!-- Register Button -->
            <div class="text-center mt-3">
                <button type="submit" class="btn"
                    style="background-color: #8d695b; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Register</button>
            </div>
        </form>
    </div>
</div>

<?php
// Include the Page Layout footer
include("footer.php");
?>