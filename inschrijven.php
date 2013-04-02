<?php
   if (isset($_POST['submit']))
   {
      mysql_connect('localhost', 'root', 'root');
      mysql_select_db('skillvillebe');

      // The checkboxen:
      $opt = '';
      if (isset($_POST['opt1'])) { $opt .= '1 '; }
      if (isset($_POST['opt2'])) { $opt .= '2 '; }
      if (isset($_POST['opt3'])) { $opt .= '3 '; }
      if (isset($_POST['opt4'])) { $opt .= '4 '; }

      // The other input:
      $data = array();
      $data['naam'] = isset($_POST['naam']) ? $_POST['naam'] : '';
      $data['voornaam'] = isset($_POST['voornaam']) ? $_POST['voornaam'] : '';
      $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
      $data['school'] = isset($_POST['school']) ? $_POST['school'] : '';
      $data['opt'] = trim($opt);

      function buildInsert ($table, &$data)
      {
         $names = '(';  $sql = 'values ('; $prefix = '';
         foreach ($data as $field => $value)
         {
            $names .= $prefix . $field;
            $sql .= $prefix . '\'' . mysql_real_escape_string($value) . '\'';
            $prefix = ',';
         }
         return ('insert into ' . $table . $names . ')' . $sql . ')');
      }

      $sql = buildInsert('inschrijven', $data);
      if (!mysql_query($sql)) { exit(mysql_error()); }

      // So everything is in the DB now.

      $subject = 'Bevestiging SKILLVILLE voorstelling';
      $message = '<p>Beste'.$data['naam'].' '.$data['voornaam'].',</p>Wij hebben u inschrijving, voor de <b>voorstelling in'.$data['opt'].'</b> correct ontvangen!<p>We kijken alvast uit naar u komst</p>Met vriendelijke groeten,<br>Het SKILLVILLE team!';

      if (!@mail($data['email'], $subject, $message))
      {
         // What to do if the email address is not valid or something.
         // ...
         // perhaps remove the record and request re-registration?
      }

      exit('<h3>Registratie geslaagd!</h3> <p>Er werd u een bevestigingsmail toegestuurd!</p>'); // Perhaps redirect to start page here?
   }
?>
<html>
  <head>
   <title>SKILLVILLE.be - Oefenen van levensvaardigheden</title>
   <meta charset="utf-8" />
   <link type="text/css" href="./slov/css/bootstrap.min.css" rel="stylesheet" />
   <style type="text/css">
      .itemrow { margin-bottom: 12px; }
   </style>
  </head>
  <body>
    <div style= "margin: 10px 32px 32px 32px; width: 550px;">
       <h3 style="color: green;">Gratis inschrijven voorstelling SKILLVILLE!</h3>

	<fieldset style="border: 1px solid grey; padding:10px; margin-top:20px;">
	<legend style=" border: grey 1px solid; width: 200px; padding-left:10px;"><h4>Kies een voorstelling:</h4></legend>
       <form method="post" action="#">
         <div class="row-fluid itemrow">
            <div style="float: left">
               <input type="checkbox" name="opt1" value="1"></input>
            </div>
            <div style="float: left">
               <div style="margin-left: 2px;"><font color="#29a3dd">&nbsp;Voorstelling SKILLVILLE <b>Limburg</b></font> – woensdag 15 mei 2013 – 9u30</div>
               <div style="margin-left: 16px;">KHLim Onderzoekscentrum – Campuslaan 21 – 3590 Diepenbeek</div>
            </div>
            <div style="clear: both;"></div>
         </div>
         <div class="row-fluid itemrow">
            <div style="float: left">
               <input type="checkbox" name="opt2" value="1"></input>
            </div>
            <div style="float: left">
               <div style="margin-left: 2px;"><font color="#29a3dd">&nbsp;Voorstelling SKILLVILLE <b>Antwerpen</b></font> – donderdag 16 mei 2013 – 17u00</div>
               <div style="margin-left: 16px;">KBC Antwerpen – Antwerpen toren – Schoenmarkt 35 – 2000</div>
               <div style="margin-left: 16px;">Antwerpen</div>
            </div>
            <div style="clear: both;"></div>
         </div>
         <div class="row-fluid itemrow">
            <div style="float: left">
               <input type="checkbox" name="opt3" value="1"></input>
            </div>
            <div style="float: left">
               <div style="margin-left: 2px;"><font color="#29a3dd">&nbsp;Voorstelling SKILLVILLE <b>Vlaams-Brabant</b></font> op woensdag 29 mei om 17u00</div>
               <div style="margin-left: 16px;">KBC Leuven – Brusselsesteenweg 100 – 3000 Leuven</div>
            </div>
            <div style="clear: both;"></div>
         </div>
         <div class="row-fluid itemrow">
            <div style="float: left">
               <input type="checkbox" name="opt4" value="1"></input>
            </div>
            <div style="float: left">
               <div style="margin-left: 2px;"><font color="#29a3dd">&nbsp;Voorstelling SKILLVILLE <b>Gent</b></font> op donderdag 30 mei om 17u00</div>
               <div style="margin-left: 16px;">KBC Gent – Arteveldetoren – Kortrijksesteenweg 1100 – 9051 Gent</div>
            </div>
            <div style="clear: both;"></div>
         </div>

		</fieldset>
		
         <div class="row-fluid" style="margin-top: 24px;">
            <div class="span4" style="text-align: right;"><b>Naam:</b> </div>
            <div class="span8"><input style="width: 100%;" type="text" name="naam" value=""></input></div>
         </div>
         <div class="row-fluid">
            <div class="span4" style="text-align: right;"><b>Voornaam: </b></div>
            <div class="span8"><input style="width: 100%;" type="text" name="voornaam" value=""></input></div>
         </div>
         <div class="row-fluid">
            <div class="span4" style="text-align: right;"><b>E-mailadres: </b></div>
            <div class="span8"><input style="width: 100%;" type="text" name="email" value=""></input></div>
         </div>
         <div class="row-fluid">
            <div class="span4" style="text-align: right;"><b>School / Organisatie: </b></div>
            <div class="span8"><input style="width: 100%;" type="text" name="school" value=""></input></div>
         </div>
         <div class="row-fluid" style="margin-top: 20px; margin-bottom:20px;">
            <div class="span12" style="text-align: center;"><input class="btn btn-success" style="width: 20%;" type="submit" name="submit" value="Inschrijven"></input>&nbsp; Inschrijven kan ook via mail: <a href="mailto:info@skillville.be">info@skillville.be</a></div>
         </div>
       </form>
		 <div class="row-fluid">
			<div style="text-align: center;">
				
			</div> 
		 </div>
       
    </div>
  </body>
</html>

