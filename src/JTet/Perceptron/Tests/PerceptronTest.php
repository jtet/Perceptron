<?php
/**
 * JTet\Perceptron\Test
 * https://github.com/jtet/Perceptron
 *
 * Please see http://www.spdx.org/licenses/OSL-3.0#licenseText
 * for license information.
 */
namespace JTet\Perceptron\Tests;

/**
 * Common Linearly Seperable Functions which are known to be
 * learnable by a Perceptron and tests to ensure coverage
 */
class PerceptronTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the learning of the NAND function
     */
    public function testNAND()
    {
        $p = new \JTet\Perceptron\Perceptron(2, 0, .1);

        $i = 0;
        while($i < 1000)
        {
            $input = array(0, 0);
            $output = 1;
            $p->train($input, $output);

            $input = array(0, 1);
            $output = 1;
            $p->train($input, $output);

            $input = array(1,0);
            $output = 1;
            $p->train($input, $output);

            $input = array(1,1);
            $output = 0;
            $p->train($input, $output);

            $i++;
        }

        $this->assertFalse((bool) $p->test(array(1,1)));
        $this->assertTrue((bool) $p->test(array(0,1)));
        $this->assertTrue((bool) $p->test(array(1,0)));
        $this->assertTrue((bool) $p->test(array(0,0)));
    }

    /**
     * Tests the learning of the AND function
     */
    public function testAND()
    {
        $p = new \JTet\Perceptron\Perceptron(2, 0, .1);

        $i = 0;
        while($i < 1000)
        {
            $input = array(0, 0);
            $output = 0;
            $p->train($input, $output);

            $input = array(0, 1);
            $output = 0;
            $p->train($input, $output);

            $input = array(1,0);
            $output = 0;
            $p->train($input, $output);

            $input = array(1,1);
            $output = 1;
            $p->train($input, $output);

            $i++;
        }

        $this->assertTrue((bool) $p->test(array(1,1)));
        $this->assertFalse((bool) $p->test(array(0,1)));
        $this->assertFalse((bool) $p->test(array(1,0)));
        $this->assertFalse((bool) $p->test(array(0,0)));
    }

    /**
     * Tests the learning of the OR function
     */
    public function testOR()
    {
        $p = new \JTet\Perceptron\Perceptron(2, 0, .1);

        $i = 0;
        while($i < 1000)
        {
            $input = array(0, 0);
            $output = 0;
            $p->train($input, $output);

            $input = array(0, 1);
            $output = 1;
            $p->train($input, $output);

            $input = array(1,0);
            $output = 1;
            $p->train($input, $output);

            $input = array(1,1);
            $output = 1;
            $p->train($input, $output);

            $i++;
        }

        $this->assertTrue((bool) $p->test(array(1,1)));
        $this->assertTrue((bool) $p->test(array(0,1)));
        $this->assertTrue((bool) $p->test(array(1,0)));
        $this->assertFalse((bool) $p->test(array(0,0)));
    }

    /**
     * Tests the learning of the NOR function
     */
    public function testNOR()
    {
        $p = new \JTet\Perceptron\Perceptron(2, 0, .1);

        $i = 0;
        while($i < 1000)
        {
            $input = array(0, 0);
            $output = 1;
            $p->train($input, $output);

            $input = array(0, 1);
            $output = 0;
            $p->train($input, $output);

            $input = array(1,0);
            $output = 0;
            $p->train($input, $output);

            $input = array(1,1);
            $output = 0;
            $p->train($input, $output);

            $i++;
        }

        $this->assertFalse((bool) $p->test(array(1,1)));
        $this->assertFalse((bool) $p->test(array(0,1)));
        $this->assertFalse((bool) $p->test(array(1,0)));
        $this->assertTrue((bool) $p->test(array(0,0)));
    }

    /**
     * Tests vectorLength param requirements
     */
    public function testConstructorVectorLengthException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new \JTet\Perceptron\Perceptron(0);
    }

    /**
     * Tests learningRate param requirements
     */
    public function testConstructorLearningRateException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new \JTet\Perceptron\Perceptron(2, 0, -1);
    }

    /**
     * Tests getter and setter for weightVector
     */
    public function testWeightVectorGetSet()
    {
        $p = new \JTet\Perceptron\Perceptron(2);
        $this->assertCount(2, $p->getWeightVector());

        $p->setWeightVector(array(1,1));
        $this->assertEquals(array(1,1), $p->getWeightVector());
    }

    /**
     * Tests weightVector param requirements
     */
    public function testWeightVectorSetException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $p = new \JTet\Perceptron\Perceptron(2);
        $p->setWeightVector(array(1,1,1));
    }

    /**
     * Tests getter for output
     */
    public function testOutputGet()
    {
        $p = new \JTet\Perceptron\Perceptron(2);
        $p->test(array(0,0));

        $this->assertNotNull($p->getOutput());
    }

    /**
     * tests output not set exception
     */
    public function testOutputGetException()
    {
        $this->setExpectedException('\RuntimeException');
        $p = new \JTet\Perceptron\Perceptron(2);
        $p->getOutput();
    }


    /**
     * Tests getter and setter for bias
     */
    public function testBiasGetSet()
    {
        $p = new \JTet\Perceptron\Perceptron(2);
        $p->setBias(1.3);

        $this->assertEquals(1.3, $p->getBias());
    }

    /**
     * tests bias param requirements
     */
    public function testBiasSetException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $p = new \JTet\Perceptron\Perceptron(2);
        $p->setBias("test");
    }

    /**
     * Tests getter and setter for learningRate
     */
    public function testLearningRateGetSet()
    {
        $p = new \JTet\Perceptron\Perceptron(2);
        $p->setLearningRate(0.6);
        $this->assertEquals(0.6, $p->getLearningRate());
    }

    /**
     * tests learningRate param requirements
     */
    public function testLearningRateSetException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $p  = new \JTet\Perceptron\Perceptron(2);
        $p->setLearningRate(1.4);
    }

    /**
     * tests iterationError getter
     */
    public function testIterationErrorGet()
    {
        $p = new \JTet\Perceptron\Perceptron(2);
        $this->assertTrue(is_numeric($p->getIterationError()));
    }

    /**
     * tests train param requirements
     */
    public function testTrainException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $p = new \JTet\Perceptron\Perceptron(2);
        $p->train(3, true);
    }

    /**
     * tests test param requirements
     */
    public function testTestException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $p = new \JTet\Perceptron\Perceptron(2);
        $p->test("test");
    }

}