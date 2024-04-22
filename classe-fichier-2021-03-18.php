<?php
   class fichier {
      /*
      |----------------------------------------------------------------------------------|
      | attributs
      |----------------------------------------------------------------------------------|
      */
      private $fp = null;
      public  $intNbLignes = null;
      public  $intTaille = null;
      public  $strLigneCourante = null;
      public  $strNom = null;
      public  $strContenu = null;
      public  $strContenuHTML= null;
      public  $tContenu = array();
      /* Ajouté le 2020-04-14 */
      public  $strMode = null;
      
      /*
      |------------------------------------------------------------------------------------------------------|
      | constructeur (2020-03-22; 2020-04-14)
      | Réf. : https://www.php.net/manual/fr/function.func-get-arg.php
      |        https://www.php.net/manual/fr/function.func-num-args.php
      | Deuxième paramètre (facultatif) : Ouvre le fichier selon le mode passé en paramètre
      |------------------------------------------------------------------------------------------------------|
      */
      function __construct($strNomFichier) {
         $this->strNom = $strNomFichier;
         if (func_num_args() == 2) {
            $this->ouvre(func_get_arg(1));
         }
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | chargeEnMemoire() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://php.net/manual/fr/function.count.php
      |       http://ca.php.net/manual/fr/function.file.php
      |       http://php.net/manual/fr/function.file-get-contents.php
      |       http://ca.php.net/manual/fr/function.str-replace.php
      |       http://php.net/manual/fr/function.strlen.php
      |----------------------------------------------------------------------------------|
      */
      function chargeEnMemoire() {
         /* Récupère toutes les lignes et les entrepose dans un tableau
            Retrait de tous les CR et LF
            Récupère le nombre de lignes */
         $this->tContenu = file($this->strNom);
         $this->tContenu = str_replace("\n", "", str_replace("\r", "", $this->tContenu));
         $this->intNbLignes = count($this->tContenu);

         /* Récupère toutes les lignes et les entrepose dans une chaîne */
         $this->strContenu = file_get_contents($this->strNom);
         $this->intTaille = strlen($this->strContenu);

         /* Entrepose la chaîne résultante dans une autre après l'avoir XHTMLisé ! */
         $this->strContenuHTML = str_replace("\n\r", "<br />",
                                 str_replace("\r\n", "<br />", $this->strContenu));
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | compteLignes() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://ca.php.net/manual/fr/function.count.php
      |       http://ca.php.net/manual/fr/function.file.php
      |----------------------------------------------------------------------------------|
      */
      function compteLignes() {
         $this->intNbLignes = -1;
         if ($this->existe()) {
            $this->intNbLignes = count(file($this->strNom));
         }
         return $this->intNbLignes;
      }
      
      /*
      |------------------------------------------------------------------------------------------------------|
      | copie (2020-04-14)
      | Réf.: https://www.php.net/manual/fr/function.copy.php
      |       https://www.php.net/manual/fr/function.file-exists.php
      |       https://www.php.net/manual/fr/function.pathinfo.php 
      |       https://www.php.net/manual/fr/function.sprintf.php
      | Si aucun paramètre, "fichier.txt" => "fichier (001).txt", puis "fichier (002).txt", etc.
      | Si un paramètre est fourni, alors "fichier.txt" => "nouveau fichier.txt" (ce dernier ne doit pas existé)
      | La fonction retourne "true" ou "false".
      |------------------------------------------------------------------------------------------------------|
      */
      function copie() {
       $binCopieEffectuee = true;
         if (func_num_args() == 1) {
            $strNomFichierCible = func_get_arg(0);
            if (file_exists($strNomFichierCible)) {
               $binCopieEffectuee = false;
            }
            else {
               copy($this->strNom, $strNomFichierCible);
            }
         }
         else {
            $intNo = 1;
            $strNomCopieSecurite = pathinfo($this->strNom, PATHINFO_FILENAME);
            $strSuffixeCopieSecurite = pathinfo($this->strNom, PATHINFO_EXTENSION);
            while (file_exists($strNomCopieSecurite . " (" . sprintf("%03d", $intNo) . ")." . $strSuffixeCopieSecurite)) {
               $intNo++;
            }
            copy($this->strNom, $strNomCopieSecurite . " (" . sprintf("%03d", $intNo) . ")." . $strSuffixeCopieSecurite);
         }
         return $binCopieEffectuee;
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | detecteFin() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://php.net/manual/fr/function.feof.php
      |----------------------------------------------------------------------------------|
      */
      function detecteFin() {
         $binVerdict = true;
         if ($this->fp) {
            $binVerdict = feof($this->fp);
         }
         return $binVerdict;
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | ecritLigne() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://php.net/manual/fr/function.fputs.php
      |       http://php.net/manual/fr/function.gettype.php
      |----------------------------------------------------------------------------------|
      */
      function ecritLigne($strLigneCourante, $binSaut_intNbLignesSaut = false) {
         $binVerdict = fputs($this->fp, $strLigneCourante);
         if ($binVerdict) {
            switch (gettype($binSaut_intNbLignesSaut)) {
               case "integer" :
                  for ($i=1; $i<=$binSaut_intNbLignesSaut && $binVerdict; $i++) {
                     $binVerdict = fputs($this->fp, "\r\n");
                  }
                  break;
               case "boolean" :
                  if ($binSaut_intNbLignesSaut) {
                     $binVerdict = fputs($this->fp, "\r\n");
                  }
                  break;
            }
         }
         return $binVerdict;
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | existe() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://ca.php.net/manual/fr/function.file-exists.php
      |----------------------------------------------------------------------------------|
      */
      function existe() {
         return file_exists($this->strNom);
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | ferme() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://ca.php.net/manual/fr/function.fclose.php
      |----------------------------------------------------------------------------------|
      */
      function ferme() {
         $binVerdict = false;
         if ($this->fp) {
            $binVerdict = fclose($this->fp);
         }
         return $binVerdict;
      }
      
      /*
      |------------------------------------------------------------------------------------------------------|
      | identiqueA (2020-04-14)
      | Réf. : https://www.php.net/manual/fr/function.file-get-contents.php
      |------------------------------------------------------------------------------------------------------|
      */
      function identiqueA($strNomFichierAComparer) {
         return file_get_contents($this->strNom) == file_get_contents($strNomFichierAComparer);
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | litDonneesLigne() (2018-03-13; 2019-03-12; 2020-03-22)
      | Ref. : http://php.net/manual/fr/function.array-combine.php
      |        http://php.net/manual/fr/function.func-get-arg.php
      |        http://php.net/manual/fr/function.func-num-args.php
      |        http://stackoverflow.com/questions/6814760/php-using-explode-function-to-assign-values-to-an-associative-array
      |----------------------------------------------------------------------------------|
      */
      function litDonneesLigne(&$tValeurs, $strSeparateur) {
         for ($i=2; $i<=func_num_args() - 1 ; $i++) {
            $tValeurs[func_get_arg($i)] = func_get_arg($i);
         }
         $tValeurs = array_combine($tValeurs, explode($strSeparateur, $this->litLigne()));
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | litLigne() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://ca.php.net/manual/fr/function.fgets.php
      |       http://ca.php.net/manual/fr/function.str-replace.php
      |----------------------------------------------------------------------------------|
      */
      function litLigne() {
         $this->strLigneCourante = str_replace("\n", "",
                                   str_replace("\r", "", fgets($this->fp)));
         return $this->strLigneCourante;
      }
      
      /*
      |------------------------------------------------------------------------------------------------------|
      | ouvre() (2018-03-13; 2019-03-12; 2020-03-22; 2020-04-14)
      | Réf.: http://ca.php.net/manual/fr/function.fopen.php
      |       http://ca.php.net/manual/fr/function.strtoupper.php
      | Mise à jour du nouvel attribut '$strMode'
      |------------------------------------------------------------------------------------------------------|
      */
      function ouvre($strMode="L") {
         switch (strtoupper($strMode)) {
            case "A" :
               $strMode = "a";
               $this->strMode = "A";
               break;
            case "E" :
            case "W" :
               $strMode = "w";
               $this->strMode = "E";
               break;
            case "L" :
            case "R" :
               $strMode = "r";
               $this->strMode = "L";
               break;
         }
         $this->fp = fopen($this->strNom, $strMode);
         return $this->fp;
      }

      /*
      |------------------------------------------------------------------------------------------------------|
      | renommePour (2020-04-14)
      | Réf.: https://www.php.net/manual/fr/function.rename.php
      |------------------------------------------------------------------------------------------------------|
      */
      function renommePour($strNouveauNom) {
         rename($this->strNom, $strNouveauNom);
         $this->strNom = $strNouveauNom;
      }
      
   }
?>