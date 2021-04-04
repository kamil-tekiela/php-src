--TEST--
mysqli_fetch_all() 1D-array with MYSQLI_COLUMN
--SKIPIF--
<?php
require_once 'skipif.inc';
require_once 'skipifconnectfailure.inc';
?>
--FILE--
<?php

require_once "connect.inc";
require 'table.inc';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);

$res = mysqli_query($link, "SELECT id, label FROM test ORDER BY id LIMIT 3");

print "[001]\n";
var_dump($res->fetch_all(MYSQLI_COLUMN));

print "[002]\n";
var_dump($res->fetch_all(MYSQLI_COLUMN, 1));

print "[003]\n";
var_dump(mysqli_fetch_all($res, MYSQLI_COLUMN, 1));

mysqli_free_result($res);
try {
	$res->fetch_all(MYSQLI_COLUMN);
} catch (Error $exception) {
	echo $exception->getMessage() . "\n";
}

mysqli_close($link);

print "done!";
?>
--CLEAN--
<?php
require_once "clean_table.inc";
?>
--EXPECT--
[001]
array(3) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [2]=>
  int(3)
}
[002]
array(3) {
  [0]=>
  string(1) "a"
  [1]=>
  string(1) "b"
  [2]=>
  string(1) "c"
}
[003]
array(3) {
  [0]=>
  string(1) "a"
  [1]=>
  string(1) "b"
  [2]=>
  string(1) "c"
}
mysqli_result object is already closed
done!
