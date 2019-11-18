<?php

use ACME\_01Lexer\ScriptLexer;
use ACME\_01Lexer\Token;

require_once __DIR__ . '/vendor/autoload.php';

$script = <<<EOT
a=2+3*6;
b=10*(25+33)/-a;
print "eredmény:"; //Ez meg egy komment
print b;
EOT;

$lexer = new ScriptLexer($script);
$token = $lexer->getNextToken();
while ($token->getTokenType() != Token::TTEOF) {
    print $token . "\n";
    $token = $lexer->getNextToken();
}
