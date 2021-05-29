<?php use app\core\Application; ?>
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title Page</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
       
       <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
           <a class="navbar-brand" href="#">Title</a>
           <ul class="nav navbar-nav">
               <li class="active">
                   <a href="#">Home</a>
               </li>
               <li>
               <?php if (Application::isGuest()){  var_dump('guest');?>
                <li><a href="/PHPMVCADVANCED.com/login">LOGIN</a></li>
                <li><a href="/PHPMVCADVANCED.com/register">REGISTER</a></li>
            <?php } ?>
            <?php  if (Application::Auth()){ var_dump('auth'); ?>
                <li><a href=""> <?php  echo Application::Auth()->fname ;?></a></li>
                <li><a href="/PHPMVCADVANCED.com/logout">logout</a></li>
                
                <?php } ?>
               </li>
           </ul>
       </nav>
       
        <div class="container">
       
            {{content}}
       
         <?php if(Application::$app->session->getFlash("seccess")){  ?>
            <?php 
           
            ?>
      <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <strong>Title!</strong>    <?php echo(Application::$app->session->getFlash("seccess")); ?>
      </div>
      
         <?php } ?>
        </div>
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
