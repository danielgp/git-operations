<?php

/*
 * The MIT License
 *
 * Copyright 2017 - 2018 Daniel Popiniuc
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

namespace danielgp\git_operations;

class GitLogOutput
{

    use \danielgp\io_operations\InputOutputFiles,
        HandleSwitches;

    private $arraySpecialSwitches = [];
    private $configDetailsArray   = [];

    public function createOutputFile($arrayParameters, $arrayInputContent, $headerLabel)
    {
        $handleOutputFile = $this->openFileSafelyAndReturnHandle($arrayParameters['strOutputPath']
            . $arrayParameters['strOutputFileName'], 'w+', 'write');
        $this->getOutputHeader($handleOutputFile, $headerLabel);
        $this->scanForSpecialSwitches($arrayParameters);
        foreach ($arrayInputContent as $lineContent) {
            fwrite($handleOutputFile, $this->handleLineContent([
                    'Line Content'              => $lineContent,
                    'Special Switches List'     => $this->configDetailsArray['Special Switches'],
                    'Special Switches Position' => $this->arraySpecialSwitches,
                ]) . PHP_EOL);
        }
        fclose($handleOutputFile);
        unlink($arrayParameters['strInputPath'] . $arrayParameters['strInputFileName']);
    }

    private function getOutputHeader($handleOutputFile, $headerLabel)
    {
        $strConfigPath            = str_replace('source' . DIRECTORY_SEPARATOR . 'classes', 'config', __DIR__);
        $this->configDetailsArray = $this->getArrayFromJsonFile($strConfigPath, 'config-git-parameters.json');
        fwrite($handleOutputFile, implode(';', $this->configDetailsArray['Headers for Export'][$headerLabel]) . PHP_EOL);
    }

    private function scanForSpecialSwitches($arrayParameters)
    {
        $knownSwitches = array_keys($this->configDetailsArray['Special Switches']);
        $arrayHeaders  = explode(';', str_replace('%', '', $arrayParameters['strInputFormat']));
        foreach ($arrayHeaders as $keySwitch => $valueSwitch) {
            if (in_array($valueSwitch, $knownSwitches)) {
                $this->arraySpecialSwitches[$valueSwitch] = $keySwitch;
            }
        }
    }
}
