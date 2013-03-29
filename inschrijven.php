<?php
   if (isset($_POST['submit']))
   {
      mysql_connect('localhost', 'root', '');
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

      $subject = 'Spammage';
      $message = 'Auto-generated by the Skillville Spambot.';

      if (!@mail($data['email'], $subject, $message))
      {
         // What to do if the email address is not valid or something.
         // ...
         // perhaps remove the record and request re-registration?
      }

      exit('OK'); // Perhaps redirect to start page here?
   }
?>
<html>
  <head>
   <title>SkillVille.be - Oefenen van levensvaardigheden</title>
   <meta charset="utf-8" />
   <link type="text/css" href="./slov/css/bootstrap.min.css" rel="stylesheet" />
   <style type="text/css">
      .itemrow { margin-bottom: 12px; }
   </style>
  </head>
  <body>
    <div style="margin: 32px; width: 500px;">
       <h3>Activiteiten - inschrijven</h3>
       <form method="post" action="#">
         <div class="row-fluid itemrow">
            <div style="float: left">
               <input type="checkbox" name="opt1" value="1"></input>
            </div>
            <div style="float: left">
               <div style="margin-left: 2px;">Voorstelling SkillVille Limburg – woensdag 15 mei 2013 – 9u30</div>
               <div style="margin-left: 16px;">KHLim Onderzoekscentrum – Campuslaan 21 – 3590 Diepenbeek</div>
            </div>
            <div style="clear: both;"></div>
         </div>
         <div class="row-fluid itemrow">
            <div style="float: left">
               <input type="checkbox" name="opt2" value="1"></input>
            </div>
            <div style="float: left">
               <div style="margin-left: 2px;">Voorstelling SkillVille Antwerpen – donderdag 16 mei 2013 – 17u00</div>
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
               <div style="margin-left: 2px;">Voorstelling SkillVille te Vlaams-Brabant op woensdag 29 mei om 17u00</div>
               <div style="margin-left: 16px;">KBC Leuven – Brusselsesteenweg 100 – 3000 Leuven</div>
            </div>
            <div style="clear: both;"></div>
         </div>
         <div class="row-fluid itemrow">
            <div style="float: left">
               <input type="checkbox" name="opt4" value="1"></input>
            </div>
            <div style="float: left">
               <div style="margin-left: 2px;">Voorstelling SkillVille te Gent op donderdag 30 mei om 17u00</div>
               <div style="margin-left: 16px;">KBC Gent – Arteveldetoren – Kortrijksesteenweg 1100 – 9051 Gent</div>
            </div>
            <div style="clear: both;"></div>
         </div>
         <div class="row-fluid" style="margin-top: 24px;">
            <div class="span4" style="text-align: right;">Naam: </div>
            <div class="span8"><input style="width: 100%;" type="text" name="naam" value=""></input></div>
         </div>
         <div class="row-fluid">
            <div class="span4" style="text-align: right;">Voornaam: </div>
            <div class="span8"><input style="width: 100%;" type="text" name="voornaam" value=""></input></div>
         </div>
         <div class="row-fluid">
            <div class="span4" style="text-align: right;">e-mailadres: </div>
            <div class="span8"><input style="width: 100%;" type="text" name="email" value=""></input></div>
         </div>
         <div class="row-fluid">
            <div class="span4" style="text-align: right;">Verbonden aan school: </div>
            <div class="span8"><input style="width: 100%;" type="text" name="school" value=""></input></div>
         </div>
         <div class="row-fluid">
            <div class="span12" style="text-align: center;"><input style="width: 40%;" type="submit" name="submit" value="Inschrijven"></input></div>
         </div>
       </form>
       Inschrijven kan ook via mail aan <a href="mailto:edict@khlim.be">edict@khlim.be</a>
    </div>
  </body>
</html>

