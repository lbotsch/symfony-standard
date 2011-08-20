<?php

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$vendorDir = '/usr/local/lib/symfony-2/vendor';

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'          => array($vendorDir.'/symfony/src', $vendorDir.'/bundles'),
    'Sensio'           => $vendorDir.'/bundles',
    'JMS'              => $vendorDir.'/bundles',
    'Doctrine\\Common' => $vendorDir.'/doctrine-common/lib',
    'Doctrine\\DBAL'   => $vendorDir.'/doctrine-dbal/lib',
    'Doctrine'         => $vendorDir.'/doctrine/lib',
    'Monolog'          => $vendorDir.'/monolog/src',
    'Assetic'          => $vendorDir.'/assetic/src',
    'Metadata'         => $vendorDir.'/metadata/src',
));
$loader->registerPrefixes(array(
    'Twig_Extensions_' => $vendorDir.'/twig-extensions/lib',
    'Twig_'            => $vendorDir.'/twig/lib',
));

// intl
if (!function_exists('intl_get_error_code')) {
    require_once $vendorDir.'/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->registerPrefixFallbacks(array($vendorDir.'/symfony/src/Symfony/Component/Locale/Resources/stubs'));
}

$loader->registerNamespaceFallbacks(array(
    __DIR__.'/../src',
    $vendorDir.'/bundles',
));
$loader->register();

AnnotationRegistry::registerLoader(function($class) use ($loader) {
    $loader->loadClass($class);
    return class_exists($class, false);
});
AnnotationRegistry::registerFile($vendorDir.'/doctrine/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

// Swiftmailer needs a special autoloader to allow
// the lazy loading of the init file (which is expensive)
require_once $vendorDir.'/swiftmailer/lib/classes/Swift.php';
Swift::registerAutoload($vendorDir.'/swiftmailer/lib/swift_init.php');

