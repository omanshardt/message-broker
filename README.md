# RabbitMQ Examples

## Setup

Call this script to setup one exchange and one queue and bind them to each other.

```bash
php setup.php
```

## Consumer

Call this script to consume messages from the queue. You will be asked for the queue name.

```bash
php consumer.php
```

## Producer

Call this script to produce messages to the exchange. You will be asked for the exchange name.

```bash
php producer.php
```