Simple bootstrap for php gearman workers

This executes the boilerplate code normally required to get a gearman worker
running. If running it on a tty it will also output some standard logging to
assist in debugging.

### How to install ###
    pear channel-discover hradtke.github.com/pear
    pear install hradtke/gearboot

This script makes currently makes the assumption that the filename matches the
worker function name. 

### Examples ###
Starting a gearman worker in ./reverse.php

    gearboot -f reverse

The output will look something like:

    hradtke@dev01 ~/projects/gearboot !! gearboot -f reverse
    Gearman worker running... press Ctrl-c to stop
    Listening for function: reverse
    Received job: H:dev01.hermanradtke.com:2
    Finished job: H:dev01.hermanradtke.com:2
    Received job: H:dev01.hermanradtke.com:3
    Finished job: H:dev01.hermanradtke.com:3
    Received job: H:dev01.hermanradtke.com:4
    Finished job: H:dev01.hermanradtke.com:4
    Received job: H:dev01.hermanradtke.com:5
    Finished job: H:dev01.hermanradtke.com:5
