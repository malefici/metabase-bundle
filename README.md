## Installation

```
composer require malefici/metabase-bundle
```

## Configuration

Create configuration file `config/packages/metabase.yaml`

```
metabase:
    # The base URL where users access Metabase, e.g. https://metabase.example.com or https://example.com/metabase.
    site_url: '%env(resolve:MB_SITE_URL)%'

    # Secret key used to sign JSON Web Tokens for requests to /api/embed endpoints.
    secret_key: '%env(resolve:MB_EMBEDDING_SECRET_KEY)%'

    # All parameters below are not required; their default values are presented in this configuration.

    # Date and time modifier, see https://www.php.net/manual/en/datetime.formats.php
    token_expiration: +1 hour

    # Customizing the appearance of static embeds. Settings from paid plans are not included.
    border: true
    title: true
    theme: light  # Available values: light, dark, transparent.
```

## Twig functions

### metabase_embedded

Example:

```
{{ metabase_embedded('question', 1, { productId: 10 }) }}
```

## Template overriding

It is very easy to do. Please read [Symfony documentation](https://symfony.com/doc/current/bundles/override.html) about templates overriding.

You may use special param to pass data to your custom template. 

```
{{ metabase_embedded('question', 1, { productId: 10 }, { style: 'border: solid 1px red;' }) }}
```

## Commands

Currently, there is only one command.

### metabase:generate-url

## TODO

 - Downgrade requirements to Symfony 6.4
 - Unit-tests
