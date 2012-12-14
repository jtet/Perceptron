Perceptron
==========

[![Build Status](https://secure.travis-ci.org/jtet/Perceptron.png?branch=master)](https://travis-ci.org/jtet/Perceptron)

##What is a Perceptron?

```
"the perceptron is an algorithm for supervised classification of an input into one of two possible outputs.
It is a type of linear classifier, i.e. a classification algorithm that makes its predictions based on a
linear predictor function combining a set of weights with the feature vector describing a given input."
```
read more at [http://en.wikipedia.org/wiki/Perceptron](http://en.wikipedia.org/wiki/Perceptron)

##Training

```php
while($p->getIterationError() > $x)
{
    for ($i = 0; $i < count($inputVectors); $i++){
        $p->train($inputVectors[$i], $outcomes[$i);
    }
}
```

##Test an Input

```php
echo $p->test($inputVector)? "True": "False";
```

##Example

The following code trains the Perceptron to act as a [NAND gate](http://en.wikipedia.org/wiki/NAND_gate)

```php
$p = new \JTet\Perceptron\Perceptron(2);

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
```

##Getting Perceptron

Add the following to your [composer.json](http://getcomposer.org) file and run `composer update`.

```
"require": {
        "jtet/perceptron": "dev-master"
    }
```

##License
Perceptron is available for your use under the [OSL-3.0](http://www.spdx.org/licenses/OSL-3.0#licenseText) license.