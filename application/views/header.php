<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ENB --home  </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/HoldOn.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/respond.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/ckfinder/ckfinder.js"></script>
</head>
<body class="container" onload="init()">
 <!--nav bar-->
    <div class="row">
      <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
       <div class="navbar-header">
        <a class="navbar-brand" href="index.php">
             <img >
        </a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
       </div>
       <div class="collapse navbar-collapse" id="collapse">
         <ul class="nav navbar-nav">
          <li ><a href="#">Home</a></li>
          <li class="active"><a href="<?php echo base_url(); ?>index.php/Login">Manage Notices</a></li>
          <li><a href="#">About</a></li>
      
        </ul>
        
       </div>
      </nav>

    </div>

    <!-- header  -->
  <header>
	<div class="row">

<!--	<div class="col-md-4 col-xs-3">-->
<!--    	<a ><img src="--><?php //echo base_url(); ?><!--assets/img/dtu_logo.JPG"   height="150" alt="DTU logo" class="img-circle img-responsive">-->
<!--    	</a> -->
<!--	</div>-->
<!--	<div class="col-md-8 col-xs-9" style="padding-top:50px" >-->
<!--   		<a ><img src="--><?php //echo base_url(); ?><!--assets/img/headertitle.GIF"  style="float:right" height="150" alt="" class="img-rounded img-responsive"/>-->
<!--    	</a>-->
<!--	</div>-->
       <div class="col-md-12">
           <a ><img src="<?php echo base_url(); ?>assets/img/ENB_header.png" class="img-responsive"  ">
           </a>
       </div>


    </div>
	<!-- 
	<div class="col-md-3 col-xs-2">
   		<a ><img src="img/appLogo.PNG" style="float:right" width="150" height="150"  alt="" class="img-rounded img-responsive ">
    	</a> 
	</div>
-->
  </header>


