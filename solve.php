<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// script start time.
$t1 = (int) (microtime(true) * 1000);

//isPrime function copied from stackexchange.
function isPrime($num) {
    //1 is not prime. See: http://en.wikipedia.org/wiki/Prime_number#Primality_of_one
    if($num == 1)
        return false;

    //2 is prime (the only even number that is prime)
    if($num == 2)
        return true;

    /**
     * if the number is divisible by two, then it's not prime and it's no longer
     * needed to check other even numbers
     */
    if($num % 2 == 0) {
        return false;
    }

    /**
     * Checks the odd numbers. If any of them is a factor, then it returns false.
     * The sqrt can be an aproximation, hence just for the sake of
     * security, one rounds it to the next highest integer value.
     */
    $ceil = ceil(sqrt($num));
    for($i = 3; $i <= $ceil; $i = $i + 2) {
        if($num % $i == 0)
            return false;
    }

    return true;
}

// if a value passed through CLI then use it. otherwise set to default. 
$max = isset($argv[1]) ? (int)$argv[1] : 1000000;

// generate max number of primes to be used later.
$primes = [];
for($i=2; $i < $max; $i++) {
    if(isPrime($i)) {
        $primes[] = $i;
    }
}


$primeSums = [];
$psum = 0;
$pSumPrimes = [];
$j=0;
$primesCount = count($primes);
$summedPrimesCount = 0;


for($i=0; $i < $primesCount; $i++) {
    $p = $primes[$i];
    $psum += $p;
    $summedPrimesCount++;
    
    
    if($psum > $max) {
        $j++;
        $i = $j;
        $psum=0;
        $summedPrimesCount = 0;
        continue;
    }
    
    if(isPrime($psum)) {
        
        if(!isset($primeSums[$psum]) or (isset($primeSums[$psum]) and $primeSums[$psum] < $summedPrimesCount) ) {
            $primeSums[$psum] = $summedPrimesCount;
        }
        
    }
    
    
}

// sort the array so that value with max prime count must go at the end of array.
asort($primeSums);
end($primeSums);
$key = key($primeSums);
$summedPrimesCount = $primeSums[$key];

echo "\n\n";
echo ("Largest prime below $max  is ".key($primeSums))."\n";
echo "it consists of $summedPrimesCount primes\n";

// calculate time spent
$t2 = (int) (microtime(true) * 1000);
$t3 = $t2 - $t1;
echo("time spent = ". $t3)." miliseconds\n";
echo "\n\n";