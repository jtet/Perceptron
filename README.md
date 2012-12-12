Perceptron
==========

##Training

    while($p->getIterationError() > $x)
    {
        for ($i = 0; $i < count($inputVectors); $i++){
            $p->train($inputVectors[$i]);
        }
    }

##Test an Input

    echo $p->test($inputVector)? "True": "False";

##Example

The following code trains the Perceptron to act as a [NAND gate](http://en.wikipedia.org/wiki/NAND_gate)

    $p = new \JTet\Perceptron\Perceptron(2, 0, .1);

    $i = 0;
    while($i < 100000)
    {
        $input = array(0, 0);
        $output = true;
        $p->train($input, $output);

        $input = array(0, 1);
        $output = true;
        $p->train($input, $output);

        $input = array(1,0);
        $output = true;
        $p->train($input, $output);

        $input = array(1,1);
        $output = false;
        $p->train($input, $output);

        $i++;
    }

    echo $p->test(array(1,1))? "Incorrect\n": "Correct\n";
    echo $p->test(array(0,1))? "Correct\n": "Incorrect\n";
    echo $p->test(array(0,0))? "Correct\n": "Incorrect\n";
    echo $p->test(array(1,0))? "Correct\n": "Incorrect\n";

##Getting Perceptron

Add the following to your [composer.json](http://getcomposer.org) file and run `composer update`.

```
"require": {
        "jtet/perceptron": "dev-master"
    }
```

##License
Perceptron is available for your use under the [OSL-3.0](http://www.spdx.org/licenses/OSL-3.0#licenseText) license.