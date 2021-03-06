<?php

/*
 * The MIT License
 *
 * Copyright 2018 Daniel Popiniuc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

require_once str_replace('source', 'vendor', __DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

$appN                = new \danielgp\git_operations\GitLogNormalize();
$appN->checkClientCalling();
$inParameters        = $appN->checkInputParameters([
    'strInputFormat:'       => 'input format (switches)', // Mandatory value
    'strInputPath:'         => 'input path', // Mandatory value
    'strInputFileName:'     => 'input file', // Mandatory value
    'strOutputHeaderLabel:' => 'configured header', // Mandatory value
    'strOutputPath:'        => 'input path', // Mandatory value
    'strOutputFileName:'    => 'output file', // Mandatory value
    ]);
$strInputFile        = $appN->checkFileExistance($inParameters['strInputPath'], $inParameters['strInputFileName']);
$contentInputFileRaw = $appN->getFileEntireContent($strInputFile);
$arrayInputContent   = $appN->readInputFile($contentInputFileRaw);
$app                 = new \danielgp\git_operations\GitLogOutput();
$app->createOutputFile($inParameters, $arrayInputContent, $inParameters['strOutputHeaderLabel']);
