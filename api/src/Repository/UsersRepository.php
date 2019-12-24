<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry as ManagerRegistryInterface;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    /** EntityManager $manager */
    private $manager;

    /** UserPasswordEncoderInterface $encoder */
    private $encoder;

    private $logger;

    /**
     * UsersRepository constructor.
     * @param ManagerRegistryInterface $registry
     * @param UserPasswordEncoderInterface $encoder
     * @param LoggerInterface $logger
     */
    public function __construct(ManagerRegistryInterface $registry, UserPasswordEncoderInterface $encoder, LoggerInterface $logger)
    {
        parent::__construct($registry, Users::class);
        $this->manager = $registry->getManager();
        $this->encoder = $encoder;
        $this->logger = $logger;
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Create a new user
     * @param $data
     * @return Users
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createNewUser($data)
    {
        try {
            $user = new Users();
            $user->setEmail($data['email'])
                ->setPassword($this->encoder->encodePassword($user, $data['password']));

            $this->manager->persist($user);
            $this->manager->flush();

            $log = [
                'status' => "success",
                'messages' => 'Successfully Inserted the user data %s', $data['email']
            ];
            $this->logger->info('User Creation Success', $log);
        }catch (\Exception $e){
            $log = [
                'status' => "erro",
                'messages' => json_encode($e->getMessage())
            ];
            $this->logger->error('User Creation FAILED', $log);
        }

        return $user;
    }
}
