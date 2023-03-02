<?php

namespace App\Service;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AbstractFactory
{
    private ContainerInterface $container;
    private $serviceName;
    private $namespace;

    /**
     * @param ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $className
     * @return ?object
     * @throws NotFoundHttpException
     */
    public function create(string $className): ?object
    {
        $className = basename(str_replace('\\', '/', $className));
        $class = get_class($this);
        $this->serviceName = basename(str_replace('\\', '/', $class));
        $this->namespace = preg_replace('/' . $this->serviceName . '$/u', '', $class);
        $this->serviceName = basename(str_replace('\\', '/', $this->namespace));
        $className = ucfirst($className);
        $findClass = $this->findExistsClass($className);
        return $this->container->get($findClass);
    }

    private function findExistsClass($className): string
    {
        $names = [
            $className => 0,
            $className . $this->serviceName => 0
        ];

        foreach ($names as $name => $count) {
            $className = $this->namespace . $name;
            if (class_exists($className)) {
                $exitClass = $className;
                $names[$name]++;
            }
        }

        $sum = array_sum($names);
        if ($sum === 0) {
            throw new NotFoundHttpException("class $className not found");
        } elseif ($sum === 1) {
            return $exitClass;
        }
        throw new UnprocessableEntityHttpException("find more 1 ($sum) classes $className");
    }
}
