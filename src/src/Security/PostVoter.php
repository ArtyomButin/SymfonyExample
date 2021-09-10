<?php

namespace App\Security;

use App\Entity\Users;
use App\Entity\Product;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PostVoter extends Voter
{

    const VIEW = 'view';
    const BUY = 'buy';
    private $decisionManager;

    /**
     * @param AccessDecisionManagerInterface $decisionManager
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::VIEW, self::BUY])) {
            return false;
        }

        if (!$subject instanceof Product) {
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }

        $user = $token->getUser();

        if (!$user instanceof Users) {
            return false;
        }

        $product = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canViewProduct($product, $user);
            case self::BUY:
                return $this->canBuyProduct($product, $user);
        }
        throw new LogicException('This code should not be reached!');
    }

    /**
     * @param Product $product
     * @param Users $user
     * @return bool
     */
    private function canViewProduct(Product $product, Users $user): bool
    {
        if ($this->canBuyProduct($product, $user)) {
            return true;
        }

        return !$product->isPremium();
    }

    /**
     * @param Product $product
     * @param Users $user
     * @return bool
     */
    private function canBuyProduct(Product $product, Users $user): bool
    {
        return $user->isPremiumClient() && $product->isPremium();
    }
}
