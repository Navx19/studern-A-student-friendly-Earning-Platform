<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hire People</title>

    <link rel="stylesheet" href="form.css">

    <script>
        function validateForm() {
            let jobTitle = document.getElementById("jobtitle").value.trim();
            let companyName = document.getElementById("companyname").value.trim();
            let jobDescription = document.getElementById("jobdescription").value.trim();
            let commission = document.getElementById("commission").value.trim();
            let contactEmail = document.getElementById("contactemail").value.trim();
            let applicationDeadline = document.getElementById("applicationdeadline").value;
            let result = document.getElementById("result");

            result.innerHTML = "";

            if (jobTitle === "" || companyName === "" || jobDescription === "" ||
                commission === "" || contactEmail === "" || applicationDeadline === "") {
                result.style.color = "red";
                result.innerHTML = "All fields are required";
                return false;
            }

            if (!/\S+@\S+\.\S+/.test(contactEmail)) {
                result.style.color = "red";
                result.innerHTML = "Invalid email format";
                return false;
            }
            return true;

            if (isNaN(commission)) {
                result.style.color = "red";
                result.innerHTML = "Commission must be a number";
                return false;
            }
        }

        function submitJob(e) {
            e.preventDefault();

            if (!validateForm()) return;

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../Controller/FormControl.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function() {
                let result = document.getElementById("result");
                try {
                    let res = JSON.parse(xhr.responseText);
                    result.style.color = res.success ? "green" : "red";
                    result.innerHTML = res.message;
                } catch {
                    result.style.color = "red";
                    result.innerHTML = "Server error";
                }
            };

            xhr.send(
                "jobtitle=" + encodeURIComponent(jobtitle.value) +
                "&companyname=" + encodeURIComponent(companyname.value) +
                "&jobdescription=" + encodeURIComponent(jobdescription.value) +
                "&commission=" + encodeURIComponent(commission.value) +
                "&contactemail=" + encodeURIComponent(contactemail.value) +
                "&applicationdeadline=" + encodeURIComponent(applicationdeadline.value)
            );
        }
    </script>

</head>

<body class="form-body">
    <div class="form-container">
        <h1>studern</h1>
        <h2>POST A JOB</h2>
        <p>Please fill in the details below to post a job</p>

        <form id="jobForm" onsubmit="submitJob(event)" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Job Title:</label>
                <input type="text" id="jobtitle" placeholder="Enter job title"><br>
            </div>
            <div class="form-group">
                <label>Company Name:</label>
                <input type="text" id="companyname" placeholder="Enter company name"><br>
            </div>
            <div class="form-group">
                <label>Job Description:</label>
                <textarea id="jobdescription" rows="5"></textarea><br>
            </div>
            <div class="form-group">
                <label>Commission:</label>
                <input type="text" id="commission" placeholder="Enter commission Amount"><br>
            </div>
            <div class="form-group">
                <label>Contact Email:</label>
                <input type="email" id="contactemail" placeholder="Enter your email address"><br>
            </div>
            <div class="form-group">
                <label>Application Deadline:</label>
                <input type="date" id="applicationdeadline"><br>
            </div>
            <input type="file" name="jobfile" id="jobfile"><br>
            <input id="submit" type="submit" value="Post">
            <button id="reset" type="reset">Reset</button><br><br>


            <p id="result" class="result-message"></p>
        </form>

        <button type="button" onclick="window.location.href='customerhome.php'">Back to Home</button>

    </div>
</body>

</html>