<?php
$version = phpversion();
print $version;

$aws = new Aws($config);
$bucket = $aws->s3->bucket('my-bucket');
$object = $bucket->object('images/bird.jpg');
//access resources
echo $object['lastModified'];
//call resource methods
$object->delete();
$bucket->delete();
