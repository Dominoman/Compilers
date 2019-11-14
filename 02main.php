<?php

use ACME\_02Parser\ScriptLexer;
use ACME\_02Parser\ScriptParser;

require_once __DIR__ . '/vendor/autoload.php';

$script = <<<EOT
a=2+3*6;
b=10*(25+33)/-a;
print "eredmény:"; //Ez meg egy komment
print b;
EOT;

$lexer = new ScriptLexer($script);
$parser = new ScriptParser($lexer);
$ast = $parser->parse();
while ($ast != null) {
    print $ast . "\n";
    print_r($ast);
    $ast = $parser->parse();
}
