<?php

  /* -----------------------------------
  	Script: 	Alfred all the memes
  	Author: 	Claas Lange
  	Usage:		meme line1|line2
  	Desc:		Create an "All the things meme using Alfred".
  	Updated:	18/05/12
  ----------------------------------- */

  $username = "";
  $password = "";

  function str_lreplace($search, $replace, $subject)
  {
      $pos = strrpos($subject, $search);

      if($pos === false)
      {
          return $subject;
      }
      else
      {
          return substr_replace($subject, $replace, $pos, strlen($search));
      }
  }



  //Pull hostname off of the command line
  $q = $argv[1];
  $q = stripslashes($q);
  $lines = explode("|",$q);
  $lines[0] = urlencode($lines[0]);
  $lines[1] = urlencode($lines[1]);

  //$q = utf8_encode($q);
  //Retrieve synonyms from openthesaurus
  $url 		= "http://version1.api.memegenerator.net/Instance_Create?username=".$username."&password=".$password."&languageCode=en&generatorID=318065&imageID=1985197&text0=".$lines[0]."&text1=".$lines[1];

  $crl 		= curl_init();
  $timeout 	= 10;
  curl_setopt ($crl, CURLOPT_URL, $url);
  curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
  $def 		= curl_exec($crl);
  curl_close  ($crl);

  //Search the result text to determine the status
  $response = json_decode($def);

  //var_dump($lines);
  if($response->success) {
    $url = "http://images.memegenerator.net/instances/400x/".$response->result->instanceID.".jpg";
    $var = "echo ".$url." | pbcopy";

    shell_exec($var);
    //shell_exec("open ".$url);
    echo "Bild in die Zwischenablage kopiert!";
  } else {
    echo "Leider ist ein Fehler aufgetreten";
  }

  //Return status
