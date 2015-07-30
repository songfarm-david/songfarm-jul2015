<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Songcircle - Virtual Songwriter's Circle</title>
        <meta name="description" content="Share your newest song in a live virtual songwriter's circle">
        <!-- a meta "description" can and should be included on each independent page to DESCRIBE it -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link href="css/index.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="js/html5-shiv/html5shiv.min.js"></script>
          <script src="js/html5-shiv/html5shiv-printshiv.min.js"></script>
        <![end if]-->
        <style>
          header div.register.medium{ display: none; }
          #header nav ul li a[href="songcircle.php"]{ color: #7CC919; }
          #header nav ul li a[href="songcircle.php"]:before{
            content:url('images/arrows_and_lines/navActive_arrow.png');
            position:absolute; left:-15px; top:3px;
          }
        </style>
    </head>
		<body>
      <?php include 'includes/header.php' ?>
<!-- Hosting live songcircle events here!!! -->
			<!-- Use RDFa to define songcircle events // schema.org -->

      <!-- remember to use the '<time></time>' attribute when scheduling songcircles-->
		</body>
</html>
