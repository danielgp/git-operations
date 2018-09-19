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

class GitLogNormalize
{

    use \danielgp\io_operations\InputOutputOperations,
        \danielgp\io_operations\InputOutputFiles;

    private function handleSpecialChangesOutput($lineContent)
    {
        if ((strpos($lineContent, 'insertion') === false) && ((strpos($lineContent, 'deletion') !== false))) {
            $lineContent = str_replace('changed, ', 'changed, 0 insertion(+), ', $lineContent);
        }
        return $this->tweakInputFileLine($lineContent);
    }

    public function readInputFile($contentInputFile)
    {
        $arrayInputContent = [];
        $outCounter        = 0;
        foreach ($contentInputFile as $lineContent) {
            $strFirstCharacter = substr($lineContent, 0, 1);
            if ($strFirstCharacter === ' ') {
                $arrayInputContent[($outCounter - 1)] .= $this->handleSpecialChangesOutput($lineContent);
            } elseif ($strFirstCharacter !== ' ') {
                $arrayInputContent[$outCounter] = $lineContent;
                $outCounter++;
            }
        }
        return $arrayInputContent;
    }

    private function tweakInputFileLine($lineContent)
    {
        $inOut = [
            ' files changed, ' => ';',
            ' file changed, '  => ';',
            ' insertions(+), ' => ';',
            ' insertions(+)'   => ';0',
            ' insertion(+), '  => ';',
            ' insertion(+)'    => ';0',
            ' deletions(-)'    => '',
            ' deletion(-)'     => '',
        ];
        return str_replace(array_keys($inOut), array_values($inOut), substr($lineContent, 1, strlen($lineContent)));
    }
}
