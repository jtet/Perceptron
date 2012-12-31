<?php
/**
 * JTet\Perceptron
 * https://github.com/jtet/Perceptron
 *
 * Please see http://www.spdx.org/licenses/OSL-3.0#licenseText
 * for license information.
 */
namespace JTet\Perceptron;

/**
 * Perceptron for more information see:
 * http://en.wikipedia.org/wiki/Perceptron
 */
class Perceptron
{
    protected $vectorLength;
    protected $bias;
    protected $learningRate;

    protected $weightVector;
    protected $iterations = 0;

    protected $errorSum = 0;
    protected $iterationError = 0;
    protected $output = null;

    /**
     * @param int   $vectorLength The number of input signals
     * @param float $bias         Bias factor
     * @param float $learningRate The learning rate 0 < x <= 1
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($vectorLength, $bias = 0.0, $learningRate = .5)
    {
        if ($vectorLength < 1) {
            throw new \InvalidArgumentException();
        } elseif ($learningRate <= 0 || $learningRate > 1) {
            throw new \InvalidArgumentException();
        }

        $this->vectorLength = $vectorLength;
        $this->bias = $bias;
        $this->learningRate = $learningRate;

        for ($i = 0; $i < $this->vectorLength; $i++) {
            $this->weightVector[$i] = rand()/getrandmax() * 2 - 1;
        }
    }

    public function getOutput()
    {
        if(is_null($this->output))
        {
            throw new \RuntimeException();
        }
        else
        {
            return $this->output;
        }
    }

    /**
     * @return array
     */
    public function getWeightVector()
    {
        return $this->weightVector;
    }

    /**
     * @param array $weightVector
     *
     * @throws \InvalidArgumentException
     */
    public function setWeightVector($weightVector)
    {
        if (!is_array($weightVector) || count($weightVector) != $this->vectorLength) {
            throw new \InvalidArgumentException();
        }
        $this->weightVector = $weightVector;
    }

    /**
     * @return int
     */
    public function getBias()
    {
        return $this->bias;
    }

    /**
     * @param float $bias
     *
     * @throws \InvalidArgumentException
     */
    public function setBias($bias)
    {
        if (!is_numeric($bias)) {
            throw new \InvalidArgumentException();
        }
        $this->bias = $bias;
    }

    /**
     * @return float
     */
    public function getLearningRate()
    {
        return $this->learningRate;
    }

    /**
     * @param float $learningRate
     *
     * @throws \InvalidArgumentException
     */
    public function setLearningRate($learningRate)
    {
        if (!is_numeric($learningRate) || $learningRate <= 0 || $learningRate > 1) {
            throw new \InvalidArgumentException();
        }
        $this->learningRate = $learningRate;
    }

    /**
     * @return int
     */
    public function getIterationError()
    {
        return $this->iterationError;
    }

    /**
     * @param array $inputVector
     *
     * @return int (0 for false, 1 = true)
     * @throws \InvalidArgumentException
     */
    public function test($inputVector)
    {
        if (!is_array($inputVector) || count($inputVector) != $this->vectorLength) {
            throw new \InvalidArgumentException();
        }

        $testResult = $this->dotProduct($this->weightVector, $inputVector) + $this->bias;

        $this->output = $testResult > 0 ? 1 : 0;
        return $this->output;
    }

    /**
     * @param array $inputVector array of input signals
     * @param int  $outcome      1 = true / 0 = false
     *
     * @throws \InvalidArgumentException
     */
    public function train($inputVector, $outcome)
    {
        if (!is_array($inputVector) || !($outcome == 0 || $outcome == 1)) {
            throw new \InvalidArgumentException();
        }

        $this->iterations += 1;

        $output = $this->test($inputVector);

        for ($i = 0; $i < $this->vectorLength; $i++) {
            $this->weightVector[$i] =
                $this->weightVector[$i] + $this->learningRate * ((int) $outcome - (int) $output) * $inputVector[$i];
        }

        $this->bias = $this->bias + ((int) $outcome - (int) $output);

        $this->errorSum += (int) $outcome - (int) $output;
        $this->iterationError = 1 / $this->iterations * $this->errorSum;
    }

    /**
     * @param array $vector1
     * @param array $vector2
     *
     * @return number
     */
    private function dotProduct($vector1, $vector2)
    {
        return array_sum(
            array_map(
                function ($a, $b) {
                    return $a * $b;
                },
                $vector1,
                $vector2
            )
        );
    }

}