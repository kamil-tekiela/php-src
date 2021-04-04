--TEST--
mysqli_fetch_all() with MYSQLI_COLUMN and MYSQLI_CLASS
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

class NoProperties {

}

$res = mysqli_query($link, "SELECT id, label FROM test ORDER BY id LIMIT 2");

print "[004]\n";
var_dump($res->fetch_all(MYSQLI_CLASS));

print "[005]\n";
var_dump($res->fetch_all(MYSQLI_CLASS, NoProperties::class));

print "[006]\n";
var_dump(mysqli_fetch_all($res, MYSQLI_CLASS, NoProperties::class));

mysqli_free_result($res);
try {
    $res->fetch_all(MYSQLI_CLASS);
} catch (Error $exception) {
    echo $exception->getMessage() . "\n";
}

mysqli_close($link);

print "done!";
?>
--CLEAN--
<?php
// require_once "clean_table.inc";
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
[004]
array(2) {
  [0]=>
  object(stdClass)#3 (2) {
    ["id"]=>
    int(1)
    ["label"]=>
    string(1) "a"
  }
  [1]=>
  object(stdClass)#6 (2) {
    ["id"]=>
    int(2)
    ["label"]=>
    string(1) "b"
  }
}
[005]
array(2) {
  [0]=>
  object(NoProperties)#6 (2) {
    ["id"]=>
    int(1)
    ["label"]=>
    string(1) "a"
  }
  [1]=>
  object(NoProperties)#3 (2) {
    ["id"]=>
    int(2)
    ["label"]=>
    string(1) "b"
  }
}
[006]
array(2) {
  [0]=>
  object(NoProperties)#3 (2) {
    ["id"]=>
    int(1)
    ["label"]=>
    string(1) "a"
  }
  [1]=>
  object(NoProperties)#6 (2) {
    ["id"]=>
    int(2)
    ["label"]=>
    string(1) "b"
  }
}
mysqli_result object is already closed
done!
