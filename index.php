<html>
  <head>
	<title>SkillVille.be - Oefenen van levensvaardigheden</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
	  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	  <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

	<!-- Add fancyBox -->
	<link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
	<script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js?v=2.1.4"></script>

	<!-- Optionally add helpers - button, thumbnail and/or media -->
	<link rel="stylesheet" href="js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
	<script type="text/javascript" src="js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<script type="text/javascript" src="js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5"></script>

	<link rel="stylesheet" href="js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
	<script type="text/javascript" src="js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<style type="text/css">
     
	#bg { position: fixed; top: 0; left: 0;}
	.bgwidth { width: 100%; }
	.bgheight { height: 100%; }
	.logo {
		position: relative;
		margin-top:-130px;
		margin-left:auto;
		margin-right:auto;
		padding-right:20px;
		z-index:1;
		width:855px;
		background-position:right; 
		height:500;
/*		border: 1px green solid;*/
/*		background-image:url('skillville_logo2.png');*/
		background-repeat:no-repeat;
	}
	
	nav { margin-bottom: 30px; position: relative; }
	 nav ul {
	  overflow: hidden;
	  padding-bottom: 10px;
	  border-bottom: 5px solid #bbb;
	
	 } nav li {
	  float: left;
	  margin-right: 35px;
	 } nav li a {
	  color: #666;
	  font-weight: bold;
	 } nav li a:hover,
	 nav li a:focus,
	 nav li a.current {
	  color: #000;
	 }
	
	
    </style>
	<script>
	$(window).load(function() {    

		var theWindow        = $(window),
		    $bg              = $("#bg"),
		    aspectRatio      = $bg.width() / $bg.height();

		function resizeBg() {

			if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
			    $bg
			    	.removeClass()
			    	.addClass('bgheight');
			} else {
			    $bg
			    	.removeClass()
			    	.addClass('bgwidth');
			}

		}

		theWindow.resize(resizeBg).trigger("resize");
		
		$(document).ready(function() {
				$(".fancybox").fancybox();
			});
	});
	
	
	</script>

	<!-- stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/style.css" />	
	
	<!-- javascript -->
	<script type="text/javascript" src="js/jquery.tools.min.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<!--[if lt IE9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script type="text/javascript">
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-39556186-1', 'skillville.be');
	  ga('send', 'pageview');

	</script>
  </head>
  <body>
	<script type="text/javascript">

		$(function() {

			var indicator = $('#indicator'),
					indicatorHalfWidth = indicator.width()/2,
					lis = $('#tabs').children('li');

			$("#tabs").tabs("#content section", {
				effect: 'fade',
				fadeOutSpeed: 0,
				fadeInSpeed: 400,
				onBeforeClick: function(event, index) {
					var li = lis.eq(index),
					    newPos = li.position().left + (li.width()/2) - indicatorHalfWidth;
					indicator.stop(true).animate({ left: newPos }, 600, 'easeInOutExpo');
				}
			});	

		});

	</script>
	
    <img src="bg_skillville_front.jpg" id="bg">
	<div style="position:absolute; top:40px; left: 50px; z-index:100"><a href="http://www.khlim.be" target="_blank"><img src="img/logos_ism_khlim.png"></a></div>
	<div style="position:absolute; top:130px; left: 35px; z-index:100"><a href="http://www.kbc.be" target="_blank"><img src="img/logos_ism_kbc.png"></a></div>
	
    <div class="logo"><img src="skillville_logo2.png">
	
		<div class="nav" style="padding-left: 25px; width:540px; margin-left:auto; margin-right:auto; margin-top:-200px; z-index:99; position: relative;">	 
			<header>
				<hgroup>

				</hgroup>
			</header>
			<nav style="border: solid 1px; border-color:#cdcdcd; background-color:white; padding-top:10px; padding-left:10px; padding-right:10px;">		
				<ul id="tabs" style="background-color:white;">
					<li><a class="current" href="#">Wat?</a></li>
					<li><a href="#">Voor wie?</a></li>
					<li><a href="#">Hoe?</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
				<span id="indicator"></span>
			</nav>

			<div id="content" style="border: solid 1px; border-color:#cdcdcd; position: relative; background-color:white; padding-top:10px; padding-right:10px; padding-left: 5px; padding-bottom: 20px; font-size:15px;">

				<section>				
					<p>
						Skillville is een online multimediatool voor het verhogen van de financi&euml;le geletterdheid en de realisatie van de vakoverschrijdende eindtermen.</p>

					<p>Financi&euml;le educatie is de ruggengraat van Skillville en integreert de andere contexten van de vakoverschrijdende eindtermen. 	<a class="fancybox" rel="group" href="img/slov.png">(open schema)</a>
				</p>

				</section>

				<section>		
					<p>De leerlingen van de 1ste, 2de & 3de graad van het secundair onderwijs. 
					Financi&euml;le geletterdheid wordt er op niveau van de graad gerealiseerd met telkens 25 specifieke events. </p>		
				</section>

				<section>
					<p>Voor het gebruik van deze tool zijn verschillende didactische scenario’s uitgewerkt: gebruik tijdens de les, inoefenmateriaal, zelfsturend leren, projectwerking,...
	</p>
					Skillville bevat:<br><br>
					<p>
						<b>
					•	Multimediatool met 75 events<br>
					•	Werkboek voor de leerlingen<br>
					•	Lerarenhandleiding met oplossingen en didactische tips<br>
					•	Rapporteringsmodule voor de evaluatie van de leerlingen
					</b>
					</p>
				</section>

				<section>
					<p>Skillville wordt ontwikkeld door de expertisecel [ED+ict] van de Katholieke Hogeschool Limburg en wordt geëxploiteerd door Cetit bvba, spin-off van de KHLim.   </p>
					<p>contacteer ons: <a href="mailto:info@skillville.be">info@skillville.be</a></p>
				</section>



			</div>
		
		</div>
	
	</div>

		
  </body>
</html>