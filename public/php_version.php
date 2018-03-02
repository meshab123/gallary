<?php
//check version of php installed in local machine
$version = phpversion();
print $version;
echo "<pre>";
 print_r(phpversion());
echo "</pre>";
//saving file in AWS 
$aws = new Aws($config);
$bucket = $aws->s3->bucket('my-bucket');
$object = $bucket->object('images/bird.jpg');
//access resources
echo $object['lastModified'];
//call resource methods and delete a file aws
$object->delete();
$bucket->delete();



