# Sortable
Easy sorting for Eloquent models.

---
[![Build Status](https://travis-ci.org/kenarkose/Sortable.svg?branch=master)](https://travis-ci.org/kenarkose/Sortable)
[![Total Downloads](https://poser.pugx.org/kenarkose/Sortable/downloads)](https://packagist.org/packages/kenarkose/Sortable)
[![Latest Stable Version](https://poser.pugx.org/kenarkose/Sortable/version)](https://packagist.org/packages/kenarkose/Sortable)
[![License](https://poser.pugx.org/kenarkose/Sortable/license)](https://packagist.org/packages/kenarkose/Sortable)

Sortable provides a simple way to sort Eloquent models through model scopes.

## Features
- Compatible with Laravel 5
- Simple API for sorting Eloquent models through supplied scope
- Sorting key and direction validation
- A [phpunit](http://www.phpunit.de) test suite for easy development

## Installation
Installing Sortable is simple.

1. Pull this package in through [Composer](https://getcomposer.org).

    ```js
    {
        "require": {
            "kenarkose/sortable": "~1.0"
        }
    }
    ```

2. You may now use the trait and the supplied scope for sorting models.
    ```php

    class Post extends Eloquent
    {
        use Kenarkose\Sortable\Sortable;

        protected $sortableColumns = ['title', 'created_at']; // You must define this property

        protected $sortableKey = 'title'; // This is optional, default is id

        protected $sortableDirection = 'desc'; // This is optional, default is asc

        ...
    }

    Post::sortable('title', 'asc')->get();
    Post::sortable('title')->get(); // Direction is loaded from request or fallsback to default
    Post::sortable()->get(); // Key and direction are loaded from request or fallback to default
    Post::sortable(null, null)->get(); // Same
    ```

3. Additionally, you may use the helper method to generate links.
    ```php
    {{ sortable_link($sortable_key, $link_text_or_content, $link_title }}

    <a title="Link Title" class="asc" href="http://foo.bar/posts?s=sortable_key&d=asc">Link text or content</a>

    // If the supplied key is currently used for sorting the helper toggles direction and adds the active class to the link
    <a title="Link Title" class="desc active" href="http://foo.bar/posts?s=current_key&d=asc">Link text or content</a>

    // The helper only removes 's', 'd' and 'page' parameters from the previous query string
    <a title="Link Title" class="asc" href="http://foo.bar/posts?s=sortable_key&d=asc&keywords=kenarkose&foo=bar">Link text or content</a>
    ```

Please check the tests and source code for further documentation, as the source code of Sortable is well tested and documented.

## License
Sortable is released under [MIT License](https://github.com/kenarkose/Sortable/blob/master/LICENSE).