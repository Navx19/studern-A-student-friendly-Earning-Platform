<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hire People</title>

    <link rel="stylesheet" href="form.css">
</head>
<body>
<header>
    <h1>POST A JOB</h1>
</header>
<form>
    <label >Job Title:</label>
    <input type="text" name="jobtitle" ><br>
    <label >Company Name:</label>
    <input type="text" name="companyname"><br>
    <label >Job Description:</label>
    <textarea name="jobdescription" rows="5"></textarea><br>
    <label >Location:</label>
    <input type="radio" name="location" value="onsite">Onsite
    <input type="radio" name="location" value="remote">Remote
    <input type="radio" name="location" value="hybrid">Hybrid
    <br>
    <label >Salary Range:</label>
    <input type="text" name="salaryrange"><br>
    <label >Contact Email:</label>
    <input type="email" name="contactemail"><br>
    <label >Application Deadline:</label>
    <input type="date" name="applicationdeadline"><br>
    <input type="submit" value="Post">
    <button type="reset">Restore</button>
</form>
