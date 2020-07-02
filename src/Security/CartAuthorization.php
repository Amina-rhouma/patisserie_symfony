<?php


namespace App\Security;
use App\Entity\Cake;
use App\Entity\Verrine;
use App\Entity\User;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class CartAuthorization extends Voter
{
    public const VIEW_CART = 'view_cart';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports(string $attribute, $subject) {

        // Gerer les cas pour ajouter un produit => pas besoin de verifier $subject car pas encore existant
        if ($attribute === self::VIEW_CART) {
            return true;
        }

        return false;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param mixed $subject
     *
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token) {

        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if (in_array("ROLE_USER", $token->getRoleNames())) {
            return true;
        }

        return false;
    }
}