<?php

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new Friendsevents\Bundle\FrontBundle\FriendseventsFrontBundle(),
            new FOS\UserBundle\FOSUserBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
        $this->overrideParametersWithEnvironmentVariables($loader);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return $this->getVarDir() . '/cache/' . $this->getName() . '/' . $this->environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return $this->getVarDir() . '/logs/' . $this->getName();
    }

    /**
     * Get var directory path
     *
     * @return string
     */
    protected function getVarDir()
    {
        return $this->rootDir . '/../var';
    }

    protected function overrideParametersWithEnvironmentVariables(LoaderInterface $loader)
    {
        $envParameters = $this->getEnvParameters();

        $loader->load(function(ContainerInterface $container) use($envParameters) {
            $appName = $this->getName();
            if ('_' === substr($appName, -1)) {
                // It seems that are building a Symfony compiled container (app name ends with "_")
                // --> let's display the environment variables config overrides:
                echo "\033[36m" . sprintf(
                        'app config overrides with ENV variables: %s',
                        json_encode($envParameters, JSON_PRETTY_PRINT)
                    ) . "\033[0m" . PHP_EOL ;
            }

            $container->getParameterBag()->add($envParameters);
        });
    }
}
