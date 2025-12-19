# RabbitMQ Examples

## Setup

**setup_fanout**

Call this script to setup one exchange of type 'fanout and one queue and bind them to each other.

```bash
php setup_fanout.php
```

## Reset

**reset**

Call this script to reset the RabbitMQ server to it's default values. This deletes all custom exchanges, queues, bindings and users.

```bash
php reset.php
```

## Consumer

**consumer_1, consumer_2**

Call one of the following scripts to consume messages from the queue. You will be asked for the queue name.

```bash
php consumer_1.php
php consumer_2.php
```
The created consumer will open a connection and consume messages from the queue using specific credentials.

consumer_1.php will consume messages from the queue using no_ack = true.

- This means that the consumer will not auto-acknowledge the message.
- The message will not be auto-deleted from the queue.
- In ths exampe the user is being asked to acknowledge the message manually
<!-- - If the consumer crashes, the message will be requeued. -->

consumer_2.php will consume messages from the queue using no_ack = false.

- This means that the consumer will auto-acknowledge the message.
- The message will be auto-deleted from the queue.
<!-- - If the consumer crashes, the message will not be requeued. -->

## Producer

**producer_1, producer_2**

Call one of the following scripts to produce messages to the exchange. You will be asked for the exchange name.

```bash
php producer_1.php
php producer_2.php
```
The created producer will open a connection and produce messages to the exchange using specific credentials.

## User

**user_create**

Call this script to create a user with specific permissions.

```bash
php user_create.php
```

**users_create**

Call this script to create multiple users with specific permissions.

```bash
php users_create.php
```

**user_delete**

Call this script to delete a user.

```bash
php user_delete.php
```
