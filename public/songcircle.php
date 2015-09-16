<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Songcircle - Virtual Songwriter's Circle</title>
        <meta name="description" content="Share your newest song in a live virtual songwriter's circle">
        <!-- a meta "description" can and should be included on each independent page to DESCRIBE it -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta property="og:url" content="http://www.songfarm.ca/songcircle.php">
        <meta property="og:title" content="Songcircle - Virtual Songwriter's Circle">
        <meta property="og:description" content="Participate in a virtual songwriter's circle and workshop your songs with other songwriters - all from the comfort of your home. Register Today!">
        <meta property="og:image" content="http://www.songfarm.ca/images/songfarm_logo_l.png">
        <meta property="og:image:width" content="1772">
        <meta property="og:image:height" content="1170">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link href="css/index.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="//platform.linkedin.com/in.js">
            api_key:   77fxwmu499ca9c
            authorize: true
        </script>
        <!--[if lt IE 9]>
          <script src="js/html5-shiv/html5shiv.min.js"></script>
          <script src="js/html5-shiv/html5shiv-printshiv.min.js"></script>
          <script src="js/respond.js" type="text/javascript"></script>
          <script src="//ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
        <![end if]-->
        <style>
          header div.register.medium{ display: none; }
          #header nav ul li a[href="songcircle.php"]{ color: #7CC919; }
          #header nav ul li a[href="songcircle.php"]:before{
            content:url('images/arrows_and_lines/navActive_arrow.png');
            position:absolute; left:-15px; top:3px;
          }
        article#songcircle{
          height: 405px;
          /*border: 1px solid #ccc;*/
          font-size:1.2em;
          padding-top: 48px;
          padding-left: 18.2%;
          padding-right: 13.9%;
        }
        article section{
          float:left; width:55%;
        }
        article#songcircle h1{ display: none; }
        article#songcircle h2{
          font-size: 2.8em;
        }
        article#songcircle h2 + p{ margin-top: 48px;}
        article#songcircle p{
          line-height: 1.4;
          margin-top: 16px;
        }

        aside#schedule{
          width:31%;
          height:387px;
          float:right;
          border:2px solid #7CC919;
          margin-top: 15px;
          border-radius: 12px;
        }
        aside#schedule h3{
          margin:36px 0 48px 53px;
          font-size: 1.2em;
        }
        aside#schedule p{
          margin-left: 53px;
          font-size: 0.8em;
          font-style: italic;
        }
        footer{width:1600px;}
        span.register{ text-decoration: underline; transition-duration: .250s;}
        span.register:hover{ cursor: pointer; color:#7CC919; transition-duration: .250s; }
        </style>

    </head>
		<body>
      <?php include '../includes/header.php' ?>
      <script>
      // social
      window.fbAsyncInit = function() {
         FB.init({
           appId      : '984018624954627',
           xfbml      : true,
           version    : 'v2.4'
         });
       };

       (function(d, s, id){
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

      // Twitter
        window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
          t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);

        t._e = [];
        t.ready = function(f) {
          t._e.push(f);
        };

          return t;
        }(document, "script", "twitter-wjs"));
      </script>

      <article id="songcircle">
        <h1>Songcircle</h1>
        <section>
          <h2>What is a Songcircle?</h2>
          <p>
            A Songcircle is a virtual songwriter's circle - a group of songwriters coming together sharing their songs and ideas, inspiring and helping one another, and having a good time doing it - all done over the web.
          </p>
          <p>
            The <strong>Songcircle</strong> is one of Songfarm's trademark features. In the near future, this page is where you'll view and participate in upcoming Songcircles. It's easy. All you need is an internet connection, a webcam and a song.
          </p>
          <p>
            <span class="register">Register Today</span> and we'll let you know when you can take part in the next Songcircle!
          </p>
        </section>
        <aside id="schedule">
          <h3>Scheduled Songcircles:</h3>
          <p>
            None scheduled currently.
          </p>
        </aside>
      </article>
			<!-- Use RDFa to define songcircle events // schema.org -->

      <?php include '../includes/footer.php'; ?>
      <!-- remember to use the '<time></time>' attribute when scheduling songcircles-->

      <!-- registration form -->
      <div id="overlay" class="hide"></div>
        <form id="register-form" action="#" method="post" class="hide">
          <img src="images/buttons/close_button_24.png">
          <div>
            <p>Please Select Your User Type:</p>
      			<div class="user" value="1">Artist</div>
      			<div class="user" value="2">Industry</div>
      			<div class="user" value="3">Fan</div>
      			<input type="hidden" id="user_type" name="user_type" value="">
          </div>
          <div id="second" class="hide">
            <p>Please Enter Your Name And Email</p>
      			<input type="text" id="username" name="user_name" data-msg-required="The name field is required" minlength="2" placeholder="Your Name" required>
      			<input type="email" id="useremail" name="user_email" data-msg-required="The email field is required" placeholder="Your Email" required>
      			<input type="submit" id="submitForm" value="Register Me!">
          </div>
          <!-- form result message -->
          <div id="message" class="hide">
            <p></p>
          </div>
        </form>
      <!-- end of: registration form -->
      <script type="text/javascript" src="js/jquery.validate.min.js"></script>
      <script type="text/javascript" src="js/register_form.js"></script>
      <script type="text/javascript" src="js/social.js"></script>
		</body>
</html>
