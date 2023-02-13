<?php
$command = shell_exec('ps -axu | grep u0428181 | grep php | grep -v "grep" | wc -l');
$command2 = shell_exec('ps -axu | grep u0428181 | grep -v "grep" | wc -l');
$command3 = shell_exec('ps -axu | grep u0428181 | grep -v "grep"');
echo "<pre>Total PHP processes: $command</br>Total ALL processes: $command2</br>List of processes:</br>$command3</pre>";