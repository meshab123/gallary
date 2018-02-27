<?php

//if safe mode is 'on' in php.ini file it means, we don't have the ability/access to manipulate the file that we
//don't own
    echo __FILE__ ."<br />";
    echo __LINE__ ."<br />";
    echo dirname(__FILE__)."<br />";
    echo __DIR__."<br />";
    echo file_exists(__DIR__) ? 'yes' : 'no'."<br />";
    echo file_exists(__DIR__). "/basic.html" ? 'yes' : 'no'."<br />";
      echo "<br />";
  // echo is_dir(dirname(__FILE__)) ? 'yes' : 'no'."<br />";
   echo phpinfo();
    echo "<br />";

  echo fileowner('database.php');
// $owner_id = fileowner('database.php');
// $owner_array = posix_getpwuid($owner_id);
// echo $owner_array['name'];

// echo substr(decoct(fileperms('config.php')),2);

    echo is_readable('config.php') ? 'Yes' : 'no';
    echo is_writable('database.php') ? 'yes' : 'no';

//file permission

echo "<hr />";

$file = 'testfile.txt';

  if ($handle = fopen($file, 'w')){

      //fclose($handle);
      fwrite($handle, 'abc'); // number of bytes or false;
      fwrite($handle, '123'); // number of bytes or false;
      $content = "Himesh\n123";
      fwrite($handle,$content);

      fclose($handle);
    } else {
      echo "Could not open file for writing";
  }
echo "<hr />";

// file_put_contents: shortcut for fopen/fwrite/fclose
  //file_put_contents($file, $content);
//delete file
//unlink('testfile.txt');

//$pos = ftell($handle); //tell the curor position
//       fseek($handle, $pso-6);
//       rewind($handle, "Hear I am again")


?>