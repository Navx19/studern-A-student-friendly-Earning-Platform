<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Post a Job</title>
    <link rel="stylesheet" href="form.css">

    <script>
        function submitJob(e) {
            e.preventDefault();

            let result = document.getElementById("result");

            let jobtitle = document.getElementById("jobtitle").value.trim();
            let companyname = document.getElementById("companyname").value.trim();
            let jobdescription = document.getElementById("jobdescription").value.trim();
            let commission = document.getElementById("commission").value.trim();
            let contactemail = document.getElementById("contactemail").value.trim();
            let deadline = document.getElementById("applicationdeadline").value;
            let jobFile = document.getElementById("jobfile").files[0];

            if (!jobtitle || !companyname || !jobdescription || !commission || !contactemail || !deadline) {
                result.style.color = "red";
                result.innerHTML = "All fields are required";
                return;
            }

            if (!/\S+@\S+\.\S+/.test(contactemail)) {
                result.style.color = "red";
                result.innerHTML = "Invalid email format";
                return;
            }

            if (isNaN(commission)) {
                result.style.color = "red";
                result.innerHTML = "Commission must be a number";
                return;
            }

            
            if (jobFile) {
                let allowed = ['image/jpeg', 'image/png', 'application/pdf'];
                let maxSize = 2 * 1024 * 1024; 

                if (!allowed.includes(jobFile.type)) {
                    result.style.color = "red";
                    result.innerHTML = "Only JPG, PNG, PDF allowed";
                    return;
                }
                if (jobFile.size > maxSize) {
                    result.style.color = "red";
                    result.innerHTML = "File must be < 2MB";
                    return;
                }
            }

            
            let form = document.getElementById("jobForm");
            let formData = new FormData(form);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../../Controller/FormControl.php", true);

            xhr.onload = function () {
                console.log("Raw response:", xhr.responseText); // Debug er jonno
                try {
                    let res = JSON.parse(xhr.responseText);
                    result.style.color = res.success ? "green" : "red";
                    result.innerHTML = res.message;
                } catch (err) {
                    result.style.color = "red";
                    result.innerHTML = "Server error: " + xhr.responseText;
                }
            };

            xhr.send(formData); 
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
                <input type="text" name="jobtitle" id="jobtitle" placeholder="Enter job title"><br>
            </div>
            <div class="form-group">
                <label>Company Name:</label>
                <input type="text" name="companyname" id="companyname" placeholder="Enter company name"><br>
            </div>
            <div class="form-group">
                <label>Job Description:</label>
                <textarea name="jobdescription" id="jobdescription" rows="5"></textarea><br>
            </div>
            <div class="form-group">
                <label>Commission:</label>
                <input type="text" name="commission" id="commission" placeholder="Enter commission amount"><br>
            </div>
            <div class="form-group">
                <label>Contact Email:</label>
                <input type="email" name="contactemail" id="contactemail" placeholder="Enter your email"><br>
            </div>
            <div class="form-group">
                <label>Application Deadline:</label>
                <input type="date" name="applicationdeadline" id="applicationdeadline"><br>
            </div>
            <div class="form-group">
                <label>Attach File (optional):</label>
                <input type="file" name="jobfile" id="jobfile"><br>
            </div>

            <input type="submit" value="Post">
            <button type="reset">Reset</button><br><br>

            <button type="button" onclick="window.location.href='customerhome.php'">Back</button>

            <p id="result" class="result-message"></p>
        </form>
    </div>
</body>
</html>
