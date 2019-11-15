<?php

use ACME\_04Advanced\ScriptLexer;
use ACME\_04Advanced\ScriptParser;
use ACME\_04Advanced\VM\VMCreator;

require_once __DIR__ . '/vendor/autoload.php';

$script = <<<EOT
//Fibonacci
a=1;b=1;i=0;
while(i<10){
    if(i<2){
        print " 1";
    }else {
        c=a+b;
        print c;
        a=b; b=c;
    }
    i=i+1;
}
print "kesz";
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
