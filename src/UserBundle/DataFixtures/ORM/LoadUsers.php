<?php
namespace UserBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


class LoadUsers implements FixtureInterface, ContainerAwareInterface {
	/**
	 * @var ContainerInterface
	 */
	private $container;

	public function load( ObjectManager $manager ) {
		$user = new User();
		$user->setUsername( 'solo' );
		$user->setPassword( $this->encodePassword($user,'mypass') );
		$manager->persist( $user );

		$admin = new User();
		$admin->setUsername( 'admin' );
		$admin->setPassword( $this->encodePassword($admin,'adminpass') );
		$admin->setRoles(array("ROlE_ADMIN"));

		$manager->persist( $admin );

		$manager->flush();

	}


	/**
	 * Sets the container.
	 *
	 * @param ContainerInterface|null $container A ContainerInterface instance or null
	 */
	public function setContainer( ContainerInterface $container = null ) {
		// TODO: Implement setContainer() method.
		$this->container = $container;
	}

	private function encodePassword( User $user, $plainPassword ) {
		$encoder = $this->container->get( 'security.encoder_factory' )
			->getEncoder($user);

		return$encoder->encodePassword($plainPassword,
			$user->getSalt());

	}
}