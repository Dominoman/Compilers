<?php

use ACME\_05Asm\ScriptLexer;
use ACME\_05Asm\ScriptParser;
use ACME\_05Asm\VM\VMAsmExporter;

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

$vmc = new VMAsmExporter();
$ast = $parser->parse();
while ($ast != null) {
    $ast->compileMe($vmc);
    $ast = $parser->parse();
}

$template = "_05Asm\\template\\source.c64";
$output = "Output\\source.asm";
$fo = fopen($output, "w+");
fputs($fo, $vmc->getSource(file_get_contents($template)));
fclose($fo);

echo "Forrás generálva:" . $output;
