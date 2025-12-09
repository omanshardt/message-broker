<?php


function create_or_select_exchange($handle)
{
    echo "Enter exchange name: ";
    $exchange = trim(fgets($handle));
    if (empty($exchange)) {
        $exchange = 'logs'; // Default
    }
    return $exchange;
}
function create_or_select_queue($handle)
{
    echo "Select queue name:\n";
    echo "1) basic_queue\n";
    echo "2) task_queue\n";
    echo "3) pubsub_queue\n";
    echo "4) other\n";
    echo "Enter selection [1]: ";

    $line = trim(fgets($handle));

    $queue = 'basic_queue';

    switch ($line) {
        case '2':
            $queue = 'task_queue';
            break;
        case '3':
            $queue = 'pubsub_queue';
            break;
        case '4':
            echo "Enter queue name: ";
            $customQueue = trim(fgets($handle));
            if (!empty($customQueue)) {
                $queue = $customQueue;
            }
            break;
        default:
            // Default is basic_queue
            break;
    }

    return $queue;
}
