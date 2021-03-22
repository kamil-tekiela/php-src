--TEST--
mysqli_fetch_assoc()
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

$res = mysqli_query($link, "SELECT id, label FROM test ORDER BY id LIMIT 1");

print "[001]\n";
var_dump(mysqli_fetch_column($res));

print "[002]\n";
var_dump(mysqli_fetch_column($res));


$link->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);

$res = mysqli_query($link, "SELECT
    1 AS a,
    2 AS a
");
print "[003]\n";
var_dump(mysqli_fetch_column($res, 0));

$res = mysqli_query($link, "SELECT
    1 AS a,
    2 AS a
");
print "[004]\n";
var_dump(mysqli_fetch_column($res, 1));

$res = mysqli_query($link, "SELECT
    1 AS a,
    2 AS a,
    3
");
print "[005]\n";
var_dump(mysqli_fetch_column($res, 2));

$res = mysqli_query($link, "SELECT
    1 AS a,
    2 AS a,
    3,
    NULL AS d
");
print "[006]\n";
var_dump(mysqli_fetch_column($res, 3));

$res = mysqli_query($link, "SELECT
    1 AS a,
    2 AS a,
    3,
    NULL AS d,
    true AS e
");
print "[007]\n";
var_dump(mysqli_fetch_column($res, 4));

$res = mysqli_query($link, "SELECT id, label FROM test ORDER BY id LIMIT 1");
print "[008]\n";
try {
    var_dump(mysqli_fetch_column($res, -1));
} catch (\ValueError $e) {
    echo $e->getMessage(), \PHP_EOL;
}

$res = mysqli_query($link, "SELECT id, label FROM test ORDER BY id LIMIT 1");
print "[009]\n";
try {
    var_dump(mysqli_fetch_column($res, 2));
} catch (\ValueError $e) {
    echo $e->getMessage(), \PHP_EOL;
}

mysqli_free_result($res);
try {
	mysqli_fetch_column($res);
} catch (Error $exception) {
	echo $exception->getMessage() . "\n";
}

$res = $link->query("SELECT id, label FROM test ORDER BY id LIMIT 2");

print "[010]\n";
var_dump($res->fetch_column());

print "[011]\n";
var_dump($res->fetch_column(1));

mysqli_close($link);

print "done!";
?>
--CLEAN--
<?php
require_once "clean_table.inc";
?>
--EXPECT--
[001]
string(1) "1"
[002]
bool(false)
[003]
int(1)
[004]
int(2)
[005]
int(3)
[006]
NULL
[007]
int(1)
[008]
Column index must be greater than or equal to 0
[009]
Invalid column index
mysqli_result object is already closed
[010]
int(1)
[011]
string(1) "b"
done!
