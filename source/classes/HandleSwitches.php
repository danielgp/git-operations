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

trait HandleSwitches
{

    use \danielgp\io_operations\InputOutputTiming;

    protected function handleLineContent($inParameters)
    {
        $linePieces = explode(';', $inParameters['Line Content']);
        if ($inParameters['Special Switches Position'] != []) {
            foreach ($inParameters['Special Switches Position'] as $strKey => $intKeyPosition) {
                $strPotentialSpecialValue = $this->handleSpecialSwitchValue($linePieces, [
                    'Special Switches List' => $inParameters['Special Switches List'],
                    'Special Key'           => $strKey,
                    'Special Key Position'  => $intKeyPosition,
                ]);
                if ($strPotentialSpecialValue !== '') {
                    $linePieces[] = $strPotentialSpecialValue;
                }
            }
        }
        return implode(';', $linePieces);
    }

    private function handleSpecialSwitchValue($linePieces, $inParameters)
    {
        $sReturn = '';
        switch ($inParameters['Special Switches List'][$inParameters['Special Key']]) {
            case 'Date Time in ISO 8601 Format':
                if (array_key_exists($inParameters['Special Key Position'], $linePieces)) {
                    $sReturn = $this->convertDateTimeToUtcTimeZone($linePieces[$inParameters['Special Key Position']]);
                }
                break;
        }
        return $sReturn;
    }
}
