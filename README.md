README
======

Master: [![Build Status](https://travis-ci.org/jeroenvdheuvel/twig-relative-cache-key-bundle.svg?branch=master)](https://travis-ci.org/jeroenvdheuvel/twig-relative-cache-key-bundle)

Description
-----------
Makes Twig cache keys relative and therefor reusable across different environments/directory structures.

The default \Symfony\Bundle\TwigBundle\Loader\FilesystemLoader returns an absolute path as cache key.
For instance /var/www/project or /home/user/project with the same project content would generate a different cache key.

By removing the absolute part, the cache becomes reusable and cache only need to be generated once.
