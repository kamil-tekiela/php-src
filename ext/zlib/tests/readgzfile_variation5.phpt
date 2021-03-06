--TEST--
Test function readgzfile() by substituting argument 1 with int values.
--EXTENSIONS--
zlib
--FILE--
<?php


$use_include_path = false;


$variation = array (
    'int 0' => 0,
    'int 1' => 1,
    'int 12345' => 12345,
    'int -12345' => -2345,
    );


foreach ( $variation as $var ) {
  var_dump(readgzfile( $var ,  $use_include_path ) );
}
?>
--EXPECTF--
Warning: readgzfile(0): Failed to open stream: No such file or directory in %s on line %d
bool(false)

Warning: readgzfile(1): Failed to open stream: No such file or directory in %s on line %d
bool(false)

Warning: readgzfile(12345): Failed to open stream: No such file or directory in %s on line %d
bool(false)

Warning: readgzfile(-2345): Failed to open stream: No such file or directory in %s on line %d
bool(false)
