<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <title>Welcome to Intellipharm</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/assets/js/functions.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <link href="<?php echo base_url('/assets/css/style.css'); ?>" rel="stylesheet">
</head>

<body>
    
    <div class="container" style="width:1170px;margin:0px auto 150px;">
        <canvas id="myChart"></canvas>
        <span style="color:red;font-weight:700">*** Click the points in the chart above to view more details of registration infomartion.</span>
        <div class="search_bar">
            <form action="<?php echo base_url(); ?>" class="frm_users">
                <input type="input" name="firstname" placeholder="Insert Your First Name" class="input_search input_fname" value="<?php echo isset($_GET['firstname']) ? $_GET['firstname'] : ''; ?>">
                <input type="input" name="surname" placeholder="Insert Your Surname" class="input_search input_lname" value="<?php echo isset($_GET['surname']) ? $_GET['surname'] : ''; ?>">
                <input type="input" name="email" placeholder="Insert Your Email" class="input_search input_email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>">
                <input type="submit" value="Search">
            </form>
        </div>
        <div class="user_list">
            <div class="list_header">
                <div class="header_field" style="width:10%;">ID</div>
                <div class="header_field" style="width:20%;">Firstname</div>
                <div class="header_field" style="width:20%;">Surname</div>
                <div class="header_field" style="width:20%;">Email</div>
                <div class="header_field" style="width:10%;">Gender</div>
                <div class="header_field" style="width:20%;">Joined Date</div>
            </div>

            
        </div>

        <div class="pagination">

        </div>
    </div>
</body>
</html>