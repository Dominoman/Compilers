<?php

use ACME\_03VM\ScriptLexer;
use ACME\_03VM\ScriptParser;
use ACME\_03VM\VM\VMCreator;

require_once __DIR__ . '/vendor/autoload.php';

$script = <<<EOT
a=2+3*6;
b=10*(25+33)/-a;
print "eredmény:"; //Ez meg egy komment
print b;
EOT;

$lexer = new ScriptLexer($script);
$parser = new ScriptParser($lexer);
$vmc = new VMCreator();
$ast = $parser->parse();
while ($ast != null) {
    $ast->compileMe($vmc);
    $ast = $parser->parse();
}
$vmc->vm->run();
