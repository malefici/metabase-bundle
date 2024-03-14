Symfony Metabase Bundle
=======================

The small bundle makes embedding dashboards and questions slightly easier.

Supported Metabase versions:

| Metabase version | Bundle version |
|:----------------:|:--------------:|
|       0.48       |     0.0.3      |


## Installation and configuration

```
composer require malefici/metabase-bundle
```

There is no Flex Recipe for now. It will be added later.

Create configuration file `config/packages/metabase.yaml`

```
metabase:
    # The base URL where users access Metabase, e.g. https://metabase.example.com or https://example.com/metabase.
    site_url: '%env(resolve:MB_SITE_URL)%'

    # Secret key used to sign JSON Web Tokens for requests to /api/embed endpoints.
    secret_key: '%env(resolve:MB_EMBEDDING_SECRET_KEY)%'

    # All parameters below are not required; their default values are presented in this configuration.

    # Date and time modifier, see https://www.php.net/manual/en/datetime.formats.php
    token_expiration: '+1 hour'

    # Customizing the appearance of static embeds. Settings from paid plans are not included.
    appearance:
        border: true
        title: true
        theme: light # Available values: light, dark, transparent.
```

Define environment variables in the `.env` file:

```
MB_SITE_URL=https://metabase.example.com
MB_EMBEDDING_SECRET_KEY=76ff41a84ed1c6b294528b8339ab357173c020d767119c571d931eae27bd07d5
```


## Twig functions

### `metabase_embedded`

Example:

```
{{ metabase_embedded('question', 1, { question_parameter: 10 }) }}
```


## Template overriding

Please read [Symfony documentation](https://symfony.com/doc/current/bundles/override.html) about templates overriding.

You may pass additional data to your custom template:

```
{{ metabase_embedded('dashboard', 1, { dashboard_parameter: 10 }, { my_template_variable: 'value' }) }}
```


## Commands

The list of CLI commands.


### `metabase:embedding:generate-token`

Token generation for embedding.


### `metabase:embedding:generate-url`

URL generation for embedding.


## TODO

 - Flex Recipe
 - Downgrade requirements to Symfony 6.4
 - Unit-tests
 - API requests
