<?php
namespace Plugin\CustomerIdLogin\Repository;

use Eccube\Repository\CustomerRepository as BaseRepository;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Common\Constant;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class CustomerRepository extends BaseRepository
{
    public function loadUserByUsername($username)
    {
        die("die");
        
        // 本会員ステータスの会員のみ有効.
        $CustomerStatus = $this
            ->getEntityManager()
            ->getRepository('Eccube\Entity\Master\CustomerStatus')
            ->find(CustomerStatus::ACTIVE);

        $query = $this->createQueryBuilder('c')
            ->where('c.email = :email')
            ->orWhere('c.id = :id')
            ->andWhere('c.del_flg = :delFlg')
            ->andWhere('c.Status =:CustomerStatus')
            ->setParameters(array(
                'email' => $username,
                'id' => $username,
                'delFlg' => Constant::DISABLED,
                'CustomerStatus' => $CustomerStatus,
            ))
            ->getQuery();
        $Customer = $query->getOneOrNullResult();
        if (!$Customer) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $Customer;
    }
}