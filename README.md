# RabbitMQ Examples

## Setup

**bin/deprecated/setup_fanout.php**

Call this script to setup one exchange of type 'fanout and one queue and bind the queue to the exchange. This is deprecated and only for reference.

```bash
php bin/deprecated/setup_fanout.php
```

**bin/deprecated/setup_direct.php**

Call this script to setup one exchange of type 'direct and three queues and bind them to the exchange. This is deprecated and only for reference.

```bash
php bin/deprecated/setup_direct.php
```

**bin/setup_env.php**

Call this script to setup exchanges, queues and bindings. Define which environment you want to setup with the first argument. Chose between 'fanout' and 'direct', 'topic' and 'headers'. Each environment will be created with one exchange and three queues and bindings. **This is the recommended way to setup the environment**. The number of queues and bindings and their properties can be adjusted in the config.php file.

```bash
php bin/setup_env.php fanout
php bin/setup_env.php direct
php bin/setup_env.php topic
php bin/setup_env.php headers
```

**bin/create_users.php**

Call this script to create users with specific permissions. This will create three producer-users of which two are hard-coded in the producer scripts and three consumer-users of which two are hard-coded in the consumer scripts. Consumer- and producer users are only differentiated by their names for better recognition.

```bash
php bin/create_users.php
```

**bin/create_user.php**

Call this script to create a user with specific permissions.

```bash
php bin/create_user.php
```

## Reset

**bin/reset.php**

Call this script to delete all custom exchanges, queues and bindings.

```bash
php bin/reset.php
```

**bin/users_delete.php**

Call this script to delete all users.

```bash
php bin/users_delete.php
```

## Consumer

**bin/consumer_1.php, bin/consumer_2.php**

Call one of the following scripts to consume messages from the queue. You will be asked for the queue name.

```bash
php bin/consumer_1.php
php bin/consumer_2.php
```
The created consumer will open a connection and consume messages from the queue using hard-coded credentials.

consumer_1.php will consume messages from the queue using no_ack = true.

- This means that the consumer will not auto-acknowledge the message.
- The message will not be auto-deleted from the queue.
- In this exampe the user is being asked to acknowledge the message manually.
- Furthermore the user is asked if the message should be re-queued or not.
<!-- - If the consumer crashes, the message will be requeued. -->

consumer_2.php will consume messages from the queue using no_ack = false.

- This means that the consumer will auto-acknowledge the message.
- The message will be auto-deleted from the queue.
<!-- - If the consumer crashes, the message will not be requeued. -->

## Producer

**bin/producer_1.php, bin/producer_2.php**

Call one of the following scripts to produce messages to the exchange. You will be asked for the exchange name.

```bash
php bin/producer_1.php
php bin/producer_2.php
```
The created producer will open a connection and sends a message to the exchange using hard-coded credentials. A binding key can be specified to send the message to a specific queue.

## User

**bin/user_create.php**

Call this script to create a user with specific permissions.

```bash
php bin/user_create.php
```

**bin/users_create.php**

Call this script to create multiple users with specific permissions.

```bash
php bin/users_create.php
```

**bin/user_delete.php**

Call this script to delete a user.

```bash
php bin/user_delete.php
```
