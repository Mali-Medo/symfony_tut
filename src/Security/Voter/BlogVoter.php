<?php

namespace App\Security\Voter;

use App\Entity\Blog;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class BlogVoter extends Voter
{
    private Security $security;

    public function __construct(Security $security)
    {

        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['MANAGE'])
            && $subject instanceof Blog;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var Blog $subject*/
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'MANAGE':
                // logic to determine if the user can EDIT
                // return true or false
                if($subject->getAuthor() == $user){
                    return true;
                }

                if($this->security->isGranted('ROLE_ADMIN_BLOG')){
                    return true;
                }
                return false;
        }

        return false;
    }
}
