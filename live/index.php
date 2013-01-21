<?php
session_start();

$name = '';
$email = '';
$message = '';

if (isset($_SESSION['return_data'])) {
    
    $formOK = $_SESSION['return_data']['formOK'];
    $entries = $_SESSION['return_data']['entries'];
    $errors = $_SESSION['return_data']['errors'];
    unset($_SESSION['return_data']);
    
    if (!$formOK) {
        foreach ($entries as $key => $value) {
            ${$key} = $value;
        }
        $submitmessage = 'There were some problems with your submission.';
        $responsetype = 'failure';
    }
    else {
        $submitmessage = 'Thank you! Your email has been submitted.';
        $responsetype = 'success';
    }
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    
<head>
    <meta charset="utf-8">    
<!--
      ___           ___           ___                       ___
     /\  \         /\__\         /\  \          ___        /\  \
    /::\  \       /:/  /        /::\  \        /\  \      /::\  \
   /:/\:\  \     /:/__/        /:/\:\  \       \:\  \    /:/\ \  \
  /:/  \:\  \   /::\  \ ___   /::\~\:\  \      /::\__\  _\:\~\ \  \
 /:/__/ \:\__\ /:/\:\  /\__\ /:/\:\ \:\__\  __/:/\/__/ /\ \:\ \ \__\
 \:\  \  \/__/ \/__\:\/:/  / \/_|::\/:/  / /\/:/  /    \:\ \:\ \/__/
  \:\  \            \::/  /     |:|::/  /  \::/__/      \:\ \:\__\
   \:\  \           /:/  /      |:|\/__/    \:\__\       \:\/:/  / 
    \:\__\         /:/  /       |:|  |       \/__/        \::/  /
     \/__/         \/__/         \|__|                     \/__/
      ___           ___            ___         ___                       ___     
     /\__\         /\  \          /\  \       /\  \          ___        /\__\
    /:/ _/_       /::\  \         \:\  \     /::\  \        /\  \      /:/  /
   /:/ /\__\     /:/\:\  \    ___ /::\__\   /:/\:\  \       \:\  \    /:/__/
  /:/ /:/ _/_   /:/  \:\  \  /\  /:/\/__/  /:/  \:\  \      /::\__\  /::\__\____
 /:/_/:/ /\__\ /:/__/ \:\__\ \:\/:/  /    /:/__/ \:\__\  __/:/\/__/ /:/\:::::\__\
 \:\/:/ /:/  / \:\  \ /:/  /  \::/  /     \:\  \  \/__/ /\/:/  /    \/_|:|~~|~
  \::/_/:/  /   \:\  /:/  /    \/__/       \:\  \       \::/__/        |:|  |
   \:\/:/  /     \:\/:/  /                  \:\  \       \:\__\        |:|  |
    \::/  /       \::/  /                    \:\__\       \/__/        |:|  |
     \/__/         \/__/                      \/__/                     \|__|

-->

    <title>The Portfolio of Chris Wojcik - Developer + Designer</title>
    <meta name="description" content="This is the online portfolio site of Chris Wojcik: Web Developer & Designer">
    <meta name="keywords" content="Chris Wojcik, web designer, web developer, portfolio, font end developer, new york, new jersey">
    <meta name="author" content="Chris Wojcik, hello@chriswojcik.net">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">

    <link rel="stylesheet" href="css/normalize.css">
    <!--[if gte IE 8]><!-->
    <link rel="stylesheet" href="css/style.css">
    <!--<![endif]-->
    <!--[if lt IE 8]>
    <link rel="stylesheet" href="css/oldie.css">
    <![endif]-->
    
    <!--[if gte IE 8]><!-->
    <script src="js/vendor/modernizr.2.6.2.custom.min.js"></script>
    <script type="text/javascript">
        (function() {
            var config = {
                kitId: 'ciz1qzm',
                scriptTimeout: 3000
            };
            var h=document.getElementsByTagName("html")[0];h.className+=" wf-loading";var t=setTimeout(function(){h.className=h.className.replace(/(\s|^)wf-loading(\s|$)/g," ");h.className+=" wf-inactive"},config.scriptTimeout);var tk=document.createElement("script"),d=false;tk.src='//use.typekit.net/'+config.kitId+'.js';tk.type="text/javascript";tk.async="true";tk.onload=tk.onreadystatechange=function(){var a=this.readyState;if(d||a&&a!="complete"&&a!="loaded")return;d=true;clearTimeout(t);try{Typekit.load(config)}catch(b){}};var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(tk,s)
        })();
    </script>
    <!--<![endif]-->
    <!--[if lt IE 8]>
    <script src="js/vendor/html5shiv.js"></script>
    <![endif]-->
</head>

<body>
    <!--[if lt IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
    <header class="page-header" id="home">
        <h1 id="logo">
            <a href="#home">
                <img src="img/logo.png" alt="Chris Wojcik: Developer &plus; Designer" width="459" height="164">
            </a>
        </h1>
        <nav class="main-nav">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header><!-- end page-header -->

    <section class="portfolio" id="portfolio">
        <div class="section-wrap clearfix">
            <h2>Portfolio</h2>
            <div id="featured-project">
                <div class="project current" id="project-bartlet">
                    <figure>
                        <img alt="Bartlet-Featured" src="img/bartlet-featured.jpg" width="516" height="538">
                    </figure>
                    <article>
                        <h3>Bartlet For America, Class Project</h3>
                        <h4>Web Design, HTML, CSS, Javascript, PHP, MySQL, Logo Design</h4>
                        <p>
                            The design and development of this site evolved over the course of several class projects.  I'm a bit of a political junkie, so this was my attempt at a political campaign site for a fictional presidential candidate. The project included a mock-up of the site and logo in Photoshop and Illustrator, as well as a prototype site built using HTML5 and CSS3 with jQuery effects to improve user interaction. 
                        </p>
                        <p>
                            The back end was coded in PHP and featured connection to a database of blog posts and a full page donation form which also validated on the client side.
                        </p>
                        <ul class="thumbnail-gallery">
                            <li>
                                <a href="img/bartlet-featured.jpg">
                                    <img alt="Bartlet-Featured" src="img/bartlet-featured-thumb.jpg" width="360" height="375">
                                </a>
                            </li>
                            <li>
                                <a href="img/bartlet-2.jpg">
                                    <img alt="Bartlet-2" src="img/bartlet-2-thumb.jpg" width="360" height="375">
                                </a>
                            </li>
                            <li>
                                <a href="img/bartlet-3.jpg">
                                    <img alt="Bartlet-3" src="img/bartlet-3-thumb.jpg" width="360" height="375">
                                </a>
                            </li>
                        </ul>
                    </article>
                </div><!-- end project-bartlet -->
                <div class="project" id="project-ranger">
                    <figure>
                        <img alt="Ranger-Featured" src="img/ranger-featured.jpg" width="516" height="538">
                    </figure>
                    <article>
                        <h3>[1st RB], Online Gaming Group</h3>
                        <h4>Web Design, HTML, CSS, PHP</h4>
                        <p>
                            The [1st RB] is an online gaming community based in the WWII-era game, Day of Defeat: Source. The goal of the site was to give the group a more personalized visual presence in order to recruit new members and create a more appealing information center for its current roster.  The group had an existing online forum which I integrated with the site to allow the group to manage the site's content by editing the kind of message board posts they were already familiar with.
                        </p>
                        <p>
                            The back end was coded in PHP and I created a basic MVC-style framework to allow for easier templating and handle the database interaction.
                        </p>
                        <ul class="thumbnail-gallery">
                            <li>
                                <a href="img/ranger-featured.jpg">
                                    <img alt="Ranger-Featured" src="img/ranger-featured-thumb.jpg" width="360" height="375">
                                </a>
                            </li>
                            <li>
                                <a href="img/ranger-2.jpg">
                                    <img alt="Ranger-2" src="img/ranger-2-thumb.jpg" width="360" height="375">
                                </a>
                            </li>
                        </ul>
                    </article>
                </div><!-- end project-ranger -->
                <div class="project" id="project-rrca">
                    <figure>
                        <img alt="RRCA-Featured" src="img/rrca-featured.jpg" width="516" height="538">
                    </figure>
                    <article>
                        <h3>Radio Repertory Company of America</h3>
                        <h4>Web Design</h4>
                        <p>
                            The RRCA is an audio production company specializing in the creation of original radio dramas. I was asked to redesign their website for use in an academic presentation of a proposed brand relaunch. The goal of the relaunch was to streamline and update the client's existing web presence and improve the site's integration with social media outlets. For the redesign, I retained the site's original color palette but was inspired by the retro sci-fi theme of many of the group's audio productions.
                        </p>
                        <ul class="thumbnail-gallery">
                            <li>
                                <a href="img/rrca-featured.jpg">
                                    <img alt="RRCA-Featured" src="img/rrca-featured-thumb.jpg" width="360" height="375">
                                </a>
                            </li>
                            <li>
                                <a href="img/rrca-2.jpg">
                                    <img alt="RRCA-2" src="img/rrca-2-thumb.jpg" width="360" height="375">
                                </a>
                            </li>
                            <li>
                                <a href="img/rrca-3.jpg">
                                    <img alt="RRCA-3" src="img/rrca-3-thumb.jpg" width="360" height="375">
                                </a>
                            </li>
                        </ul>
                    </article>
                </div><!-- end project-rrca -->
            </div><!-- end featured project -->
            <nav id="other-projects">
                <h3>Other Projects</h3>
                <ul class="thumbnail-gallery">
                    <li>
                        <a class="current" href="#project-bartlet">
                            <img alt="Bartlet-Featured" src="img/bartlet-featured-thumb.jpg" width="360" height="375">
                        </a>
                    </li>
                    <li>
                        <a href="#project-ranger">
                            <img alt="Ranger-Featured" src="img/ranger-featured-thumb.jpg" width="360" height="375">
                        </a>
                    </li>
                    <li>
                        <a href="#project-rrca">
                            <img alt="RRCA-Featured" src="img/rrca-featured-thumb.jpg" width="360" height="375">
                        </a>
                    </li>
                </ul>
            </nav>
        </div><!-- end section-wrap -->
    </section><!-- end portfolio -->

    <section class="about" id="about">
        <div class="section-wrap clearfix">
            <h2>About Me</h2>
            <div class="bio">
                <h3>Allow Me To Introduce Myself</h3>
                <p>
                    After getting my B.A. from Pennsylvania State University, I started working on political campaigns in the New York/New Jersey metro area, where I kept gravitating toward the design and tech side of the job. I was also designing promotional materials and websites in my free time for friends and local charities, learning as I went. Politics is awful, but building websites is awesome, so I decided to go back to school for formal training. In 2012 I earned a certificate in web development from New York University. I'm now seeking a full time, entry-level position in web design and development. I'd also like to continue to flesh out my portfolio with freelance work, so if you'd like to hire me you can check out my contact information below.
                </p>
                <p>
                    I am obsessed with learning about new technologies and I love just about anything nerdy. Occasionally, I even enjoy turning off my computer and meeting other humans. If you have something cool to share, want to give me suggestions, or just want to chat about tech stuff, drop me a line.
                </p>
                <a href="chriswojcik-resume.pdf" class="download-link">
                    <span aria-hidden="true" data-icon="."></span>
                    Download My Resume <span class="smaller-text">(PDF)</span>
                </a>
            </div>
            <div class="skills-tools">
                <h3>Core Skills &amp; Tools</h3>
                <ul>
                    <li class="css3"><span>CSS / CSS3</span></li>
                    <li class="html5"><span>HTML / HTML5</span></li>                    
                    <li class="javascript"><span>Javascript &#43; JQuery</span></li>
                    <li class="php"><span>PHP &amp; MySQL</span></li>
                    <li class="sass"><span>SASS</span></li>
                    <li class="photoshop"><span>Photoshop</span></li>
                    <li class="illustrator"><span>Illustrator</span></li>
                </ul>
            </div>
        </div><!-- end section-wrap -->
    </section><!-- end about -->

    <section class="contact" id="contact">
        <div class="section-wrap clearfix">
            <h2>Contact Me</h2>
            <div class="contact-info">
                <h3>Get In Touch</h3>
                <p>
                    Interested in hiring me? Want me to do a non-profit job for your worthy charity? Have a networking opportunity? Have we done business together previously? Here's how you can get a hold of me.
                </p>
                <nav class="nav-social">
                    <p>
                        <a href="https://twitter.com/_ChrisWojcik">
                            <span aria-hidden="true" data-icon="!"></span>
                            <span class="visuallyhidden">Twitter</span>
                        </a>              
                        <a href="http://www.linkedin.com/in/christopherpwojcik">
                            <span aria-hidden="true" data-icon="+"></span>
                            <span class="visuallyhidden">LinkedIn</span>
                        </a>
                        <a href="https://github.com/ChrisWojcik">
                            <span aria-hidden="true" data-icon=";"></span>
                            <span class="visuallyhidden">GitHub</span>
                        </a>
                        <a href="mailto:hello@chriswojcik.net">
                            <span aria-hidden="true" data-icon="*"></span>
                            <span class="visuallyhidden">hello@chriswojcik.net</span>
                        </a>
                    </p>
                </nav>
            </div><!-- end contact-info -->
            <form method="post" id="contact-form" action="process.php" novalidate="novalidate">
                <ol>
                    <li id="name-container">
                        <label for="name">Your Name</label>
<?php if (isset($errors['name'])): ?>
                        <span class="error"><?php echo $errors['name']; ?></span>
<?php endif; ?>
                        <input type="text" name="name" id="name"<?php if (isset($errors['name'])) { echo ' class="error"';}?> value="<?php echo $name; ?>" required="required"/>
                    </li>
                    <li id="email-container">
                        <label for="email">Your Email</label>
<?php if (isset($errors['email'])): ?>
                        <span class="error"><?php echo $errors['email']; ?></span>
<?php endif; ?>
                        <input type="email" name="email" id="email"<?php if (isset($errors['email'])) { echo ' class="error"';}?> value="<?php echo $email; ?>" required="required"/>
                    </li>
                    <li id="message-container">
                        <label for="message">Your Message</label>
<?php if (isset($errors['message'])): ?>
                        <span class="error"><?php echo $errors['message']; ?></span>
<?php endif; ?>
                        <textarea rows="6" name="message" id="message"<?php if (isset($errors['message'])) { echo ' class="error"';}?> required="required"><?php echo $message; ?></textarea>
                    </li>
                    <li id="submit-container">                            
                        <p class="instruction"><span class="star">&#42;</span> All Fields Required</p>
                        <input class="button" type="submit" name="send" value="Send" id="send"/>
                        <span id="loading"></span>                
                    </li>
                </ol>
                <div id="submit-message" class="<?php echo (isset($formOK) ? '' : 'hidden'); ?>">
                    <span class="<?php echo (isset($formOK) ? $responsetype : 'hidden'); ?>"><?php if(isset($formOK)) { echo $submitmessage; } ?></span>
                </div>
            </form>
        </div><!--end section-wrap -->
    </section><!-- end contact -->
    
    <footer class="page-footer">
        <p>&copy; 2012-2013 Christopher Wojcik.</p>
        <p>Created on <a href="http://windows.microsoft.com">Windows</a> (because I'm not trendy enough for a <a href="http://www.apple.com/mac/">Mac</a>) and built with <a href="http://www.w3.org/html/logo/">HTML5</a>, <a href="http://dev.w3.org/csswg/css3-syntax/">CSS3</a>, and <a href="http://jquery.com/">JQuery</a>.</p>
        <p>Hosted by <a href="http://asmallorange.com/">A Small Orange.</a></p>
        <nav class="main-nav" id="sticky-nav">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </footer>
    <div id="test"></div>
    <!--[if gte IE 8]><!-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
    <!--<![endif]-->
</body>

</html>