<?php
namespace JTet\Perceptron;

class Perceptron
{
    protected $vectorLength;
    protected $bias;
    protected $learningRate;

    protected $weightVector;
    protected $iterations = 0;

    protected $errorSum = 0;
    protected $iterationError;

    /**
     * @param $vectorLength
     * @param $bias
     * @param $learningRate
     * @throws \InvalidArgumentException
     */
    public function __construct($vectorLength, $bias, $learningRate)
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
            $this->weightVector[$i] = 1 / $this->vectorLength;
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
     * @return int
     */
    public function getBias()
    {
        return $this->bias;
    }

    /**
     * @param int $bias
     */
    public function setBias($bias)
    {
        $this->bias = $bias;
    }

    /**
     * @return int
     */
    public function getIterationError()
    {
        return $this->iterationError;
    }

    /**
     * @param $inputVector
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function test($inputVector)
    {
        if (!is_array($inputVector) || count($inputVector) != $this->vectorLength) {
            throw new \InvalidArgumentException();
        }

        $testResult = $this->dotProduct($this->weightVector, $inputVector) + $this->bias;

        return $testResult > 0 ? true : false;
    }

    /**
     * @param array $inputVector
     * @param bool $outcome
     * @throws \InvalidArgumentException
     */
    public function train($inputVector, $outcome)
    {
        if (!is_array($inputVector) || !is_bool($outcome)) {
            throw new \InvalidArgumentException();
        }

        $this->iterations += 1;

        $output = $this->test($inputVector);

        for ($i = 0; $i < $this->vectorLength; $i++) {
            $this->weightVector[$i] =
                $this->weightVector[$i] + $this->learningRate * ((int)$outcome - (int)$output) * $inputVector[$i];
        }

        $this->errorSum += (int)$outcome - (int)$output;
        $this->iterationError = 1 / $this->iterations * $this->errorSum;
    }

    /**
     * @param array $vector1
     * @param array $vector2
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